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
            AdminUserSeeder::class,
            SettingSeeder::class,
            PageSeeder::class,
            TeamPlayerSeeder::class,
            CompetitionStandingSeeder::class,
            ArticleSeeder::class,
            EventScheduleSeeder::class,
            FixtureSeeder::class,
            SponsorStaffSeeder::class,
            ResourceSeeder::class,
            EngagementSeeder::class,
        ]);
    }
}
