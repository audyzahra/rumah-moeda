<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleries = [
            [
                'title' => 'Workshop Dasar Sinematografi',
                'description' => 'Kegiatan pelatihan dasar sinematografi untuk memperkenalkan teknik pengambilan gambar kepada generasi muda.',
                'activity_date' => '2026-01-15',
            ],
            [
                'title' => 'Pelatihan Editing Video',
                'description' => 'Peserta belajar proses editing video menggunakan perangkat lunak profesional.',
                'activity_date' => '2026-02-10',
            ],
            [
                'title' => 'Produksi Film Pendek',
                'description' => 'Dokumentasi proses produksi film pendek yang melibatkan tim kreatif Rumah Moeda.',
                'activity_date' => '2026-03-08',
            ],
            [
                'title' => 'Festival Multimedia',
                'description' => 'Partisipasi Rumah Moeda dalam festival multimedia dan industri kreatif.',
                'activity_date' => '2026-04-20',
            ],
            [
                'title' => 'Kolaborasi Bersama Komunitas',
                'description' => 'Kegiatan kolaborasi bersama komunitas kreatif dalam menghasilkan konten multimedia.',
                'activity_date' => '2026-05-12',
            ],
            [
                'title' => 'Dokumentasi Event Pendidikan',
                'description' => 'Rumah Moeda mendokumentasikan kegiatan pendidikan dan pelatihan masyarakat.',
                'activity_date' => '2026-06-05',
            ],
        ];

        // Gallery yang ingin diberi gambar dummy
        $galleriesWithImage = [
            'Workshop Dasar Sinematografi',
            'Pelatihan Editing Video',
        ];

        foreach ($galleries as $item) {
            $galleryId = DB::table('galleries')->insertGetId([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'description' => $item['description'],
                'activity_date' => $item['activity_date'],
                'author_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Hanya gallery tertentu yang memiliki media
            if (in_array($item['title'], $galleriesWithImage)) {
                DB::table('gallery_media')->insert([
                    'gallery_id' => $galleryId,
                    'type' => 'image',
                    'file_path' => 'uploads/oganLopian.png',
                    'video_url' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
