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
        $schedule->command('emails:send');
        //For Workout
        $schedule->command('user:workout')->everyMinute();
        //For Diet
        $schedule->command('user:diets')->everyMinute();
        
        $schedule->command('user:attendence')->monthlyOn(1, '00:00');

    }


}
