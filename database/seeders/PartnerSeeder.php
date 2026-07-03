<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('partners')->insert([
            [
                'name' => 'OganLopian',
                'logo' => 'partners/oganlopian.png',
                'description' => 'Mitra resmi Rumah Moeda dalam pengembangan layanan digital, promosi wisata, dan manajemen tiket event.',
                'website' => 'https://oganlopian.id',
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Desa Cikabandung',
                'logo' => 'uploads/oganLopian.png',
                'description' => 'Kolaborasi dalam program pemberdayaan masyarakat dan pengembangan lingkungan berbasis multimedia.',
                'website' => null,
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Purwakarta Creative Community',
                'logo' => 'uploads/oganLopian.png',
                'description' => 'Komunitas kreatif yang berkolaborasi dalam berbagai kegiatan edukasi dan produksi multimedia.',
                'website' => null,
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SMK Multimedia Indonesia',
                'logo' => 'uploads/oganLopian.png',
                'description' => 'Mitra dalam pelatihan, workshop, dan pengembangan keterampilan multimedia bagi generasi muda.',
                'website' => null,
                'display_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dinas Pariwisata Kabupaten Purwakarta',
                'logo' => 'uploads/oganLopian.png',
                'description' => 'Kolaborasi dalam promosi destinasi wisata dan penyelenggaraan berbagai event daerah.',
                'website' => null,
                'display_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}