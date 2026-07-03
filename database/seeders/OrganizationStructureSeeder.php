<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organization_structures')->insert([
            [
                'full_name' => 'Budi Santoso',
                'position' => 'Ketua Yayasan',
                'photo' => 'uploads/staff.png',
                'display_order' => 1,
                'description' => 'Memimpin dan mengawasi seluruh kegiatan Yayasan Rumah Moeda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Siti Rahmawati',
                'position' => 'Sekretaris',
                'photo' => 'uploads/staff.png',
                'display_order' => 2,
                'description' => 'Mengelola administrasi dan dokumentasi kegiatan yayasan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Ahmad Hidayat',
                'position' => 'Bendahara',
                'photo' => 'uploads/staff.png',
                'display_order' => 3,
                'description' => 'Bertanggung jawab atas pengelolaan keuangan yayasan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Rina Kartika',
                'position' => 'Koordinator Multimedia',
                'photo' => 'uploads/staff.png',
                'display_order' => 4,
                'description' => 'Mengkoordinasikan produksi multimedia, dokumentasi, dan konten kreatif.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Dimas Pratama',
                'position' => 'Koordinator Perfilman',
                'photo' => 'uploads/staff.png',
                'display_order' => 5,
                'description' => 'Mengelola kegiatan produksi film, workshop, dan pelatihan perfilman.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}