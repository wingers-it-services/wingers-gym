<?php

namespace App\Console\Commands;

use App\Models\CurrentDayWorkout;
use App\Models\UserWorkout;
use Illuminate\Console\Command;

class InsertUserCurrentWorkout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:workout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User Current Workouts Day Wise Added in curren_day_workouts table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current day of the week (e.g., 'monday')
        $dayOfWeek = strtolower(now()->format('l'));

        // Fetch the workouts assigned for the current day
        $userWorkouts = UserWorkout::where('day', $dayOfWeek)->get();

        if ($userWorkouts->isEmpty()) {
            $this->info("No workouts found for {$dayOfWeek}");
        } else {
            foreach ($userWorkouts as $userWorkout) {
                // Generate the initial details array
                $detailsArray = $this->generateInitialDetails($userWorkout->sets, $userWorkout->reps, $userWorkout->weight);

                // Convert the details array to JSON
                $detailsJson = json_encode($detailsArray);


                // Insert the workout into the CurrentDayWorkout table
                CurrentDayWorkout::create([
                    'workout_id' => $userWorkout->workout_id,
                    'user_workout_id' => $userWorkout->id,
                    'gym_id' => $userWorkout->gym_id,
                    'user_id' => $userWorkout->user_id,
                    'details' => $detailsJson, // Store JSON-encoded details
                ]);
            }
            $this->info("Workouts for {$dayOfWeek} have been successfully added to the CurrentDayWorkout table!");
        }
    }

    /**
     * Generate initial details for the specified number of sets.
     *
     * @param int $numSets
     * @return array
     */
    private function generateInitialDetails($numSets, $numReps, $weight)
    {
        $details = [];

        for ($i = 1; $i <= $numSets; $i++) {
            $details["set{$i}"] = [
                [
                    'time' => '00:00',
                    'status' => 'not completed',
                    'raps' => $numReps,
                    'weight' => $weight,
                ]
            ];
        }

        return $details;
    }
}