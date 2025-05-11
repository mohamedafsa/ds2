<?php

namespace App\Providers;

use App\Models\Goal;
use App\Observers\GoalObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Goal::observe(GoalObserver::class);
    }

    public function register()
    {
        //
    }
}