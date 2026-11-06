<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $resources = [
            [
                'title' => '1HR Activity Calendar 2025',
                'slug' => '1hr-activity-calendar-2025',
                'description' => 'The full 1000 Hills Rugby activity calendar for 2025, including events, training blocks and community programmes.',
                'category' => 'Club calendar',
                'year' => 2025,
                'file_path' => 'files/1HR_Activity_calendar_2025.xlsx',
                'downloads' => 128,
            ],
            [
                'title' => 'World Rugby Laws of the Game',
                'slug' => 'world-rugby-laws-of-the-game',
                'description' => 'The official laws of rugby union, published by World Rugby. Essential reading for players, coaches and match officials.',
                'category' => 'Rugby education',
                'year' => null,
                'external_url' => 'https://www.world.rugby/the-game/laws',
                'downloads' => 64,
            ],
            [
                'title' => 'World Rugby Player Welfare',
                'slug' => 'world-rugby-player-welfare',
                'description' => 'Player welfare resources covering safety, concussion management and safeguarding in rugby.',
                'category' => 'Safeguarding',
                'year' => null,
                'external_url' => 'https://www.world.rugby/playerwelfare',
                'downloads' => 47,
            ],
        ];

        foreach ($resources as $resource) {
            Resource::updateOrCreate(
                ['slug' => $resource['slug']],
                $resource + ['is_published' => true]
            );
        }
    }
}
