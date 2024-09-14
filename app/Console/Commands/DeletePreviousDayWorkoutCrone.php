<?php

namespace App\Console\Commands;

use App\Models\CurrentDayWorkout;
use App\Models\UserWorkout;
use Illuminate\Console\Command;

class DeletePreviousDayWorkoutCrone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete-previous-day-workout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the Previous Day Workout Date wise';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the start and end of the previous day
        $previousDayStart = now()->subDay()->startOfDay();
        $previousDayEnd = now()->subDay()->endOfDay();

        // Fetch records created between the start and end of the previous day
        $userPreviousWorkouts = CurrentDayWorkout::whereBetween('created_at', [$previousDayStart, $previousDayEnd])->get();

    }
}
