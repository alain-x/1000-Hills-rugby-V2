<?php

namespace App\Providers;

use App\Models\ContactMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('admin.layouts.app', function ($view) {
            $unreadCount = 0;

            if (Auth::check()) {
                $unreadCount = ContactMessage::where('is_read', false)->count();
            }

            $view->with('unreadCount', $unreadCount);
        });
    }
}
