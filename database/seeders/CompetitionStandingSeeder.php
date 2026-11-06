<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Competition;
use App\Models\Gender;
use App\Models\Season;
use App\Models\Standing;
use Illuminate\Database\Seeder;

class CompetitionStandingSeeder extends Seeder
{
    public function run(): void
    {
        $currentYear = (int) now()->year;
        $previousYear = $currentYear - 1;

        $men = Gender::updateOrCreate(['name' => 'Men'], ['is_active' => true]);
        $women = Gender::updateOrCreate(['name' => 'Women'], ['is_active' => true]);

        $currentSeason = Season::updateOrCreate(['year' => $currentYear], ['is_active' => true]);
        $previousSeason = Season::updateOrCreate(['year' => $previousYear], ['is_active' => true]);

        $menCompetition = Competition::updateOrCreate(
            ['name' => "Rwanda Rugby Men's 15s National League"],
            ['description' => 'The national men\'s 15-a-side league organised by the Rwanda Rugby Federation.', 'is_active' => true]
        );

        $womenCompetition = Competition::updateOrCreate(
            ['name' => "Rwanda Rugby Women's 15s National League"],
            ['description' => 'The national women\'s 15-a-side league organised by the Rwanda Rugby Federation.', 'is_active' => true]
        );

        $clubs = [
            ['name' => '1000 Hills Rugby', 'slug' => '1000-hills-rugby', 'logo' => 'images/1000-hills-logo.png'],
            ['name' => 'Lions De Fer', 'slug' => 'lions-de-fer', 'logo' => 'logos_/lions.jpg'],
            ['name' => 'Gitisi TSS', 'slug' => 'gitisi-tss', 'logo' => 'logos_/Gitisi.jpeg'],
            ['name' => 'Muhanga Rugby', 'slug' => 'muhanga-rugby', 'logo' => 'logos_/muhanga.jpg'],
            ['name' => 'Resilience Rugby', 'slug' => 'resilience-rugby', 'logo' => 'logos_/resilience.jpg'],
            ['name' => 'Sharks Rugby', 'slug' => 'sharks-rugby', 'logo' => 'logos_/sharks.jpg'],
            ['name' => 'UR Rugby', 'slug' => 'ur-rugby', 'logo' => 'logos_/ur.jpg'],
            ['name' => 'Alpa Rugby', 'slug' => 'alpa-rugby', 'logo' => 'logos_/alpa_logo.jpeg'],
            ['name' => 'LogoT Rugby', 'slug' => 'logot-rugby', 'logo' => 'logos_/logoT.jpg'],
        ];

        foreach ($clubs as $club) {
            Club::updateOrCreate(['name' => $club['name']], $club + ['is_active' => true]);
        }

        $clubsByName = Club::all()->keyBy('name');

        $menTable = [
            '1000 Hills Rugby' => ['played' => 8, 'won' => 7, 'drawn' => 0, 'lost' => 1, 'tries_for' => 31, 'tries_against' => 14, 'points_for' => 212, 'points_against' => 96, 'league_points' => 35, 'form_score' => 8.6],
            'Lions De Fer' => ['played' => 8, 'won' => 6, 'drawn' => 0, 'lost' => 2, 'tries_for' => 27, 'tries_against' => 16, 'points_for' => 188, 'points_against' => 110, 'league_points' => 30, 'form_score' => 7.4],
            'Gitisi TSS' => ['played' => 8, 'won' => 5, 'drawn' => 1, 'lost' => 2, 'tries_for' => 24, 'tries_against' => 18, 'points_for' => 164, 'points_against' => 121, 'league_points' => 27, 'form_score' => 6.8],
            'Muhanga Rugby' => ['played' => 8, 'won' => 4, 'drawn' => 1, 'lost' => 3, 'tries_for' => 22, 'tries_against' => 21, 'points_for' => 150, 'points_against' => 140, 'league_points' => 22, 'form_score' => 5.6],
            'Sharks Rugby' => ['played' => 8, 'won' => 3, 'drawn' => 0, 'lost' => 5, 'tries_for' => 18, 'tries_against' => 24, 'points_for' => 128, 'points_against' => 162, 'league_points' => 16, 'form_score' => 4.3],
            'Resilience Rugby' => ['played' => 8, 'won' => 2, 'drawn' => 1, 'lost' => 5, 'tries_for' => 16, 'tries_against' => 26, 'points_for' => 118, 'points_against' => 176, 'league_points' => 12, 'form_score' => 3.5],
            'UR Rugby' => ['played' => 8, 'won' => 2, 'drawn' => 0, 'lost' => 6, 'tries_for' => 14, 'tries_against' => 28, 'points_for' => 104, 'points_against' => 189, 'league_points' => 10, 'form_score' => 2.9],
            'Alpa Rugby' => ['played' => 8, 'won' => 1, 'drawn' => 1, 'lost' => 6, 'tries_for' => 12, 'tries_against' => 30, 'points_for' => 92, 'points_against' => 202, 'league_points' => 7, 'form_score' => 2.1],
        ];

        $womenTable = [
            '1000 Hills Rugby' => ['played' => 6, 'won' => 5, 'drawn' => 0, 'lost' => 1, 'tries_for' => 22, 'tries_against' => 9, 'points_for' => 148, 'points_against' => 62, 'league_points' => 25, 'form_score' => 7.8],
            'Lions De Fer' => ['played' => 6, 'won' => 4, 'drawn' => 0, 'lost' => 2, 'tries_for' => 17, 'tries_against' => 11, 'points_for' => 118, 'points_against' => 78, 'league_points' => 20, 'form_score' => 6.4],
            'Resilience Rugby' => ['played' => 6, 'won' => 4, 'drawn' => 0, 'lost' => 2, 'tries_for' => 15, 'tries_against' => 12, 'points_for' => 106, 'points_against' => 84, 'league_points' => 18, 'form_score' => 5.9],
            'Gitisi TSS' => ['played' => 6, 'won' => 2, 'drawn' => 1, 'lost' => 3, 'tries_for' => 11, 'tries_against' => 15, 'points_for' => 82, 'points_against' => 101, 'league_points' => 12, 'form_score' => 4.1],
            'Sharks Rugby' => ['played' => 6, 'won' => 1, 'drawn' => 1, 'lost' => 4, 'tries_for' => 9, 'tries_against' => 18, 'points_for' => 68, 'points_against' => 116, 'league_points' => 7, 'form_score' => 2.8],
            'UR Rugby' => ['played' => 6, 'won' => 1, 'drawn' => 0, 'lost' => 5, 'tries_for' => 7, 'tries_against' => 21, 'points_for' => 54, 'points_against' => 135, 'league_points' => 5, 'form_score' => 2.2],
        ];

        $archivedMenTable = [
            'Lions De Fer' => ['played' => 10, 'won' => 8, 'drawn' => 0, 'lost' => 2, 'tries_for' => 35, 'tries_against' => 15, 'points_for' => 236, 'points_against' => 104, 'league_points' => 40, 'form_score' => 8.9],
            '1000 Hills Rugby' => ['played' => 10, 'won' => 7, 'drawn' => 1, 'lost' => 2, 'tries_for' => 33, 'tries_against' => 17, 'points_for' => 224, 'points_against' => 118, 'league_points' => 37, 'form_score' => 8.2],
            'Gitisi TSS' => ['played' => 10, 'won' => 6, 'drawn' => 1, 'lost' => 3, 'tries_for' => 28, 'tries_against' => 20, 'points_for' => 192, 'points_against' => 141, 'league_points' => 31, 'form_score' => 7.1],
            'Muhanga Rugby' => ['played' => 10, 'won' => 5, 'drawn' => 0, 'lost' => 5, 'tries_for' => 24, 'tries_against' => 24, 'points_for' => 168, 'points_against' => 166, 'league_points' => 25, 'form_score' => 5.8],
            'Sharks Rugby' => ['played' => 10, 'won' => 4, 'drawn' => 0, 'lost' => 6, 'tries_for' => 21, 'tries_against' => 27, 'points_for' => 154, 'points_against' => 181, 'league_points' => 20, 'form_score' => 4.7],
            'Resilience Rugby' => ['played' => 10, 'won' => 3, 'drawn' => 1, 'lost' => 6, 'tries_for' => 19, 'tries_against' => 29, 'points_for' => 142, 'points_against' => 194, 'league_points' => 16, 'form_score' => 3.9],
            'UR Rugby' => ['played' => 10, 'won' => 2, 'drawn' => 1, 'lost' => 7, 'tries_for' => 16, 'tries_against' => 31, 'points_for' => 121, 'points_against' => 208, 'league_points' => 11, 'form_score' => 3.1],
            'Alpa Rugby' => ['played' => 10, 'won' => 2, 'drawn' => 0, 'lost' => 8, 'tries_for' => 13, 'tries_against' => 36, 'points_for' => 104, 'points_against' => 229, 'league_points' => 9, 'form_score' => 2.6],
        ];

        $this->seedTable($clubsByName, $menTable, $menCompetition, $currentSeason, $men);
        $this->seedTable($clubsByName, $womenTable, $womenCompetition, $currentSeason, $women);
        $this->seedTable($clubsByName, $archivedMenTable, $menCompetition, $previousSeason, $men);
    }

    private function seedTable($clubsByName, array $rows, Competition $competition, Season $season, Gender $gender): void
    {
        foreach ($rows as $clubName => $row) {
            $club = $clubsByName->get($clubName);

            if (! $club) {
                continue;
            }

            $pointsDifference = (int) $row['points_for'] - (int) $row['points_against'];

            Standing::updateOrCreate(
                [
                    'club_id' => $club->id,
                    'competition_id' => $competition->id,
                    'season_id' => $season->id,
                    'gender_id' => $gender->id,
                ],
                [
                    'matches_played' => $row['played'],
                    'matches_won' => $row['won'],
                    'matches_drawn' => $row['drawn'],
                    'matches_lost' => $row['lost'],
                    'tries_for' => $row['tries_for'],
                    'tries_against' => $row['tries_against'],
                    'points_for' => $row['points_for'],
                    'points_against' => $row['points_against'],
                    'points_difference' => $pointsDifference,
                    'league_points' => $row['league_points'],
                    'form_score' => $row['form_score'],
                ]
            );
        }
    }
}
