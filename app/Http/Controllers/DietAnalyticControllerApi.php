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
    
            $userId = auth()->user()->id;
            $gymId = $request->gym_id;
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
    
            // Fetch diet analytics for the current month and year
            $currentMonthDietAnalytics = DietAnalytic::where('user_id', $userId)
                ->where('gym_id', $gymId)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->get();
    
            // Initialize percentages array with default values for the current month
            $percentages = [
                [
                    'title' => 'carbs',
                    'subtitle' => 'carbs',
                    'percentage' => 0
                ],
                [
                    'title' => 'fats',
                    'subtitle' => 'fats defats',
                    'percentage' => 0
                ],
                [
                    'title' => 'protein',
                    'subtitle' => 'protein',
                    'percentage' => 0
                ],
                [
                    'title' => 'calories',
                    'subtitle' => 'calories',
                    'percentage' => 0
                ]
            ];
    
            // If current month's data is available, calculate the average percentages
            if ($currentMonthDietAnalytics->isNotEmpty()) {
                $percentages = [
                    [
                        'title' => 'carbs',
                        'subtitle' => 'carbs',
                        'percentage' => round($currentMonthDietAnalytics->avg('carb_percentage'), 2)
                    ],
                    [
                        'title' => 'fats',
                        'subtitle' => 'fats defats',
                        'percentage' => round($currentMonthDietAnalytics->avg('fat_percentage'), 2)
                    ],
                    [
                        'title' => 'protein',
                        'subtitle' => 'protein',
                        'percentage' => round($currentMonthDietAnalytics->avg('protein_percentage'), 2)
                    ],
                    [
                        'title' => 'calories',
                        'subtitle' => 'calories',
                        'percentage' => round($currentMonthDietAnalytics->avg('calories_percentage'), 2)
                    ]
                ];
            }
    
            // Fetch diet analytics for all months grouped by 'year-month'
            $allMonthDietAnalytics = DietAnalytic::where('user_id', $userId)
                ->where('gym_id', $gymId)
                ->get()
                ->groupBy(function ($item) {
                    return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT); // Group by year-month
                });
    
            // Prepare dynamic array for all months data (total and consumed values)
            $allMonthData = [];
    
            foreach ($allMonthDietAnalytics as $monthYear => $data) {
                // Extract year and month
                [$year, $month] = explode('-', $monthYear);
                $monthName = Carbon::createFromFormat('m', $month)->format('M'); // Convert month number to short month name (e.g., Jan)
    
                // Add data dynamically for each month
                $allMonthData[] = [
                    'month' => $monthName, // Month short name like Jan, Feb, etc.
                    'total_fats' => $data->sum('total_fats'),
                    'consumed_fats' => $data->sum('total_fats_consumed'),
                    'total_carbs' => $data->sum('total_carbs'),
                    'consumed_carbs' => $data->sum('total_carbs_consumed'),
                    'total_protein' => $data->sum('total_protein'),
                    'consumed_protein' => $data->sum('total_protein_consumed'),
                    'total_calories' => $data->sum('total_calories'),
                    'consumed_calories' => $data->sum('total_calories_consumed'),
                    'color' => '#FFD700' // You can add a logic for dynamic color if needed
                ];
            }
    
            return response()->json([
                'status' => 200,
                'percentages' => $percentages, // Dynamic current month percentages
                'allMonthData' => $allMonthData, // Dynamic all months data
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
