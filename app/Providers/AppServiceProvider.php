<?php

namespace App\Providers;

use App\Support\AdminNavigation;
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
        View::composer(['layouts.admin', 'admin.*'], function ($view) {
            $view->with([
                'adminContentPages' => AdminNavigation::contentPages(),
                'adminNewSubmissions' => AdminNavigation::newSubmissionsCount(),
                'adminUser' => Auth::user(),
            ]);
        });
    }
}
