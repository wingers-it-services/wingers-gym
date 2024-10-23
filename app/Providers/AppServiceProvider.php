<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Schedule;
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
    public function boot(Schedule $schedule)
    {
        $schedule->command('user:workout')->dailyAt('00:01');

        $schedule->command('user:diets')->dailyAt('00:01');

        $schedule->command('user:attendence')->monthlyOn(1, '00:00');

        $schedule->command('user:delete-previous-day-workout')->dailyAt('00:01');

        $schedule->command('user:delete-previous-day-diet')->dailyAt('00:01');
        
        $schedule->command('user:daily-attendence-update-cron')->everyMinute();
    }
}
