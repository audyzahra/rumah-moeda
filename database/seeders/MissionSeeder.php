<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('missions')->insert([
            [
                'vision_mission_id' => 1,
                'mission' => 'Mengembangkan potensi generasi muda melalui pendidikan, pelatihan, dan praktik di bidang multimedia, perfilman, serta industri kreatif.',
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vision_mission_id' => 1,
                'mission' => 'Menciptakan karya multimedia dan perfilman yang edukatif, kreatif, inovatif, dan mampu memberikan manfaat bagi masyarakat luas.',
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vision_mission_id' => 1,
                'mission' => 'Membangun kolaborasi dengan berbagai komunitas, lembaga, dan mitra strategis untuk mendukung pengembangan sumber daya manusia serta kemajuan industri kreatif.',
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vision_mission_id' => 1,
                'mission' => 'Mendorong partisipasi aktif masyarakat dalam kegiatan sosial, pendidikan, budaya, dan promosi daerah melalui media kreatif yang inovatif.',
                'display_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}