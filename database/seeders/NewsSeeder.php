<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = User::first();

        $news = [
            [
                'title' => 'Rumah Moeda Gelar Workshop Dasar Sinematografi untuk Generasi Muda',
                'category' => 'Workshop',
                'thumbnail' => 'storage/news/workshop-sinematografi.jpg',
                'content' => 'Rumah Moeda menyelenggarakan workshop dasar sinematografi yang bertujuan meningkatkan kemampuan generasi muda dalam bidang perfilman dan produksi video kreatif.',
                'publish_date' => now()->subDays(20),
            ],
            [
                'title' => 'Pelatihan Editing Video Kreatif Bersama Rumah Moeda',
                'category' => 'Pelatihan',
                'thumbnail' => 'storage/news/pelatihan-editing.jpg',
                'content' => 'Kegiatan pelatihan editing video menggunakan perangkat lunak profesional sebagai bekal memasuki industri kreatif.',
                'publish_date' => now()->subDays(15),
            ],
            [
                'title' => 'Kolaborasi Rumah Moeda dengan Komunitas Kreatif Purwakarta',
                'category' => 'Kolaborasi',
                'thumbnail' => 'storage/news/kolaborasi-komunitas.jpg',
                'content' => 'Rumah Moeda menjalin kerja sama dengan berbagai komunitas kreatif dalam menghasilkan karya multimedia yang inovatif.',
                'publish_date' => now()->subDays(12),
            ],
            [
                'title' => 'Produksi Film Pendek Bertema Budaya Lokal',
                'category' => 'Perfilman',
                'thumbnail' => 'storage/news/film-pendek.jpg',
                'content' => 'Produksi film pendek yang mengangkat budaya lokal sebagai bentuk pelestarian budaya melalui media visual.',
                'publish_date' => now()->subDays(8),
            ],
            [
                'title' => 'Rumah Moeda Berpartisipasi dalam Festival Multimedia',
                'category' => 'Event',
                'thumbnail' => 'storage/news/festival-multimedia.jpg',
                'content' => 'Rumah Moeda turut serta dalam festival multimedia dengan menampilkan karya terbaik serta memperkenalkan program-program kreatif kepada masyarakat.',
                'publish_date' => now()->subDays(3),
            ],
        ];

        foreach ($news as $item) {

            $category = Category::where('name', $item['category'])->first();

            DB::table('news')->insert([
                'title' => $item['title'],
                'thumbnail' => $item['thumbnail'],
                'content' => $item['content'],
                'category_id' => $category->id,
                'slug' => Str::slug($item['title']),
                'publish_date' => $item['publish_date'],
                'author_id' => $author->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}