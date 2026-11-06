<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Fixture;
use App\Models\Player;
use App\Models\Sponsor;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()?->isCoach()) {
            return redirect()->route('admin.sessions.index');
        }

        $stats = [
            'articles' => Article::count(),
            'events' => Event::count(),
            'players' => Player::count(),
            'teams' => Team::count(),
            'sponsors' => Sponsor::count(),
            'users' => User::count(),
            'unread' => ContactMessage::where('is_read', false)->count(),
            'donations_total' => Donation::completed()->sum('amount'),
            'donations_count' => Donation::completed()->count(),
            'fixtures' => Fixture::where('status', 'SCHEDULED')->count(),
        ];

        $recentArticles = Article::latest()->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recentDonations = Donation::latest()->take(5)->get();
        $upcoming = Fixture::published()->upcoming()->take(5)->get();

        $months = collect(range(5, 0))->map(fn ($i) => now()->startOfMonth()->subMonths($i));
        $monthlyDonations = $months->map(function (Carbon $month) {
            return [
                'label' => $month->format('M Y'),
                'total' => (float) Donation::completed()
                    ->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                    ->sum('amount'),
            ];
        });

        $popular = Article::orderByDesc('views')->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'recentArticles', 'recentMessages', 'recentDonations',
            'upcoming', 'monthlyDonations', 'popular'
        ));
    }
}
