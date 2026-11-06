<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\WeeklySchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class EventScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // The weekly rhythm published in the legacy club calendar.
        $schedule = [
            ['day' => 'Friday', 'time_range' => '04:15 PM - 5:35 PM', 'location' => 'Don Bosco Gatenga', 'activity' => 'Practice', 'sort_order' => 1],
            ['day' => 'Saturday', 'time_range' => '2:10 PM - 05:30 PM', 'location' => 'Don Bosco Gatenga', 'activity' => 'Game Plan and Fun Rugby', 'sort_order' => 2],
        ];

        foreach ($schedule as $slot) {
            WeeklySchedule::updateOrCreate(
                ['day' => $slot['day'], 'activity' => $slot['activity']],
                $slot + ['is_active' => true]
            );
        }

        $nextSaturday = Carbon::today()->next(Carbon::SATURDAY);
        $lastSaturday = $nextSaturday->copy()->subDays(7);

        $events = [
            [
                'title' => 'Umuganda Fun Rugby',
                'event_date' => $nextSaturday->copy(),
                'event_time' => '8:00 AM - 11:00 AM',
                'location' => 'Gatenga, Kicukiro',
                'participants' => 'Youth (U18, U16, U12), senior teams, local community',
                'frequency' => 'Monthly',
                'image' => 'images/allmember1.jpg',
                'description' => '<p>Community service followed by rugby games to promote the sport and its values. Umuganda Fun Rugby brings together our youth teams, senior men\'s and women\'s squads and members of the local community for a morning of service and rugby.</p><p>Held on the last Saturday of every month, the initiative uses rugby to promote unity, health, fitness and the values that matter both on and off the field.</p>',
            ],
            [
                'title' => 'Training: Soft Skills Workshop',
                'event_date' => Carbon::today()->addDays(12),
                'event_time' => '10:00 AM - 1:00 PM',
                'location' => 'Don Bosco Gatenga, Kicukiro',
                'participants' => 'Members and senior teams',
                'frequency' => 'Once in two months',
                'image' => 'images/study.jpg',
                'description' => '<p>A practical workshop focused on CV writing, communication, teamwork, problem-solving and time management. The session is designed to help players build skills that serve them well beyond rugby.</p>',
            ],
            [
                'title' => 'Car Free Day',
                'event_date' => Carbon::today()->addDays(20),
                'event_time' => '7:00 AM - 10:00 AM',
                'location' => 'Gatenga, Kicukiro',
                'participants' => 'Members, senior teams and volunteers',
                'frequency' => 'Monthly',
                'image' => 'images/traing.JPG',
                'description' => '<p>Promote fitness and community engagement through rugby activities. Our players and volunteers join the city\'s Car Free Day programme with tag rugby, skills stations and games for all ages.</p>',
            ],
            [
                'title' => 'Ndera Hills Rugby Cup',
                'event_date' => Carbon::today()->addDays(45),
                'event_time' => '9:00 AM - 4:00 PM',
                'location' => 'Ndera, Gasabo',
                'participants' => 'Young boys and girls teams',
                'frequency' => 'Annually',
                'image' => 'images/celebr.jpg',
                'description' => '<p>A platform for young players to compete and grow through rugby. The Ndera Hills Rugby Cup brings together age-grade teams from across Kigali for a day of competition, friendship and fun.</p>',
            ],
            [
                'title' => 'Heroes Rugby Cup',
                'event_date' => Carbon::today()->addDays(65),
                'event_time' => '9:00 AM - 5:00 PM',
                'location' => 'Don Bosco Gatenga, Kicukiro',
                'participants' => 'Senior, youth (U18, U16, U12) and grassroots teams',
                'frequency' => 'Annually',
                'image' => 'images/26.JPG',
                'description' => '<p>1000 Hills Rugby joins the nation in celebrating Heroes Day with a full day of rugby for our senior, youth and grassroots teams and the Kicukiro community.</p><p>The Heroes Rugby Cup is more than a competition. It is a moment to celebrate the courage, unity and resilience that rugby can inspire in young people and their families.</p>',
            ],
            [
                'title' => 'GMT 7s',
                'event_date' => Carbon::today()->addDays(80),
                'event_time' => '10:00 AM - 5:00 PM',
                'location' => 'Kigali',
                'participants' => 'Rwanda Rugby Federation teams',
                'frequency' => 'Annually',
                'image' => 'images/rugby-2.jpg',
                'description' => '<p>A tournament to honour those lost in the 1994 Genocide against the Tutsi and promote unity through rugby. Clubs from across the country come together for a day of sevens rugby and remembrance.</p>',
            ],
            [
                'title' => 'Future Cup',
                'event_date' => Carbon::today()->addDays(100),
                'event_time' => '1:00 PM - 5:00 PM',
                'location' => 'Gatenga, Kicukiro',
                'participants' => 'Young boys and girls rugby teams',
                'frequency' => 'Annually',
                'image' => 'images/Girls2025.JPG',
                'description' => '<p>The Future Cup gives our youngest players a stage to enjoy the game. Expect fast running rugby, big smiles and a strong turnout of families and supporters.</p>',
            ],
            [
                'title' => 'Genocide Memorial Visit',
                'event_date' => $lastSaturday->copy()->subDays(9),
                'event_time' => '9:00 AM - 12:00 PM',
                'location' => 'Nyanza Genocide Memorial',
                'participants' => 'Members, senior teams and youth',
                'frequency' => 'Annually',
                'image' => 'images/achive.jpg',
                'description' => '<p>Reflect on the 1994 Genocide against the Tutsi and promote unity and resilience. Players, coaches and staff visit the memorial to remember, learn and commit to building a united community.</p>',
            ],
            [
                'title' => 'Pre-Season Friendly: 1000 Hills Rugby vs Kigali Select',
                'event_date' => Carbon::today()->subDays(30),
                'event_time' => '3:00 PM',
                'location' => 'Don Bosco Gatenga, Kicukiro',
                'participants' => 'Senior men\'s team',
                'frequency' => 'One-time',
                'image' => 'images/image-2.jpg',
                'description' => '<p>A pre-season friendly against Kigali Select, a talented group of players from different teams in Kigali. The match gave our senior team valuable game time ahead of the national league.</p>',
            ],
            [
                'title' => 'Safeguarding Training',
                'event_date' => Carbon::today()->subDays(55),
                'event_time' => '9:00 AM - 1:00 PM',
                'location' => 'Don Bosco Gatenga, Kicukiro',
                'participants' => 'Coaches, staff and volunteers',
                'frequency' => 'Annually',
                'image' => 'uploads/SAFEGUARDING TRAINING 250524/10.JPG',
                'description' => '<p>Coaches, staff and volunteers came together to review the club\'s safeguarding policies, code of conduct and reporting pathways, reinforcing our commitment to putting player welfare first.</p>',
            ],
        ];

        foreach ($events as $data) {
            Event::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                $data + ['slug' => Str::slug($data['title']), 'is_published' => true]
            );
        }
    }
}
