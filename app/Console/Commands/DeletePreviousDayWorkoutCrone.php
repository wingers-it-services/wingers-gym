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
    protected $description = 'Delete the Previous Day Workout from CurrentDayWorkout table Date wise and Insert that data in the WorkoutAnalytics table';

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
                ["user_workout_id", $item['user_workout_id']],
                ["targeted_body_part", $item['targeted_body_part']]
            ])->first();

            $setDetails = $this->generateSetDetails($item['details']);
            
            if (!$workout) {
                WorkoutAnalytic::create([
                    "month"                => $currentMonth,
                    "year"                 => $currentYear,
                    "gym_id"               => $item['gym_id'],
                    "user_id"              => $item['user_id'],
                    "workout_id"           => $item['workout_id'],
                    "targeted_body_part"   => $item['targeted_body_part'],
                    "user_workout_id"      => $item['user_workout_id'],
                    "total_sets"           => $setDetails['total_sets'],
                    "total_sets_completed" => $setDetails['total_sets_completed'],
                    "percentage"           =>  $setDetails['percentage']
                ]);
            } else {
                $newTotalSets = $workout->total_sets + $setDetails['total_sets'];
                $newTotalSetsCompleted = $workout->total_sets_completed + $setDetails['total_sets_completed'];
                
                // Calculate the new percentage based on the updated values
                $newPercentage = ($newTotalSetsCompleted / $newTotalSets) * 100;
            
                $workout->update([
                    "total_sets"           => $newTotalSets,
                    "total_sets_completed" => $newTotalSetsCompleted,
                    "percentage"           => $newPercentage
                ]);
            }
            // After processing, delete the current record
            $item->delete();
        });
        $this->info("Workouts for {$previousDayStart} have been deleted successfully That data move to the WorkoutAnalytics Table!");
    }

    private function generateSetDetails($details)
    {
        $details = json_decode($details, true); // Decode JSON into an associative array
        $totalSets = 0;
        $totalSetsCompleted = 0;

        // Loop through the dynamic sets (like set1, set2, etc.)
        foreach ($details as $setKey => $setDetails) {
            // Assuming each set is an array with one element, get the first element
            foreach ($setDetails as $set) {
                $totalSets += 1; // Increment total sets
                if ($set['status'] == "completed") {
                    $totalSetsCompleted += 1; // Increment completed sets
                }
            }
        }

        $completionPercentage = $this->calculateCompletedSetsPercentage($totalSetsCompleted, $totalSets);

        return ["total_sets" => $totalSets, "total_sets_completed" => $totalSetsCompleted, "percentage" => $completionPercentage];
    }

    private function calculateCompletedSetsPercentage($totalSetsCompleted, $totalSets)
    {
        if ($totalSets == 0) {
            return 0.00;
        } else {
            $percentage = $totalSetsCompleted / $totalSets * 100;
            return $percentage;
        }
    }
}
