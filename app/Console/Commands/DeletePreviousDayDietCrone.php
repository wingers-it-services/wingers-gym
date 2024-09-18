<?php

namespace App\Console\Commands;

use App\Models\CurrentDayDiet;
use App\Models\DietAnalytic;
use Illuminate\Console\Command;

class DeletePreviousDayDietCrone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete-previous-day-diet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the Previous Day Diet from CurrentDayDiet table Date wise and Insert that data in the DietAnalytics table';

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
        $userPreviousWorkouts = CurrentDayDiet::whereBetween('created_at', [$previousDayStart, $previousDayEnd])->get();

        $userPreviousWorkouts->each(function ($item) use ($currentMonth, $currentYear) {
            $diet = DietAnalytic::where([
                ["month", $currentMonth],
                ["year", $currentYear],
                ["gym_id", $item['gym_id']],
                ["user_id", $item['user_id']],
                ["user_diet_id", $item['user_diet_id']]
            ])->first();

            $dietDetails = $this->generateDietDetails($item['details']);

            if (!$diet) {
                DietAnalytic::create([
                    "month"                     => $currentMonth,
                    "year"                      => $currentYear,
                    "gym_id"                    => $item['gym_id'],
                    "user_id"                   => $item['user_id'],
                    "diet_id"                   => $item['diet_id'],
                    "user_diet_id"              => $item['user_diet_id'],
                    "total_fats"                => $dietDetails['total_fats'],
                    "total_fats_consumed"       => $dietDetails['total_fats_consumed'],
                    "fat_percentage"            => $dietDetails['fat_percentage'],
                    "total_carbs"               => $dietDetails['total_carbs'],
                    "total_carbs_consumed"      => $dietDetails['total_carbs_consumed'],
                    "carb_percentage"           => $dietDetails['carb_percentage'],
                    "total_protein"             => $dietDetails['total_protein'],
                    "total_protein_consumed"    => $dietDetails['total_protein_consumed'],
                    "protein_percentage"        => $dietDetails['protein_percentage'],
                    "total_calories"            => $dietDetails['total_calories'],
                    "total_calories_consumed"   => $dietDetails['total_calories_consumed'],
                    "calories_percentage"       => $dietDetails['calories_percentage']
                ]);
            } else {
                $diet->update([
                    "total_fats"                => $dietDetails['total_fats'],
                    "total_fats_consumed"       => $dietDetails['total_fats_consumed'],
                    "fat_percentage"            => $dietDetails['fat_percentage'],
                    "total_carbs"               => $dietDetails['total_carbs'],
                    "total_carbs_consumed"      => $dietDetails['total_carbs_consumed'],
                    "carb_percentage"           => $dietDetails['carb_percentage'],
                    "total_protein"             => $dietDetails['total_protein'],
                    "total_protein_consumed"    => $dietDetails['total_protein_consumed'],
                    "protein_percentage"        => $dietDetails['protein_percentage'],
                    "total_calories"            => $dietDetails['total_calories'],
                    "total_calories_consumed"   => $dietDetails['total_calories_consumed'],
                    "calories_percentage"       => $dietDetails['calories_percentage']
                ]);
            }
            // After processing, delete the current record
            $item->delete();
        });
        $this->info("Diets for {$previousDayStart} have been deleted successfully That data move to the DietAnalytics Table!");
    }

    private function generateDietDetails($details)
    {
        $details = json_decode($details, true); // Decode JSON into an associative array
        $totalFats = 0;
        $totalFatsConsumed = 0;
        $totalCarbs = 0;
        $totalCarbsConsumed = 0;
        $totalProtein = 0;
        $totalProteinConsumed = 0;
        $totalCalories = 0;
        $totalCaloriesConsumed = 0;


        $totalFats = $details['fats'];
        $totalCarbs = $details['carbs'];
        $totalProtein = $details['protein'];
        $totalCalories = $details['calories'];

        // If the diet is completed, add the consumed values
        if ($details['status'] === 'completed') {
            $totalFatsConsumed += $totalFats;
            $totalCarbsConsumed += $totalCarbs;
            $totalProteinConsumed += $totalProtein;
            $totalCaloriesConsumed += $totalCalories;
        }

        // Calculate percentage consumed for each nutrient
        $fatsPercentage = $this->calculateCompletedSetsPercentage($totalFatsConsumed, $totalFats);
        $carbsPercentage = $this->calculateCompletedSetsPercentage($totalCarbsConsumed, $totalCarbs);
        $proteinPercentage = $this->calculateCompletedSetsPercentage($totalProteinConsumed, $totalProtein);
        $caloriesPercentage = $this->calculateCompletedSetsPercentage($totalCaloriesConsumed, $totalCalories);

        // Return an array with totals and the nutrient consumption percentages
        return [
            "total_fats"                => $totalFats,
            "total_fats_consumed"       => $totalFatsConsumed,
            "fat_percentage"            => $fatsPercentage,
            "total_carbs"               =>  $totalCarbs,
            "total_carbs_consumed"      => $totalCarbsConsumed,
            "carb_percentage"           =>  $carbsPercentage,
            "total_protein"             => $totalProtein,
            "total_protein_consumed"    => $totalProteinConsumed,
            "protein_percentage"        =>   $proteinPercentage,
            "total_calories"            =>   $totalCalories,
            "total_calories_consumed"   =>  $totalCaloriesConsumed,
            "calories_percentage"       => $caloriesPercentage
        ];
    }

    private function calculateCompletedSetsPercentage($totalConsumed, $total)
    {
        if ($total == 0) {
            return 0.00;
        } else {
            $percentage = $totalConsumed / $total * 100;
            return $percentage;
        }
    }
}
