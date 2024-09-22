<?php

namespace App\Http\Controllers;

use App\Models\DietAnalytic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DietAnalyticControllerApi extends Controller
{
    public function fetchUserDietAnalytic(Request $request)
    {
        try {
            // Validate gym_id presence and existence
            $request->validate([
                'gym_id' => 'required|exists:gyms,id'
            ]);

            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            // Fetch diet analytics for the current month and year
            $currentMonthDietAnalytics = DietAnalytic::where('user_id', auth()->user()->id)
                ->where('gym_id', $request->gym_id)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->get();

            // Initialize an array for current month's percentages
            $currentMonthPercentages = [
                'fats' => 0,
                'carbs' => 0,
                'protein' => 0,
                'calories' => 0
            ];

            // If analytics are found, set the percentage values from the database
            if ($currentMonthDietAnalytics->isNotEmpty()) {
                $currentMonthPercentages = [
                    'fats' => $currentMonthDietAnalytics->avg('fat_percentage'),
                    'carbs' => $currentMonthDietAnalytics->avg('carb_percentage'),
                    'protein' => $currentMonthDietAnalytics->avg('protein_percentage'),
                    'calories' => $currentMonthDietAnalytics->avg('calories_percentage'),
                ];
            }

            // Fetch diet analytics for all months based on 'month' and 'year' fields
            $allMonthDietAnalytics = DietAnalytic::where('user_id', auth()->user()->id)
                ->where('gym_id', $request->gym_id)
                ->get()
                ->groupBy(function ($item) {
                    return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT); // Group by year-month
                });

            // Prepare array for all months data (total and consumed)
            $allMonthData = [];

            foreach ($allMonthDietAnalytics as $monthYear => $data) {
                $allMonthData[$monthYear] = [
                    'total_fats' => $data->sum('total_fats'),
                    'consumed_fats' => $data->sum('total_fats_consumed'),
                    'total_carbs' => $data->sum('total_carbs'),
                    'consumed_carbs' => $data->sum('total_carbs_consumed'),
                    'total_protein' => $data->sum('total_protein'),
                    'consumed_protein' => $data->sum('total_protein_consumed'),
                    'total_calories' => $data->sum('total_calories'),
                    'consumed_calories' => $data->sum('total_calories_consumed'),
                ];
            }

            return response()->json([
                'status' => 200,
                'currentMonthPercentages' => $currentMonthPercentages,
                'allMonthData' => $allMonthData,
                'message' => 'Diet analytics fetched successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('[DietAnalyticControllerApi][fetchUserDietAnalytic] Error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Error fetching diet analytics: ' . $e->getMessage(),
            ], 500);
        }
    }
}
