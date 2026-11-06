<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ClubController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\FixtureController as AdminFixtureController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PlayerController as AdminPlayerController;
use App\Http\Controllers\Admin\ResourceController as AdminResourceController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SponsorController as AdminSponsorController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\Admin\StandingController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WeeklyScheduleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StandingController as PublicStandingController;
use App\Http\Controllers\SubscriberController as PublicSubscriberController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/media/{image}', [MediaController::class, 'show'])->name('media.show');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{article}', [NewsController::class, 'show'])->name('news.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/fixtures', [FixtureController::class, 'index'])->name('fixtures.index');
Route::get('/tables', [PublicStandingController::class, 'index'])->name('tables.index');

Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
Route::get('/players/{player}', [PlayerController::class, 'show'])->name('players.show');

Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors.index');

Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{resource}/download', [ResourceController::class, 'download'])->name('resources.download');

Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:6,1')->name('contact.store');
Route::post('/subscribe', [PublicSubscriberController::class, 'store'])->middleware('throttle:5,1')->name('subscribe');

Route::get('/donate', [DonationController::class, 'create'])->name('donate');
Route::post('/donate', [DonationController::class, 'store'])->middleware('throttle:10,1')->name('donate.store');
Route::get('/donation/callback', [DonationController::class, 'callback'])->name('donate.callback');
Route::post('/donation/ipn', [DonationController::class, 'ipn'])->name('donate.ipn');
Route::get('/donation/thank-you/{reference}', [DonationController::class, 'thanks'])->name('donate.thanks');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.attempt');
    });

    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::resource('articles', ArticleController::class)->except('show');
        Route::resource('events', AdminEventController::class)->except('show');
        Route::resource('schedules', WeeklyScheduleController::class)->except('show');
        Route::resource('pages', AdminPageController::class);
        Route::resource('resources', AdminResourceController::class)->except('show');

        Route::resource('teams', AdminTeamController::class);
        Route::resource('players', AdminPlayerController::class);
        Route::resource('staff', AdminStaffController::class);
        Route::resource('sponsors', AdminSponsorController::class);

        Route::resource('fixtures', AdminFixtureController::class)->except('show');
        Route::resource('standings', StandingController::class)->except('show');
        Route::resource('competitions', CompetitionController::class)->except(['show', 'create', 'edit']);
        Route::resource('seasons', SeasonController::class)->except(['show', 'create', 'edit']);
        Route::resource('clubs', ClubController::class)->except(['show', 'create', 'edit']);

        Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
        Route::patch('messages/{message}/read', [ContactMessageController::class, 'markRead'])->name('messages.read');
        Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('donations', [AdminDonationController::class, 'index'])->name('donations.index');
        Route::get('donations/{donation}', [AdminDonationController::class, 'show'])->name('donations.show');

        Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
        Route::delete('subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
        Route::get('subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');

        Route::middleware('superadmin')->group(function () {
            Route::resource('users', UserController::class)->except('show');
            Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
            Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
            Route::get('activity', [SettingController::class, 'activity'])->name('activity.index');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Editable content pages (about, academy, foundation, community, education, privacy)
| Kept last so it does not shadow /admin and other named routes.
|--------------------------------------------------------------------------
*/

Route::get('/{page}', [PageController::class, 'show'])
    ->where('page', '[a-z0-9\-]+')
    ->name('pages.show');
