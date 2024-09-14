<?php

namespace App\Console\Commands;

use App\Models\CurrentDayWorkout;
use App\Models\UserWorkout;
use App\Models\WorkoutAnalytic;
use Illuminate\Console\Command;
use PhpParser\Node\Stmt\Foreach_;

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
        $currentMonth = now()->month;
        $currentYear = now()->year;
        // Fetch records created between the start and end of the previous day
        $userPreviousWorkouts = CurrentDayWorkout::whereBetween('created_at', [$previousDayStart, $previousDayEnd])->get();

        $userPreviousWorkouts->each(function ($item) use ($currentMonth, $currentYear) {
            $workout = WorkoutAnalytic::where([
                ["month", $currentMonth],
                ["year", $currentYear],
                ["gym_id", $item['gym_id']],
                ["user_id", $item['user_id']],
                ["user_workout_id", $item['user_workout_id']]
            ])->first();

            $this->generateSetDetails($item['details']);

            if (!$workout) {
                WorkoutAnalytic::create([
                    "month" => $currentMonth,
                    "year" => $currentYear,
                    "gym_id" => $item['gym_id'],
                    "user_id" => $item['user_id'],
                    "workout_id" => $item['workout_id'],
                    "user_workout_id" => $item['user_workout_id'],

                    "total_sets" => $item['user_id'],
                    "total_sets_completed" => $item['workout_id'],
                    "percentage" => $item['user_workout_id']
                ])->first();
            }
        });
    }

    private function generateSetDetails($details)
    {
        $details = json_decode($details);
        $totalSets = 0;
        $totalSetsCompleted = 0;

        foreach ($details as $detail) {
            if ($detail[0]['status'] == "not completed") {
                $totalSets += 1;
            } else {
                $totalSets += 1;
                $totalSetsCompleted += 1;
            }
        }

        dd([$totalSets, $totalSetsCompleted]);
        return [$totalSets, $totalSetsCompleted];
    }
}
