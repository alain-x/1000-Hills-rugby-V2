<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Excite News For SHALOM Our Safeguarding Officer',
                'slug' => 'excite-news-for-shalom-our-safeguarding-officer',
                'category' => 'Club News',
                'excerpt' => 'We are excited to announce that Shalom is taking on his new role as Safeguarding Officer at 1000 Hills Rugby.',
                'featured_image' => 'uploads/1740404978_shalom.jpg',
                'author' => '1000 Hills Rugby',
                'published_at' => now()->subDays(1),
                'is_featured' => true,
                'views' => 428,
                'body' => <<<'HTML'
<p>We are excited to announce that Shalom is taking on his new role as Safeguarding Officer at 1000 Hills Rugby! Over the past 10 years, Shalom has grown with us, starting from tag rugby to the development team, then the senior team, and now as a coach for the development team. He is a true example of success and dedication.</p>
<blockquote><p>“I will work with the team to create a safe environment for children and everyone in our programs, and I will ensure our policies are clear and understood by all our stakeholders.”</p></blockquote>
<p>We are proud of Shalom and his commitment to making a positive impact!</p>
HTML,
            ],
            [
                'title' => "The Women National League, One of a kind for our women's team",
                'slug' => 'women-national-league-one-of-a-kind',
                'category' => "Women's Rugby",
                'excerpt' => 'For the first time ever, 1000 Hills Rugby will be represented in the Women National League.',
                'featured_image' => 'images/Girls2025.JPG',
                'author' => '1000 Hills Rugby',
                'published_at' => now()->subDays(4),
                'is_featured' => false,
                'views' => 356,
                'body' => <<<'HTML'
<p>For years, we dreamed of the day our women’s team would take their place on the big stage. That day has finally come! For the first time ever, 1000 Hills Rugby will be represented in the Women National League.</p>
<p>It’s hard to believe that not long ago, many of these players were too young to participate, and we didn’t even have a senior women’s team to compete. But through passion, perseverance, and countless hours of hard work, these incredible women have grown into a team ready to make history.</p>
<p>This isn’t just about rugby—it’s about breaking barriers and showing the power of determination. The journey begins now, and we couldn’t be prouder!</p>
HTML,
            ],
            [
                'title' => 'Preparing for Rugby Season: Coach’s Advice',
                'slug' => 'preparing-for-rugby-season-coachs-advice',
                'category' => 'Coaching',
                'excerpt' => 'Coach Jimy Mugabo encourages players to start the season strong by setting clear goals, focusing on fitness, and mastering the basics of rugby.',
                'featured_image' => 'images/adv.jpg',
                'author' => '1000 Hills Rugby',
                'published_at' => now()->subDays(7),
                'is_featured' => false,
                'views' => 291,
                'body' => <<<'HTML'
<p>Coach Jimy Mugabo encourages players to start the season strong by setting clear goals, focusing on fitness, and mastering the basics of rugby. He highlights the importance of building team spirit, staying mentally prepared, and maintaining good health through proper nutrition, hydration, and rest.</p>
<blockquote><p>“Preparation is about creating habits that lead to success. Train hard, trust your team, and let’s make this season unforgettable!”</p></blockquote>
<p>Let’s go, 1000 Hills Rugby! The season is ours to win!</p>
HTML,
            ],
            [
                'title' => 'Pre-Season Friendly: 1000 Hills Rugby vs Kigali Select',
                'slug' => 'pre-season-friendly-1000-hills-vs-kigali-select',
                'category' => 'Match Preview',
                'excerpt' => 'The excitement is building as we gear up for the Pre-Season Friendly: 1000 Hills Rugby vs Kigali Select.',
                'featured_image' => 'images/image-2.jpg',
                'author' => '1000 Hills Rugby',
                'published_at' => now()->subDays(11),
                'is_featured' => false,
                'views' => 214,
                'body' => <<<'HTML'
<p>The excitement is building as we gear up for the Pre-Season Friendly: 1000 Hills Rugby vs Kigali Select! Kigali Select, a talented group of players from different teams in Kigali, promises to bring tough competition.</p>
<p>This game is a great opportunity for our senior team to prepare for the upcoming National League. Stay tuned for more details, including the date, time, and venue, and get ready to cheer on our team as they kick off the season with passion and determination!</p>
HTML,
            ],
            [
                'title' => 'Heroes Rugby Cup 2025',
                'slug' => 'heroes-rugby-cup-2025',
                'category' => 'Tournaments',
                'excerpt' => '1000 Hills Rugby joins the nation in celebrating Heroes Day with a full day of rugby for senior, youth and grassroots teams.',
                'featured_image' => 'images/celebr.jpg',
                'author' => '1000 Hills Rugby',
                'published_at' => now()->subDays(15),
                'is_featured' => false,
                'views' => 188,
                'body' => <<<'HTML'
<p>1000 Hills Rugby joined the nation in celebrating Heroes Day with a full day of rugby for our senior, youth (U18, U16 and U12) teams and the Kicukiro community.</p>
<p>The Heroes Rugby Cup is more than a competition. It is a moment to celebrate the courage, unity and resilience that rugby can inspire in young people and their families.</p>
HTML,
            ],
            [
                'title' => 'Umuganda Fun Rugby brings the community together',
                'slug' => 'umuganda-fun-rugby-community',
                'category' => 'Community',
                'excerpt' => 'Community service followed by rugby games to promote the sport and its values across Kicukiro.',
                'featured_image' => 'images/allmember1.jpg',
                'author' => '1000 Hills Rugby',
                'published_at' => now()->subDays(19),
                'is_featured' => false,
                'views' => 167,
                'body' => <<<'HTML'
<p>Umuganda Fun Rugby brings together youth (U18, U16 and U12), our senior men’s and women’s teams, and local community members for a morning of community service followed by rugby games.</p>
<p>Held on the last Saturday of every month, 8:00 AM - 11:00 AM CAT, in Kicukiro District and local communities in Kigali, the initiative uses rugby to promote unity, health, fitness and the values that matter both on and off the field.</p>
HTML,
            ],
            [
                'title' => 'Safeguarding training strengthens our commitment to player welfare',
                'slug' => 'safeguarding-training-player-welfare',
                'category' => 'Club News',
                'excerpt' => 'Coaches, staff and volunteers came together to review our safeguarding policies and reporting pathways.',
                'featured_image' => 'uploads/SAFEGUARDING TRAINING 250524/10.JPG',
                'author' => '1000 Hills Rugby',
                'published_at' => now()->subDays(23),
                'is_featured' => false,
                'views' => 143,
                'body' => <<<'HTML'
<p>Coaches, staff and volunteers came together for a safeguarding training session to review the club’s safeguarding policies, code of conduct and reporting pathways.</p>
<p>Creating a safe environment for children and everyone in our programmes is a responsibility we all share. The workshop reinforced our commitment to listening, responding and putting player welfare first.</p>
HTML,
            ],
            [
                'title' => '1000 Hills Rugby competes in the National Rugby Championship',
                'slug' => '1000-hills-rugby-national-rugby-championship',
                'category' => 'Match Report',
                'excerpt' => "Our senior men's team competed in the Rwanda Rugby Men's 15s National League Season 2025.",
                'featured_image' => 'uploads/NRC25/IMG_1931.JPG',
                'gallery' => [
                    'uploads/NRC25/IMG_1906.JPG',
                    'uploads/NRC25/IMG_1917.JPG',
                    'uploads/NRC25/IMG_1938.JPG',
                    'uploads/NRC25/IMG_1975.JPG',
                    'uploads/NRC25/IMG_2018.JPG',
                    'uploads/NRC25/IMG_2057.JPG',
                ],
                'author' => '1000 Hills Rugby',
                'published_at' => now()->subDays(28),
                'is_featured' => false,
                'views' => 512,
                'body' => <<<'HTML'
<p>1000 Hills Rugby competed in the Rwanda Rugby Men’s 15s National League Season 2025. The campaign gave our senior men’s team valuable exposure against the best clubs in the country and gave our young players a taste of the standard they are working towards.</p>
HTML,
                'sections' => [
                    [
                        'subtitle' => 'A hard-fought campaign',
                        'content' => '<p>Every match was a learning opportunity. The squad faced physical opposition, adapted to different playing styles and grew in confidence with each outing. The commitment of the players and the support of the coaching team were on show from the first whistle to the last.</p>',
                    ],
                    [
                        'subtitle' => 'Looking ahead',
                        'content' => '<p>The experience of the National Rugby Championship is already shaping our preparations for the next season. Our focus remains on developing local talent, strengthening the pathway from the academy to the senior team, and representing Rwanda with pride.</p>',
                    ],
                ],
            ],
        ];

        foreach ($articles as $data) {
            $sections = $data['sections'] ?? [];
            unset($data['sections']);

            $article = Article::updateOrCreate(
                ['slug' => $data['slug']],
                $data + ['is_published' => true]
            );

            $article->sections()->delete();

            foreach ($sections as $index => $section) {
                $article->sections()->create([
                    'subtitle' => $section['subtitle'],
                    'content' => $section['content'],
                    'sort_order' => $index + 1,
                ]);
            }
        }
    }
}
