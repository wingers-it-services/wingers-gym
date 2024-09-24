<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RunCronController extends Controller
{
    public function runWorkoutCronJob()
    {
        Artisan::call('user:workout');
        return redirect()->back()->with('status', 'success')->with('message', 'Cron job executed successfully');
    }

    public function runDietCronJob()
    {
        Artisan::call('user:diets');
        return redirect()->back()->with('status', 'success')->with('message', 'Cron job executed successfully');
    }

    public function runAttendenceCronJob()
    {
        Artisan::call('user:attendence');
        return redirect()->back()->with('status', 'success')->with('message', 'Cron job executed successfully');
    }

    public function runWorkoutHistryCronJob()
    {
        Artisan::call('user:delete-previous-day-workout');
        return redirect()->back()->with('status', 'success')->with('message', 'Cron job executed successfully');
    }

    public function runDietHistryCronJob()
    {
        Artisan::call('user:delete-previous-day-diet');
        return redirect()->back()->with('status', 'success')->with('message', 'Cron job executed successfully');
    }
    
}
