<?php

namespace App\Support;

class SimplePdf
{
    /**
     * @param  array<int, array{width: float|int, height: float|int, operations: array<int, array<string, mixed>>}>  $pages
     */
    public static function fromStructuredPages(array $pages): string
    {
        $objects = [];
        $pageObjectNumbers = [];

        $objects[] = '<< /Type /Catalog /Pages 2 0 R >>';
        $objects[] = '<< /Type /Pages /Kids __KIDS__ /Count ' . count($pages) . ' >>';
        $objects[] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>';
        $objects[] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>';

        foreach ($pages as $page) {
            $contentObjectNumber = count($objects) + 1;
            $pageObjectNumber = $contentObjectNumber + 1;
            $stream = self::buildOperationsStream($page['operations']);

            $objects[] = '<< /Length ' . strlen($stream) . " >>\nstream\n{$stream}\nendstream";
            $objects[] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 ' . $page['width'] . ' ' . $page['height'] . '] /Resources << /Font << /F1 3 0 R /F2 4 0 R >> >> /Contents ' . $contentObjectNumber . ' 0 R >>';

            $pageObjectNumbers[] = $pageObjectNumber;
        }

        $objects[1] = str_replace(
            '__KIDS__',
            '[' . implode(' ', array_map(fn (int $number): string => "{$number} 0 R", $pageObjectNumbers)) . ']',
            $objects[1],
        );

        return self::compile($objects);
    }

    /**
     * @param  array<int, array<string, mixed>>  $operations
     */
    private static function buildOperationsStream(array $operations): string
    {
        $commands = [];

        foreach ($operations as $operation) {
            $type = $operation['type'] ?? null;

            if ($type === 'text') {
                $font = ($operation['font'] ?? 'regular') === 'bold' ? 'F2' : 'F1';
                $size = (float) ($operation['size'] ?? 10);
                $x = (float) ($operation['x'] ?? 0);
                $y = (float) ($operation['y'] ?? 0);
                $text = self::escapeText((string) ($operation['text'] ?? ''));

                $commands[] = 'BT';
                $commands[] = "/{$font} {$size} Tf";
                $commands[] = sprintf('1 0 0 1 %.2F %.2F Tm', $x, $y);
                $commands[] = "({$text}) Tj";
                $commands[] = 'ET';
            }

            if ($type === 'line') {
                $x1 = (float) ($operation['x1'] ?? 0);
                $y1 = (float) ($operation['y1'] ?? 0);
                $x2 = (float) ($operation['x2'] ?? 0);
                $y2 = (float) ($operation['y2'] ?? 0);
                $width = (float) ($operation['width'] ?? 1);

                $commands[] = sprintf('%.2F w', $width);
                $commands[] = sprintf('%.2F %.2F m', $x1, $y1);
                $commands[] = sprintf('%.2F %.2F l', $x2, $y2);
                $commands[] = 'S';
            }
        }

        return implode("\n", $commands);
    }

    /**
     * @param  array<int, string>  $objects
     */
    private static function compile(array $objects): string
    {
        $pdf = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
        $offsets = [];

        foreach ($objects as $index => $object) {
            $offsets[] = strlen($pdf);
            $objectNumber = $index + 1;
            $pdf .= "{$objectNumber} 0 obj\n{$object}\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        foreach ($offsets as $offset) {
            $pdf .= sprintf('%010d 00000 n ', $offset) . "\n";
        }

        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n{$xrefOffset}\n%%EOF";

        return $pdf;
    }

    private static function escapeText(string $text): string
    {
        return str_replace(
            ['\\', '(', ')'],
            ['\\\\', '\\(', '\\)'],
            preg_replace('/[\r\n\t]+/', ' ', $text) ?? $text,
        );
    }
}
