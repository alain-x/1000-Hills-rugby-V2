<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use App\Models\Fixture;
use App\Models\Player;
use App\Models\Sponsor;
use App\Models\Team;
use App\Models\WeeklySchedule;

class HomeController extends Controller
{
    public function index()
    {
        // The newest published story always leads the homepage.
        $featured = Article::published()->orderedByDate()->first();

        $articles = Article::published()
            ->when($featured, fn ($q) => $q->whereKeyNot($featured->id))
            ->orderedByDate()
            ->take(3)
            ->get();

        $upcoming = Fixture::published()->upcoming()->take(4)->get();
        $results = Fixture::published()->completed()->take(4)->get();
        $sponsors = Sponsor::where('is_active', true)->orderBy('sort_order')->take(10)->get();
        $schedule = WeeklySchedule::where('is_active', true)->orderBy('sort_order')->take(5)->get();
        $event = Event::published()->upcoming()->first();
        $teams = Team::active()->get();

        $stats = [
            'teams' => $teams->count(),
            'players' => Player::published()->count(),
            'articles' => Article::published()->count(), 'years' => max(1, (int) date('Y') - 2015),
        ];

        return view('public.home', compact(
            'featured', 'articles', 'upcoming', 'results', 'sponsors', 'schedule', 'event', 'teams', 'stats'
        ));
    }
}
