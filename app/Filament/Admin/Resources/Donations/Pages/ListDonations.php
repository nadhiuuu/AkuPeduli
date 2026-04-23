<?php

namespace App\Filament\Admin\Resources\Donations\Pages;

use App\Filament\Admin\Resources\Donations\DonationResource;
use App\Models\Campaign;
use App\Models\Donation;
use App\Support\SimplePdf;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListDonations extends ListRecords
{
    protected static string $resource = DonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportPdf')
                ->label('PDF')
                ->icon('heroicon-o-document')
                ->color('danger')
                ->action('exportPdf'),
            Action::make('exportCsv')
                ->label('Excel')
                ->icon('heroicon-o-table-cells')
                ->color('success')
                ->action('exportCsv'),
        ];
    }

    public function exportPdf(): StreamedResponse
    {
        $records = $this->getExportQuery()->get();
        $totalDanaTerkumpul = (clone $this->getExportQuery())
            ->where('status', 'success')
            ->sum('gross_amount');
        $pdf = SimplePdf::fromStructuredPages($this->buildPdfPages($records, $totalDanaTerkumpul));

        return response()->streamDownload(
            static function () use ($pdf): void {
                echo $pdf;
            },
            $this->makeExportFileName('pdf'),
            ['Content-Type' => 'application/pdf'],
        );
    }

    public function exportCsv(): StreamedResponse
    {
        $records = $this->getExportQuery()->get();

        return response()->streamDownload(
            function () use ($records): void {
                $handle = fopen('php://output', 'w');

                if ($handle === false) {
                    return;
                }

                fwrite($handle, "\xEF\xBB\xBF");
                fputcsv($handle, ['Order ID', 'Donatur', 'Galang Dana', 'Jumlah', 'Status', 'Tanggal']);

                foreach ($records as $record) {
                    fputcsv($handle, [
                        $record->order_id,
                        $record->is_anonymous ? 'Hamba Allah (Anonim)' : $record->donor_name,
                        $record->campaign?->title,
                        number_format((float) $record->gross_amount, 0, ',', '.'),
                        $record->status,
                        $record->created_at?->format('d M Y H:i'),
                    ]);
                }

                fclose($handle);
            },
            $this->makeExportFileName('csv'),
            ['Content-Type' => 'text/csv; charset=UTF-8'],
        );
    }

    protected function getExportQuery(): Builder
    {
        return ($this->getFilteredSortedTableQuery() ?? Donation::query())
            ->with(['campaign', 'user']);
    }

    /**
     * @param  Collection<int, Donation>  $records
     * @return array<int, array{width: int, height: int, operations: array<int, array<string, mixed>>}>
     */
    protected function buildPdfPages(Collection $records, float|int $totalDanaTerkumpul): array
    {
        $pageWidth = 842;
        $pageHeight = 595;
        $marginLeft = 36;
        $marginRight = 36;
        $startY = 548;
        $rowHeight = 22;
        $footerY = 42;
        $headerBottomY = 455;
        $tableEndX = $pageWidth - $marginRight;

        $columns = [
            ['key' => 'order_id', 'label' => 'Order ID', 'x' => 36, 'width' => 130],
            ['key' => 'donor', 'label' => 'Donatur', 'x' => 170, 'width' => 135],
            ['key' => 'campaign', 'label' => 'Galang Dana', 'x' => 310, 'width' => 205],
            ['key' => 'amount', 'label' => 'Jumlah', 'x' => 520, 'width' => 90],
            ['key' => 'status', 'label' => 'Status', 'x' => 615, 'width' => 70],
            ['key' => 'date', 'label' => 'Tanggal', 'x' => 690, 'width' => 116],
        ];

        $rows = $records->map(function (Donation $record): array {
            return [
                'order_id' => $record->order_id,
                'donor' => $record->is_anonymous ? 'Hamba Allah (Anonim)' : ($record->donor_name ?? '-'),
                'campaign' => $record->campaign?->title ?? '-',
                'amount' => 'Rp ' . number_format((float) $record->gross_amount, 0, ',', '.'),
                'status' => strtoupper((string) $record->status),
                'date' => $record->created_at?->format('d M Y H:i') ?? '-',
            ];
        })->values()->all();

        $rowsPerPage = 16;
        $rowChunks = $rows === [] ? [[]] : array_chunk($rows, $rowsPerPage);
        $pages = [];

        foreach ($rowChunks as $pageIndex => $rowChunk) {
            $operations = [
                ['type' => 'text', 'text' => 'Laporan Data Donatur - AkuPeduli', 'x' => $marginLeft, 'y' => $startY, 'size' => 15, 'font' => 'bold'],
                ['type' => 'text', 'text' => 'Dicetak: ' . now()->format('d M Y H:i'), 'x' => $marginLeft, 'y' => $startY - 24, 'size' => 10, 'font' => 'regular'],
                ['type' => 'text', 'text' => 'Filter: ' . $this->getActiveFilterSummary(), 'x' => $marginLeft, 'y' => $startY - 42, 'size' => 10, 'font' => 'regular'],
                ['type' => 'line', 'x1' => $marginLeft, 'y1' => $headerBottomY + 18, 'x2' => $tableEndX, 'y2' => $headerBottomY + 18, 'width' => 1],
                ['type' => 'line', 'x1' => $marginLeft, 'y1' => $headerBottomY - 6, 'x2' => $tableEndX, 'y2' => $headerBottomY - 6, 'width' => 0.8],
            ];

            foreach ($columns as $column) {
                $operations[] = [
                    'type' => 'text',
                    'text' => $column['label'],
                    'x' => $column['x'],
                    'y' => $headerBottomY + 2,
                    'size' => 10,
                    'font' => 'bold',
                ];
            }

            if ($rowChunk === []) {
                $operations[] = [
                    'type' => 'text',
                    'text' => 'Tidak ada data donatur yang sesuai dengan filter saat ini.',
                    'x' => $marginLeft,
                    'y' => $headerBottomY - 34,
                    'size' => 10,
                    'font' => 'regular',
                ];
            }

            foreach ($rowChunk as $rowIndex => $row) {
                $y = $headerBottomY - 30 - ($rowIndex * $rowHeight);

                foreach ($columns as $column) {
                    $text = match ($column['key']) {
                        'campaign' => $this->truncatePdfText((string) $row[$column['key']], 34),
                        'donor' => $this->truncatePdfText((string) $row[$column['key']], 22),
                        'order_id' => $this->truncatePdfText((string) $row[$column['key']], 20),
                        'amount' => $this->truncatePdfText((string) $row[$column['key']], 16),
                        'status' => $this->truncatePdfText((string) $row[$column['key']], 10),
                        'date' => $this->truncatePdfText((string) $row[$column['key']], 18),
                        default => (string) $row[$column['key']],
                    };

                    $operations[] = [
                        'type' => 'text',
                        'text' => $text,
                        'x' => $column['x'],
                        'y' => $y,
                        'size' => 9,
                        'font' => 'regular',
                    ];
                }

                $operations[] = [
                    'type' => 'line',
                    'x1' => $marginLeft,
                    'y1' => $y - 8,
                    'x2' => $tableEndX,
                    'y2' => $y - 8,
                    'width' => 0.3,
                ];
            }

            if ($pageIndex === array_key_last($rowChunks)) {
                $totalLabel = 'Total Dana yang terkumpul';
                $totalValue = 'Rp ' . number_format((float) $totalDanaTerkumpul, 0, ',', '.');

                $operations[] = ['type' => 'line', 'x1' => 570, 'y1' => $footerY + 26, 'x2' => $tableEndX, 'y2' => $footerY + 26, 'width' => 0.8];
                $operations[] = ['type' => 'text', 'text' => $totalLabel, 'x' => 570, 'y' => $footerY + 10, 'size' => 10, 'font' => 'bold'];
                $operations[] = ['type' => 'text', 'text' => $totalValue, 'x' => 690, 'y' => $footerY + 10, 'size' => 10, 'font' => 'bold'];
            }

            $pages[] = [
                'width' => $pageWidth,
                'height' => $pageHeight,
                'operations' => $operations,
            ];
        }

        return $pages;
    }

    protected function getActiveFilterSummary(): string
    {
        $parts = [];
        $campaignId = $this->getTableFilterValue('campaign_id');
        $status = $this->getTableFilterValue('status');

        if ($campaignId) {
            $parts[] = 'Campaign ' . (Campaign::find($campaignId)?->title ?? $campaignId);
        }

        if ($status) {
            $parts[] = 'Status ' . strtoupper((string) $status);
        }

        if (filled($this->tableSearch)) {
            $parts[] = 'Pencarian "' . $this->tableSearch . '"';
        }

        return $parts === [] ? 'Semua data' : implode(' | ', $parts);
    }

    protected function getTableFilterValue(string $filter): mixed
    {
        $value = $this->tableFilters[$filter] ?? null;

        if (is_array($value)) {
            return $value['value'] ?? null;
        }

        return $value;
    }

    protected function makeExportFileName(string $extension): string
    {
        return 'data-donatur-' . now()->format('Ymd-His') . '.' . $extension;
    }

    protected function truncatePdfText(?string $value, int $width): string
    {
        $value = trim((string) ($value ?? '-'));
        $truncated = Str::limit($value, $width, '...');

        return $truncated === '' ? '-' : $truncated;
    }
}
