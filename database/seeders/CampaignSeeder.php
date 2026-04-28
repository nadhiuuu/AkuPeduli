<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\DisasterCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignSeeder extends Seeder
{
    /**
     * Seed campaign data.
     */
    public function run(): void
    {
        $user = User::where('role', 'user')->first() ?? User::where('role', 'admin')->first();

        if (! $user) {
            return;
        }

        $this->ensureSampleImageExists();

        $categories = DisasterCategory::query()
            ->whereIn('slug', ['banjir', 'gempa-bumi', 'kebakaran'])
            ->get()
            ->keyBy('slug');

        $campaigns = [
            [
                'category_slug' => 'banjir',
                'title' => 'Bantuan Darurat untuk Korban Banjir di Bekasi',
                'description' => '<p>Hujan deras menyebabkan ratusan rumah terendam banjir di wilayah Bekasi. Donasi akan digunakan untuk paket makanan, selimut, obat-obatan, dan kebutuhan darurat bagi keluarga terdampak.</p>',
                'target_amount' => 150000,
                'current_amount' => 0,
                'end_date' => now()->addDays(21)->toDateString(),
                'status' => Campaign::STATUS_ACTIVE,
            ],
            [
                'category_slug' => 'gempa-bumi',
                'title' => 'Pemulihan Pasca Gempa untuk Warga Cianjur',
                'description' => '<p>Kami menggalang dukungan untuk membantu pemulihan rumah rusak, logistik pengungsian, dan kebutuhan anak-anak pasca gempa bumi di Cianjur.</p>',
                'target_amount' => 225000,
                'current_amount' => 0,
                'end_date' => now()->addDays(30)->toDateString(),
                'status' => Campaign::STATUS_ACTIVE,
            ],
            [
                'category_slug' => 'kebakaran',
                'title' => 'Bantu Keluarga Terdampak Kebakaran Permukiman',
                'description' => '<p>Kebakaran hebat menghanguskan permukiman warga dan meninggalkan banyak keluarga tanpa tempat tinggal. Donasi akan disalurkan untuk hunian sementara, perlengkapan sekolah, dan kebutuhan harian.</p>',
                'target_amount' => 100000,
                'current_amount' => 0,
                'end_date' => now()->addDays(10)->toDateString(),
                'status' => Campaign::STATUS_COMPLETED,
            ],
        ];

        foreach ($campaigns as $campaign) {
            $category = $categories->get($campaign['category_slug']);

            if (! $category) {
                continue;
            }

            Campaign::updateOrCreate(
                ['slug' => Str::slug($campaign['title'])],
                [
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'title' => $campaign['title'],
                    'slug' => Str::slug($campaign['title']),
                    'description' => $campaign['description'],
                    'image' => 'campaigns/sample-background.jpg',
                    'target_amount' => $campaign['target_amount'],
                    'current_amount' => $campaign['current_amount'],
                    'end_date' => $campaign['end_date'],
                    'status' => $campaign['status'],
                ],
            );
        }
    }

    private function ensureSampleImageExists(): void
    {
        $sourcePath = public_path('assets/Background.jpg');
        $targetPath = storage_path('app/public/campaigns/sample-background.jpg');

        if (! File::exists($sourcePath) || File::exists($targetPath)) {
            return;
        }

        Storage::disk('public')->makeDirectory('campaigns');
        File::copy($sourcePath, $targetPath);
    }
}
