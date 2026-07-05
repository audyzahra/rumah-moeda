<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            VisionMissionSeeder::class,
            MissionSeeder::class,
            PartnerSeeder::class,
            OrganizationStructureSeeder::class,
            GallerySeeder::class,
            NewsSeeder::class,
            SettingSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
