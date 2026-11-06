<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use App\Models\Page;
use App\Models\Team;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = collect([
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('news.index'), 'priority' => '0.9'],
            ['loc' => route('events.index'), 'priority' => '0.8'],
            ['loc' => route('fixtures.index'), 'priority' => '0.9'],
            ['loc' => route('tables.index'), 'priority' => '0.7'],
            ['loc' => route('teams.index'), 'priority' => '0.8'],
            ['loc' => route('staff.index'), 'priority' => '0.6'],
            ['loc' => route('sponsors.index'), 'priority' => '0.5'],
            ['loc' => route('resources.index'), 'priority' => '0.6'],
            ['loc' => route('contact.create'), 'priority' => '0.7'],
            ['loc' => route('donate'), 'priority' => '0.7'],
        ]);

        $urls = $urls
            ->concat(Article::published()->get()->map(fn ($a) => ['loc' => route('news.show', $a), 'priority' => '0.8']))
            ->concat(Event::published()->get()->map(fn ($e) => ['loc' => route('events.show', $e), 'priority' => '0.6']))
            ->concat(Team::active()->get()->map(fn ($t) => ['loc' => route('teams.show', $t), 'priority' => '0.7']))
            ->concat(Page::published()->get()->map(fn ($p) => ['loc' => route('pages.show', $p->slug), 'priority' => '0.6']));

        return response()
            ->view('public.sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}
