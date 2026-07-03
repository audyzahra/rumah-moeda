<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('galleries')->insert([
            [
                'title' => 'Workshop Dasar Sinematografi',
                'description' => 'Kegiatan pelatihan dasar sinematografi untuk memperkenalkan teknik pengambilan gambar kepada generasi muda.',
                'photo' => 'uploads/oganLopian.png',
                'activity_date' => '2026-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pelatihan Editing Video',
                'description' => 'Peserta belajar proses editing video menggunakan perangkat lunak profesional.',
                'photo' => 'uploads/oganLopian.png',
                'activity_date' => '2026-02-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Produksi Film Pendek',
                'description' => 'Dokumentasi proses produksi film pendek yang melibatkan tim kreatif Rumah Moeda.',
                'photo' => 'uploads/oganLopian.png',
                'activity_date' => '2026-03-08',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Festival Multimedia',
                'description' => 'Partisipasi Rumah Moeda dalam festival multimedia dan industri kreatif.',
                'photo' => 'uploads/oganLopian.png',
                'activity_date' => '2026-04-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kolaborasi Bersama Komunitas',
                'description' => 'Kegiatan kolaborasi bersama komunitas kreatif dalam menghasilkan konten multimedia.',
                'photo' => 'uploads/oganLopian.png',
                'activity_date' => '2026-05-12',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Dokumentasi Event Pendidikan',
                'description' => 'Rumah Moeda mendokumentasikan kegiatan pendidikan dan pelatihan masyarakat.',
                'photo' => 'uploads/oganLopian.png',
                'activity_date' => '2026-06-05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}