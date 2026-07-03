<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'website_name' => 'Rumah Moeda',
                'website_logo' => 'uploads/logo.png',
                'website_description' => 'Rumah Moeda merupakan yayasan yang bergerak di bidang multimedia, perfilman, pendidikan, serta pemberdayaan generasi muda melalui berbagai program kreatif, inovatif, dan kolaboratif.',

                'phone_number' => '+62 812-3456-7890',
                'email' => 'info@rumahmoeda.id',
                'fax_number' => null,
                'address' => 'Purwakarta, Jawa Barat, Indonesia',

                'instagram_url' => 'https://instagram.com/rumah.moeda',
                'facebook_url' => 'https://facebook.com/rumahmoeda',
                'tiktok_url' => 'https://tiktok.com/@rumahmoeda',

                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}