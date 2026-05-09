<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\Gate::define('manage-finance', function ($user) {
            return in_array($user->role, ['Super Admin', 'Treasurer']);
        });

        \Illuminate\Support\Facades\Gate::define('manage-users', function ($user) {
            return in_array($user->role, ['Super Admin', 'Pastor']);
        });

        \Illuminate\Support\Facades\Gate::define('manage-departments', function ($user) {
            return in_array($user->role, ['Super Admin', 'Pastor', 'Head Elder']);
        });
    }
}
