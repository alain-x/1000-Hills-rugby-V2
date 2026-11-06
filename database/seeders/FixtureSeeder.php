<?php

namespace Database\Seeders;

use App\Models\Fixture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class FixtureSeeder extends Seeder
{
    public function run(): void
    {
        $season = (int) now()->year;
        $previousSeason = $season - 1;

        $logos = [
            '1000 Hills Rugby' => 'images/1000-hills-logo.png',
            'Lions De Fer' => 'logos_/lions.jpg',
            'Gitisi TSS' => 'logos_/Gitisi.jpeg',
            'Muhanga Rugby' => 'logos_/muhanga.jpg',
            'Resilience Rugby' => 'logos_/resilience.jpg',
            'Sharks Rugby' => 'logos_/sharks.jpg',
            'UR Rugby' => 'logos_/ur.jpg',
            'Alpa Rugby' => 'logos_/alpa_logo.jpeg',
            'Kigali Select' => null,
        ];

        $menLeague = "Rwanda Rugby Men's 15s National League";
        $womenLeague = "Rwanda Rugby Women's 15s National League";

        $fixtures = [
            // Upcoming
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'Lions De Fer',
                'match_date' => Carbon::today()->addDays(7)->setTime(15, 0),
                'competition' => $menLeague, 'gender' => 'MEN', 'season' => $season,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'SCHEDULED',
                'notes' => 'National league fixture. Gates open one hour before kick-off.',
            ],
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'Resilience Rugby',
                'match_date' => Carbon::today()->addDays(10)->setTime(13, 0),
                'competition' => $womenLeague, 'gender' => 'WOMEN', 'season' => $season,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'SCHEDULED',
            ],
            [
                'home_team' => 'Gitisi TSS', 'away_team' => '1000 Hills Rugby',
                'match_date' => Carbon::today()->addDays(14)->setTime(14, 0),
                'competition' => $menLeague, 'gender' => 'MEN', 'season' => $season,
                'stadium' => 'Gitisi TSS Ground, Nyarugenge', 'status' => 'SCHEDULED',
            ],
            [
                'home_team' => 'Muhanga Rugby', 'away_team' => '1000 Hills Rugby',
                'match_date' => Carbon::today()->addDays(18)->setTime(14, 30),
                'competition' => $womenLeague, 'gender' => 'WOMEN', 'season' => $season,
                'stadium' => 'Muhanga Stadium', 'status' => 'SCHEDULED',
            ],
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'Sharks Rugby',
                'match_date' => Carbon::today()->addDays(21)->setTime(15, 0),
                'competition' => $menLeague, 'gender' => 'MEN', 'season' => $season,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'SCHEDULED',
            ],
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'Kigali Select',
                'match_date' => Carbon::today()->addDays(28)->setTime(15, 0),
                'competition' => 'Pre-Season Friendly', 'gender' => 'MEN', 'season' => $season,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'SCHEDULED',
                'notes' => 'Pre-season friendly ahead of the national league.',
            ],
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'Alpa Rugby',
                'match_date' => Carbon::today()->addDays(35)->setTime(15, 0),
                'competition' => $menLeague, 'gender' => 'MEN', 'season' => $season,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'SCHEDULED',
            ],
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'UR Rugby',
                'match_date' => Carbon::today()->addDays(42)->setTime(13, 0),
                'competition' => $womenLeague, 'gender' => 'WOMEN', 'season' => $season,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'SCHEDULED',
            ],

            // Results
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'Lions De Fer',
                'match_date' => Carbon::today()->subDays(7)->setTime(15, 0),
                'competition' => $menLeague, 'gender' => 'MEN', 'season' => $season,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'COMPLETED',
                'home_score' => 32, 'away_score' => 17,
            ],
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'Resilience Rugby',
                'match_date' => Carbon::today()->subDays(10)->setTime(13, 0),
                'competition' => $womenLeague, 'gender' => 'WOMEN', 'season' => $season,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'COMPLETED',
                'home_score' => 28, 'away_score' => 12,
            ],
            [
                'home_team' => 'Gitisi TSS', 'away_team' => '1000 Hills Rugby',
                'match_date' => Carbon::today()->subDays(14)->setTime(14, 0),
                'competition' => $menLeague, 'gender' => 'MEN', 'season' => $season,
                'stadium' => 'Gitisi TSS Ground, Nyarugenge', 'status' => 'COMPLETED',
                'home_score' => 12, 'away_score' => 24,
            ],
            [
                'home_team' => 'Sharks Rugby', 'away_team' => '1000 Hills Rugby',
                'match_date' => Carbon::today()->subDays(21)->setTime(15, 0),
                'competition' => $menLeague, 'gender' => 'MEN', 'season' => $season,
                'stadium' => 'Sharks Rugby Ground', 'status' => 'COMPLETED',
                'home_score' => 19, 'away_score' => 21,
            ],
            [
                'home_team' => 'UR Rugby', 'away_team' => '1000 Hills Rugby',
                'match_date' => Carbon::today()->subDays(24)->setTime(13, 0),
                'competition' => $womenLeague, 'gender' => 'WOMEN', 'season' => $season,
                'stadium' => 'UR Rugby Ground, Huye', 'status' => 'COMPLETED',
                'home_score' => 8, 'away_score' => 34,
            ],
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'Alpa Rugby',
                'match_date' => Carbon::today()->subDays(28)->setTime(15, 0),
                'competition' => $menLeague, 'gender' => 'MEN', 'season' => $season,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'COMPLETED',
                'home_score' => 46, 'away_score' => 5,
            ],
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'Muhanga Rugby',
                'match_date' => Carbon::today()->subDays(35)->setTime(15, 0),
                'competition' => $menLeague, 'gender' => 'MEN', 'season' => $season,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'COMPLETED',
                'home_score' => 17, 'away_score' => 20,
            ],
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'Gitisi TSS',
                'match_date' => Carbon::today()->subDays(38)->setTime(13, 0),
                'competition' => $womenLeague, 'gender' => 'WOMEN', 'season' => $season,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'COMPLETED',
                'home_score' => 38, 'away_score' => 7,
            ],

            // Previous season archive
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'Muhanga Rugby',
                'match_date' => Carbon::create($previousSeason, 11, 16, 15, 0),
                'competition' => $menLeague, 'gender' => 'MEN', 'season' => $previousSeason,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'COMPLETED',
                'home_score' => 27, 'away_score' => 13,
            ],
            [
                'home_team' => 'Lions De Fer', 'away_team' => '1000 Hills Rugby',
                'match_date' => Carbon::create($previousSeason, 11, 23, 15, 0),
                'competition' => $menLeague, 'gender' => 'MEN', 'season' => $previousSeason,
                'stadium' => 'Lions De Fer Ground', 'status' => 'COMPLETED',
                'home_score' => 22, 'away_score' => 19,
            ],
            [
                'home_team' => '1000 Hills Rugby', 'away_team' => 'Resilience Rugby',
                'match_date' => Carbon::create($previousSeason, 11, 30, 13, 0),
                'competition' => $womenLeague, 'gender' => 'WOMEN', 'season' => $previousSeason,
                'stadium' => 'Don Bosco Gatenga, Kicukiro', 'status' => 'COMPLETED',
                'home_score' => 31, 'away_score' => 10,
            ],
        ];

        foreach ($fixtures as $data) {
            $data['home_logo'] = $logos[$data['home_team']] ?? null;
            $data['away_logo'] = $logos[$data['away_team']] ?? null;
            $data['match_time'] = $data['match_date']->format('H:i');
            $data['is_published'] = true;
            $data['home_score'] = $data['home_score'] ?? 0;
            $data['away_score'] = $data['away_score'] ?? 0;

            Fixture::updateOrCreate(
                [
                    'home_team' => $data['home_team'],
                    'away_team' => $data['away_team'],
                    'match_date' => $data['match_date'],
                ],
                $data
            );
        }
    }
}
