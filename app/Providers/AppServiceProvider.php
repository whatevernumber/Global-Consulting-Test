<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
            Inertia::share([
                'errors' => function () { return Session::get('errors') ? Session::get('errors')->getBag('default')->getMessages() : (object) []; },
                'user' =>  function () { return Auth::user() ? Auth::user() : null; },
            ]);
    }
}
