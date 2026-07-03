<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisionMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vision_missions')->insert([
            [
                'vision' => 'Menjadi yayasan yang kreatif, inovatif, dan inspiratif dalam bidang multimedia, perfilman, edukasi, serta pemberdayaan generasi muda untuk menciptakan karya yang berdampak positif bagi masyarakat.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}