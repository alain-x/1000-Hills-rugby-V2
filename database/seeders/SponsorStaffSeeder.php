<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class SponsorStaffSeeder extends Seeder
{
    public function run(): void
    {
        $sponsors = [
            [
                'name' => 'RQT',
                'logo_path' => 'images/rqt.jpg',
                'tier' => 'Principal Partner',
                'description' => 'Connecting Rwandan talent to opportunities and developing the skills that open doors.',
                'sort_order' => 1,
            ],
            [
                'name' => 'LSFG Partners',
                'logo_path' => 'images/LSFG+PartnerLogos-Colour-horizontal.jpg',
                'tier' => 'Official Partners',
                'description' => 'A committed partner supporting the growth of rugby and community programmes.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Anymore',
                'logo_path' => 'images/anymore.jpg',
                'tier' => 'Official Partners',
                'description' => 'Standing with our players and helping us build a stronger club.',
                'sort_order' => 3,
            ],
            [
                'name' => 'PWR',
                'logo_path' => 'images/pwr.png',
                'tier' => 'Community Partner',
                'description' => 'Supporting the people and programmes that make 1000 Hills Rugby possible.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Gold',
                'logo_path' => 'images/Gold.jpg',
                'tier' => 'Community Partner',
                'description' => 'A valued partner of our community rugby initiatives.',
                'sort_order' => 5,
            ],
        ];

        foreach ($sponsors as $sponsor) {
            Sponsor::updateOrCreate(
                ['name' => $sponsor['name']],
                $sponsor + ['is_active' => true]
            );
        }

        $staff = [
            [
                'name' => 'Serge SHEMA',
                'role' => 'President and Co-founder',
                'image' => 'images/serge.jpeg',
                'phone' => '+250 788 261 386',
                'bio' => 'Serge SHEMA is the President and Co-Founder of 1000 Hills Rugby, where he has led the organisation\'s transformation into a centre of excellence since its founding in 2014. A qualified World Rugby Level 1 Coach (7s) and Level 1 Referee, Serge also serves as Assistant Coach for the U12 team, with a strong focus on youth development. Through initiatives like the 1000 Hills Rugby Voice, he supports education and skill-building for children from underserved communities.',
                'sort_order' => 1,
            ],
            [
                'name' => "Jean D'Amour Nsengimana",
                'role' => 'General Manager',
                'image' => 'images/jd.jpeg',
                'phone' => '+250 782 260 697',
                'bio' => 'Jean D\'Amour Nsengimana, also known as JD, is one of the three founders of 1000 Hills Rugby, serving as its elected general manager and head coach for the development teams. A qualified Level 2 Rugby XV coach, he is deeply involved in nurturing young talent while promoting the club\'s core values: discipline, sportsmanship, mutuality, integrity, and mental and physical strength.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Jimmy MUGABO',
                'role' => 'Director of Rugby & Community Engagement',
                'image' => 'images/jimmy.jpeg',
                'bio' => 'Jimy Mugabo is a dynamic leader in sports and social development, specialising in leveraging rugby as a tool for education, employability and personal growth among Rwandan youth. As Director of Rugby at 1000 Hills Rugby, he fosters inclusive programmes focused on skills development, job readiness, and health and well-being.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Bernard RWAGASORE',
                'role' => 'Marketing Manager',
                'image' => 'images/berno.png',
                'bio' => 'Rwagasore Bernard, also known by his nickname Hard Guy, is a dedicated player for 1000 Hills Rugby. He started his rugby journey in the second row and has since transitioned to prop. In addition to his role on the field, Bernard works in marketing and remains actively involved in the 1000 Hills Rugby community.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Jacqueline GASENGAYIRE',
                'role' => 'Advisor',
                'image' => 'images/GASENGAYIRE JACQUELINE.jpeg',
                'bio' => 'Jacqueline Gasengayire has been with 1000 Hills Rugby for over 10 years and has played a key role in the growth of our girls\' team. Her dedication, leadership and passion for rugby have inspired many young girls to join and thrive in the sport. She now also serves on the Conflict Resolution Team.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Jean Sauveur SINGIZWA',
                'role' => 'General Secretary',
                'image' => 'images/sover.jpeg',
                'bio' => 'For over six years, Sauveur has been a vital part of 1000 Hills Rugby, showcasing exceptional leadership and dedication. As captain of our men\'s team for two years, he led by example. He now serves as General Secretary, where his experience and vision guide the organisation\'s growth.',
                'sort_order' => 6,
            ],
            [
                'name' => 'Shalom KUNESHANUKWAYO',
                'role' => 'Safeguarding Officer',
                'image' => 'images/Shalom.jpeg',
                'bio' => 'Shalom has been a proud member of 1000 Hills Rugby for over 10 years, rising from tag rugby to the development team, the senior team, and now serving as a coach for the development team. Recently appointed Safeguarding Officer, he is committed to creating a safe and supportive environment for all participants in our programmes.',
                'sort_order' => 7,
            ],
            [
                'name' => 'Dominique Savio NIYONZIMA',
                'role' => 'Conflict Resolution Director',
                'image' => 'images/savio1.jpeg',
                'bio' => 'From the very start, Dominique Savio has been a cornerstone of 1000 Hills Rugby, standing with us when it was nothing more than a vision. As Conflict Resolution Director, he fosters understanding and collaboration within our programmes and helps keep the club true to its values.',
                'sort_order' => 8,
            ],
        ];

        foreach ($staff as $member) {
            Staff::updateOrCreate(
                ['name' => $member['name']],
                $member + ['is_active' => true]
            );
        }
    }
}
