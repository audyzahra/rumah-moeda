<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationStructureSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organization_structures')->insert([
            [
                'parent_id' => null,
                'full_name' => 'Budi Santoso',
                'position' => 'Ketua Yayasan',
                'photo' => 'uploads/staff.png',
                'description' => 'Memimpin dan mengawasi seluruh kegiatan Yayasan Rumah Moeda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => null,
                'full_name' => 'Siti Rahmawati',
                'position' => 'Sekretaris',
                'photo' => 'uploads/staff.png',
                'description' => 'Mengelola administrasi dan dokumentasi kegiatan yayasan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => null,
                'full_name' => 'Ahmad Hidayat',
                'position' => 'Bendahara',
                'photo' => 'uploads/staff.png',
                'description' => 'Bertanggung jawab atas pengelolaan keuangan yayasan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => null,
                'full_name' => 'Rina Kartika',
                'position' => 'Koordinator Multimedia',
                'photo' => 'uploads/staff.png',
                'description' => 'Mengkoordinasikan produksi multimedia, dokumentasi, dan konten kreatif.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => null,
                'full_name' => 'Dimas Pratama',
                'position' => 'Koordinator Perfilman',
                'photo' => 'uploads/staff.png',
                'description' => 'Mengelola kegiatan produksi film, workshop, dan pelatihan perfilman.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
