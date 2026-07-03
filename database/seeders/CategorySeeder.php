<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Berita',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kegiatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Multimedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Perfilman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Workshop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pelatihan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Event',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kolaborasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pengumuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}