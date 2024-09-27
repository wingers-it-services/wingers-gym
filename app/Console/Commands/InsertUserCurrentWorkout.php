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
    protected $signature = 'user:workout {user_id?}'; // Optional user_id argument

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add current day workouts for all users or a specific user to the current_day_workouts table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current day of the week (e.g., 'monday')
        $dayOfWeek = strtolower(now()->format('l'));

        // Check if a specific user ID is provided
        $userId = $this->argument('user_id');

        // Fetch workouts based on the provided user ID or for all users if no ID is provided
        $query = UserWorkout::where('day', $dayOfWeek);

        if ($userId) {
            $query->where('user_id', $userId);
            $this->info("Processing workouts for user ID: {$userId} on {$dayOfWeek}");
        } else {
            $this->info("Processing workouts for all users on {$dayOfWeek}");
        }

        // Get the workouts for the day (filtered by user if applicable)
        $userWorkouts = $query->get();

        // Check if there are any workouts to process
        if ($userWorkouts->isEmpty()) {
            $this->info("No workouts found for {$dayOfWeek}");
            return false;
        }

        // Process each workout and insert it into the CurrentDayWorkout table
        foreach ($userWorkouts as $userWorkout) {
            // Generate the initial details array
            $detailsArray = $this->generateInitialDetails($userWorkout->sets, $userWorkout->reps, $userWorkout->weight);

            // Convert the details array to JSON
            $detailsJson = json_encode($detailsArray);

            // Insert the workout into the CurrentDayWorkout table
            CurrentDayWorkout::create([
                'workout_id'         => $userWorkout->workout_id,
                'user_workout_id'    => $userWorkout->id,
                'targeted_body_part' => $userWorkout->targeted_body_part,
                'gym_id'             => $userWorkout->gym_id,
                'user_id'            => $userWorkout->user_id,
                'details'            => $detailsJson, // Store JSON-encoded details
            ]);
        }

        // Output a success message
        if ($userId) {
            $this->info("Workouts for user ID {$userId} have been successfully added to the CurrentDayWorkout table!");
        } else {
            $this->info("Workouts for all users have been successfully added to the CurrentDayWorkout table!");
        }

        return true;
    }

    /**
     * Generate initial details for the specified number of sets.
     *
     * @param int $numSets
     * @param int $numReps
     * @param int $weight
     * @return array
     */
    private function generateInitialDetails($numSets, $numReps, $weight)
    {
        $details = [];

        for ($i = 1; $i <= $numSets; $i++) {
            $details["set{$i}"] = [
                [
                    'time'   => '00:00',
                    'status' => 'not completed',
                    'raps'   => $numReps,
                    'weight' => $weight,
                ]
            ];
        }

        return $details;
    }
}
