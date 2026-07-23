<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\PortfolioCategory;

class PortfolioCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Kolaborasi',
            'Workshop',
            'Seminar',
            'Pelatihan',
            'Pengabdian',
        ];

        foreach ($categories as $category) {
            PortfolioCategory::firstOrCreate(
                ['slug' => Str::slug($category)],
                [
                    'name' => $category,
                ]
            );
        }
    }
}
