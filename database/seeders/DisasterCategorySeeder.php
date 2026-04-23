<?php

namespace Database\Seeders;

use App\Models\DisasterCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DisasterCategorySeeder extends Seeder
{
    /**
     * Seed disaster categories.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Banjir', 'icon' => '🌊'],
            ['name' => 'Gempa Bumi', 'icon' => '🏚️'],
            ['name' => 'Tanah Longsor', 'icon' => '⛰️'],
            ['name' => 'Kebakaran', 'icon' => '🔥'],
            ['name' => 'Gunung Meletus', 'icon' => '🌋'],
        ];

        foreach ($categories as $category) {
            DisasterCategory::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'slug' => Str::slug($category['name']),
                    'icon' => $category['icon'],
                ],
            );
        }
    }
}
