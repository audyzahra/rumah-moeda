<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faqs')->insert([
            [
                'question' => 'Apa itu Rumah Moeda',
                'answer' => 'Rumah Moeda merupakan organisasi yang bergerak dalam bidang pemberdayaan masyarakat, pendidikan, budaya, dan inovasi',
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Bagaimana cara menjadi mitra Rumah Moeda?',
                'answer' => 'Silahkan nanti menghubungi kami melalui halaman Hubungi Kami atau melalui media sosial resmi Rumah Moeda untuk informasi lebih lanjut mengenai kemitraan.',
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah Rumah Moeda meemiliki pelatihan?',
                'answer' => 'Ya, Rumah Moeda menyediakan berbagai pelatihan sesuai kegiatan yang sedang berlangsung.',
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}