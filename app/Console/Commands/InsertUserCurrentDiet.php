<?php

namespace App\Console\Commands;

use App\Models\CurrentDayDiet;
use App\Models\UserDiet;
use Illuminate\Console\Command;

class InsertUserCurrentDiet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:diets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User Current Diets Day Wise Added in curren_day_diets table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current day of the week (e.g., 'monday')
        $dayOfWeek = strtolower(now()->format('l'));

        // Fetch the diets assigned for the current day
        $userDiets = UserDiet::where('day', $dayOfWeek)->get();

        if ($userDiets->isEmpty()) {
            $this->info("No diets found for {$dayOfWeek}");
        } else {
            foreach ($userDiets as $userDiet) {
                // Check if the diet already exists in the CurrentDayDiet table for today
                $existingDiet = CurrentDayDiet::where('diet_id', $userDiet->diet_id)
                    ->whereDate('created_at', now()->toDateString()) // Check for today's date
                    ->where('user_id', $userDiet->user_id)
                    ->exists();

                if ($existingDiet) {
                    $this->info("Diet for user ID {$userDiet->user_id} is already added for today.");
                    continue; // Skip this iteration if the diet already exists
                }

                // Prepare the details array for all meals
                $detailsArray = [
                    'meal_name'                    => $userDiet->meal_name,
                    'diet_description'             => $userDiet->diet_description,
                    'alternative_diet_description' => $userDiet->alternative_diet_description,
                    'carbs'                        => $userDiet->carbs,
                    'fats'                         => $userDiet->fats,
                    'protein'                      => $userDiet->protein,
                    'calories'                     => $userDiet->calories,
                    'status'                       => 'not completed'
                ];

                // Convert the details array to JSON
                $detailsJson = json_encode($detailsArray);

                // Insert the diet into the CurrentDayDiet table
                CurrentDayDiet::create([
                    'diet_id'        => $userDiet->diet_id,
                    'user_diet_id'   => $userDiet->id,
                    'gym_id'         => $userDiet->gym_id,
                    'user_id'        => $userDiet->user_id,
                    'details'        => $detailsJson,
                    'total_fats'     => $userDiet->fats,
                    'total_carbs'    => $userDiet->carbs,
                    'total_protein'  => $userDiet->protein,
                    'total_calories' => $userDiet->calories
                ]);
            }
            $this->info("Diets for {$dayOfWeek} have been successfully added to the CurrentDayDiet table!");
        }
    }

}
