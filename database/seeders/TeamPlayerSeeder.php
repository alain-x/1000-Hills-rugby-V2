<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamPlayerSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Senior Men',
                'slug' => 'senior-men',
                'category' => 'men',
                'gender' => 'Men',
                'age_group' => 'Senior',
                'logo' => 'images/1000-hills-logo.png',
                'cover_image' => 'uploads/1740072895_1hr_Team.JPG',
                'description' => "The 1000 Hills Rugby senior men's team competes in the Rwanda Rugby National League. Built on discipline, sportsmanship and mutuality, the squad is the heartbeat of the club and a pathway for players who dream of representing Rwanda.",
                'coach' => "Jean D'Amour Nsengimana",
                'home_ground' => 'Don Bosco Gatenga, Kicukiro',
                'sort_order' => 1,
            ],
            [
                'name' => 'Senior Women',
                'slug' => 'senior-women',
                'category' => 'women',
                'gender' => 'Women',
                'age_group' => 'Senior',
                'logo' => 'images/1000-hills-logo.png',
                'cover_image' => 'images/Girls2025.JPG',
                'description' => "For years we dreamed of the day our women's team would take their place on the big stage. That day has come. The 1000 Hills Rugby women's team represents the club in the Women National League and continues to break barriers for young female players in Rwanda.",
                'coach' => 'Jacqueline Gasengayire',
                'home_ground' => 'Don Bosco Gatenga, Kicukiro',
                'sort_order' => 2,
            ],
            [
                'name' => 'U18 Boys',
                'slug' => 'u18-boys',
                'category' => 'academy_u18_boys',
                'gender' => 'Boys',
                'age_group' => 'Under 18',
                'logo' => 'images/1000-hills-logo.png',
                'cover_image' => 'images/26.JPG',
                'description' => 'Our U18 boys are the bridge between grassroots rugby and the senior squad. Training focuses on technical skills, game understanding, fitness and the life skills that prepare young men for the next stage of their journey.',
                'coach' => 'Jimy Mugabo',
                'home_ground' => 'Don Bosco Gatenga, Kicukiro',
                'sort_order' => 3,
            ],
            [
                'name' => 'U18 Girls',
                'slug' => 'u18-girls',
                'category' => 'academy_u18_girls',
                'gender' => 'Girls',
                'age_group' => 'Under 18',
                'logo' => 'images/1000-hills-logo.png',
                'cover_image' => 'images/Girls2025.JPG',
                'description' => "The U18 girls programme creates a safe, supportive space where young women build confidence, teamwork and rugby skills. It is the foundation of our senior women's pathway.",
                'coach' => 'Jacqueline Gasengayire',
                'home_ground' => 'Don Bosco Gatenga, Kicukiro',
                'sort_order' => 4,
            ],
            [
                'name' => 'U16 Boys',
                'slug' => 'u16-boys',
                'category' => 'academy_u16_boys',
                'gender' => 'Boys',
                'age_group' => 'Under 16',
                'logo' => 'images/1000-hills-logo.png',
                'cover_image' => 'images/traing.JPG',
                'description' => 'The U16 boys learn the values of rugby through fun, structured sessions. Coaches emphasise fundamentals, safety, respect and a love of the game.',
                'coach' => 'Shalom Kuneshanukwayo',
                'home_ground' => 'Don Bosco Gatenga, Kicukiro',
                'sort_order' => 5,
            ],
            [
                'name' => 'U16 Girls',
                'slug' => 'u16-girls',
                'category' => 'academy_u16_girls',
                'gender' => 'Girls',
                'age_group' => 'Under 16',
                'logo' => 'images/1000-hills-logo.png',
                'cover_image' => 'images/allmember1.jpg',
                'description' => "The U16 girls are introduced to rugby in an inclusive environment where friendship, fitness and confidence come first. New players are always welcome.",
                'coach' => 'Jacqueline Gasengayire',
                'home_ground' => 'Don Bosco Gatenga, Kicukiro',
                'sort_order' => 6,
            ],
        ];

        foreach ($teams as $team) {
            Team::updateOrCreate(
                ['name' => $team['name']],
                $team + ['is_active' => true]
            );
        }

        $teamsByName = Team::all()->keyBy('name');

        $players = [
            // Senior men
            ['team' => 'men', 'name' => 'Gasore Alain Valentin', 'age' => 25, 'role' => 'Wing', 'position_category' => 'Backs', 'weight' => '68', 'height' => '168', 'games' => 18, 'tries' => 6, 'points' => 30, 'nationality' => 'Rwandan', 'joined' => '2023'],
            ['team' => 'men', 'name' => 'Eric Niyonsaba', 'age' => 24, 'role' => 'Fullback', 'position_category' => 'Backs', 'weight' => '78', 'height' => '178', 'games' => 21, 'tries' => 5, 'points' => 25, 'nationality' => 'Rwandan', 'joined' => '2021'],
            ['team' => 'men', 'name' => 'Patrick Habimana', 'age' => 23, 'role' => 'Fly-half', 'position_category' => 'Backs', 'weight' => '76', 'height' => '175', 'games' => 20, 'tries' => 3, 'points' => 87, 'nationality' => 'Rwandan', 'joined' => '2021'],
            ['team' => 'men', 'name' => 'Emmanuel Mugisha', 'age' => 26, 'role' => 'Centre', 'position_category' => 'Backs', 'special_role' => 'Captain', 'weight' => '86', 'height' => '182', 'games' => 32, 'tries' => 9, 'points' => 45, 'nationality' => 'Rwandan', 'joined' => '2018'],
            ['team' => 'men', 'name' => 'Claude Nshimiyimana', 'age' => 22, 'role' => 'Scrum-half', 'position_category' => 'Backs', 'weight' => '72', 'height' => '170', 'games' => 16, 'tries' => 4, 'points' => 20, 'nationality' => 'Rwandan', 'joined' => '2022'],
            ['team' => 'men', 'name' => 'Samuel Nkurunziza', 'age' => 27, 'role' => 'Prop', 'position_category' => 'Forwards', 'weight' => '104', 'height' => '185', 'games' => 28, 'tries' => 2, 'points' => 10, 'nationality' => 'Rwandan', 'joined' => '2019'],
            ['team' => 'men', 'name' => 'Innocent Bizimana', 'age' => 25, 'role' => 'Hooker', 'position_category' => 'Forwards', 'weight' => '92', 'height' => '178', 'games' => 24, 'tries' => 3, 'points' => 15, 'nationality' => 'Rwandan', 'joined' => '2020'],
            ['team' => 'men', 'name' => 'Jean Paul Uwimana', 'age' => 28, 'role' => 'Lock', 'position_category' => 'Forwards', 'weight' => '108', 'height' => '194', 'games' => 30, 'tries' => 1, 'points' => 5, 'nationality' => 'Rwandan', 'joined' => '2017'],
            ['team' => 'men', 'name' => 'Olivier Hakizimana', 'age' => 24, 'role' => 'Flanker', 'position_category' => 'Forwards', 'weight' => '94', 'height' => '183', 'games' => 19, 'tries' => 4, 'points' => 20, 'nationality' => 'Rwandan', 'joined' => '2021'],
            ['team' => 'men', 'name' => 'Fabrice Ndayisaba', 'age' => 26, 'role' => 'Number 8', 'position_category' => 'Forwards', 'weight' => '102', 'height' => '188', 'games' => 26, 'tries' => 7, 'points' => 35, 'nationality' => 'Rwandan', 'joined' => '2019'],
            ['team' => 'men', 'name' => 'Didier Nsengimana', 'age' => 23, 'role' => 'Wing', 'position_category' => 'Backs', 'weight' => '74', 'height' => '172', 'games' => 14, 'tries' => 5, 'points' => 25, 'nationality' => 'Rwandan', 'joined' => '2023'],
            ['team' => 'men', 'name' => 'Kevin Iradukunda', 'age' => 21, 'role' => 'Centre', 'position_category' => 'Backs', 'special_role' => 'Vice-Captain', 'weight' => '80', 'height' => '176', 'games' => 12, 'tries' => 3, 'points' => 15, 'nationality' => 'Rwandan', 'joined' => '2024'],

            // Senior women
            ['team' => 'women', 'name' => 'Aline Uwase', 'age' => 24, 'role' => 'Prop', 'position_category' => 'Forwards', 'special_role' => 'Captain', 'weight' => '84', 'height' => '172', 'games' => 17, 'tries' => 3, 'points' => 15, 'nationality' => 'Rwandan', 'joined' => '2021'],
            ['team' => 'women', 'name' => 'Chantal Mukamana', 'age' => 22, 'role' => 'Hooker', 'position_category' => 'Forwards', 'weight' => '76', 'height' => '165', 'games' => 14, 'tries' => 2, 'points' => 10, 'nationality' => 'Rwandan', 'joined' => '2022'],
            ['team' => 'women', 'name' => 'Diane Ingabire', 'age' => 25, 'role' => 'Lock', 'position_category' => 'Forwards', 'weight' => '82', 'height' => '178', 'games' => 18, 'tries' => 1, 'points' => 5, 'nationality' => 'Rwandan', 'joined' => '2020'],
            ['team' => 'women', 'name' => 'Grace Uwimana', 'age' => 23, 'role' => 'Flanker', 'position_category' => 'Forwards', 'weight' => '74', 'height' => '168', 'games' => 15, 'tries' => 4, 'points' => 20, 'nationality' => 'Rwandan', 'joined' => '2021'],
            ['team' => 'women', 'name' => 'Sandrine Nyirahabimana', 'age' => 26, 'role' => 'Number 8', 'position_category' => 'Forwards', 'weight' => '80', 'height' => '174', 'games' => 20, 'tries' => 6, 'points' => 30, 'nationality' => 'Rwandan', 'joined' => '2019'],
            ['team' => 'women', 'name' => 'Peace Ishimwe', 'age' => 21, 'role' => 'Scrum-half', 'position_category' => 'Backs', 'weight' => '62', 'height' => '160', 'games' => 11, 'tries' => 3, 'points' => 15, 'nationality' => 'Rwandan', 'joined' => '2023'],
            ['team' => 'women', 'name' => 'Josiane Uwera', 'age' => 24, 'role' => 'Fly-half', 'position_category' => 'Backs', 'weight' => '66', 'height' => '164', 'games' => 16, 'tries' => 2, 'points' => 51, 'nationality' => 'Rwandan', 'joined' => '2021'],
            ['team' => 'women', 'name' => 'Nadine Umutoni', 'age' => 22, 'role' => 'Centre', 'position_category' => 'Backs', 'special_role' => 'Vice-Captain', 'weight' => '68', 'height' => '166', 'games' => 13, 'tries' => 5, 'points' => 25, 'nationality' => 'Rwandan', 'joined' => '2022'],
            ['team' => 'women', 'name' => 'Solange Mukeshimana', 'age' => 20, 'role' => 'Wing', 'position_category' => 'Backs', 'weight' => '60', 'height' => '158', 'games' => 9, 'tries' => 4, 'points' => 20, 'nationality' => 'Rwandan', 'joined' => '2024'],
            ['team' => 'women', 'name' => 'Claudine Uwamahoro', 'age' => 23, 'role' => 'Fullback', 'position_category' => 'Backs', 'weight' => '64', 'height' => '163', 'games' => 12, 'tries' => 2, 'points' => 10, 'nationality' => 'Rwandan', 'joined' => '2022'],

            // U18 boys (legacy squad)
            ['team' => 'academy_u18_boys', 'name' => 'Bizimana Alpha', 'age' => 17, 'weight' => '31', 'height' => '140 cm'],
            ['team' => 'academy_u18_boys', 'name' => 'Bizimana Jean De Dieu', 'age' => 16, 'weight' => '31', 'height' => '140 cm'],
            ['team' => 'academy_u18_boys', 'name' => 'Hakizimana Samuel', 'age' => 17, 'weight' => '', 'height' => '140 cm'],
            ['team' => 'academy_u18_boys', 'name' => "Mugisha Jean D'Amour", 'age' => 18, 'weight' => '37', 'height' => '170 cm'],
            ['team' => 'academy_u18_boys', 'name' => 'Mugisha Shaffy', 'age' => 17, 'weight' => '31', 'height' => '140 cm'],
            ['team' => 'academy_u18_boys', 'name' => 'Nizeyimana Regis', 'age' => 17, 'weight' => '31', 'height' => '150 cm'],
            ['team' => 'academy_u18_boys', 'name' => 'Nsanzineza Jean Claude', 'age' => 17, 'weight' => '30', 'height' => '140 cm'],
            ['team' => 'academy_u18_boys', 'name' => 'Nsengiyumva Moise', 'age' => 16, 'weight' => '31', 'height' => '151 cm'],
            ['team' => 'academy_u18_boys', 'name' => 'Tuyishime Alphonse', 'age' => 17, 'weight' => '32', 'height' => '140 cm'],
            ['team' => 'academy_u18_boys', 'name' => 'Uwacu Yvan', 'age' => 17, 'weight' => '31', 'height' => '140 cm'],

            // U18 girls (legacy squad)
            ['team' => 'academy_u18_girls', 'name' => 'Akariza Cynthia', 'age' => 14, 'weight' => '28', 'height' => '130 cm'],
            ['team' => 'academy_u18_girls', 'name' => 'Sandra', 'age' => 15, 'weight' => '27', 'height' => '130 cm'],
            ['team' => 'academy_u18_girls', 'name' => 'Uwimana Rehema', 'age' => 14, 'weight' => '29', 'height' => '130 cm'],

            // U16 boys (legacy squad)
            ['team' => 'academy_u16_boys', 'name' => 'Habimana Hassan', 'age' => 11],
            ['team' => 'academy_u16_boys', 'name' => 'Hirwa Bruce', 'age' => 10],
            ['team' => 'academy_u16_boys', 'name' => 'Ishimwe Joshua', 'age' => 9],
            ['team' => 'academy_u16_boys', 'name' => 'Mugenzi Alvin', 'age' => 9],
            ['team' => 'academy_u16_boys', 'name' => 'Mugisha Jean Claude', 'age' => 9],
            ['team' => 'academy_u16_boys', 'name' => 'Uwimana Elie', 'age' => 9],
            ['team' => 'academy_u16_boys', 'name' => 'Mugisha Prince', 'age' => 9],

            // U16 girls (legacy squad)
            ['team' => 'academy_u16_girls', 'name' => 'Masengesho Sifa', 'age' => 9],
        ];

        $teamByCategory = $teamsByName->keyBy('category');

        foreach ($players as $data) {
            $team = $teamByCategory->get($data['team']);

            Player::updateOrCreate(
                ['name' => $data['name'], 'team' => $data['team']],
                array_merge([
                    'team_id' => $team?->id,
                    'slug' => Str::slug($data['name']),
                    'image' => null,
                    'games' => 0,
                    'points' => 0,
                    'tries' => 0,
                    'is_published' => true,
                ], $data)
            );
        }
    }
}
