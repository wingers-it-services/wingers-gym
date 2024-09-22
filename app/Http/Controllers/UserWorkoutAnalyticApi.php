<?php

namespace App\Http\Controllers;

use App\Models\WorkoutAnalytic;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserWorkoutAnalyticApi extends Controller
{
    public function fetchUserWorkoutAnalytic(Request $request)
    {
        try {
    
            $request->validate([
                'gym_id' => 'required|exists:gyms,id'
            ]);
    
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
    
            // List of body parts to ensure consistency in the output
            $bodyParts = ['shoulder', 'abs', 'leg', 'chest', 'back', 'biceps', 'triceps', 'forearm'];
    
            // Fetch workout analytics for the current month and year for percentage calculation
            $currentMonthAnalytics = WorkoutAnalytic::where('user_id', auth()->user()->id)
                ->where('gym_id', $request->gym_id)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->get()
                ->groupBy('targeted_body_part');
    
            // Fetch workout analytics for all months based on 'month' and 'year' fields for allotted and completed sets calculation
            $allMonthAnalytics = WorkoutAnalytic::where('user_id', auth()->user()->id)
                ->where('gym_id', $request->gym_id)
                ->get()
                ->groupBy(function ($item) {
                    return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT); // Group by year-month from fields
                });
    
            // Initialize percentages array for the current month with zero values
            $percentages = array_fill_keys($bodyParts, 0);
    
            // Initialize sets array for all months
            $sets = [];
    
            // Loop through current month analytics for percentage calculation
            foreach ($currentMonthAnalytics as $bodyPart => $data) {
                $bodyPartKey = strtolower($bodyPart);
                if (in_array($bodyPartKey, $bodyParts)) {
                    $percentages[$bodyPartKey] = round($data->avg('percentage'), 2);
                }
            }
    
            // Loop through all month analytics to calculate allotted and completed sets month-wise
            foreach ($allMonthAnalytics as $monthYear => $data) {
                // Initialize sets array for this month for each body part
                $sets[$monthYear] = array_fill_keys($bodyParts, ['total_sets' => 0, 'total_sets_completed' => 0]);
    
                // Loop through each body part for the current month
                foreach ($data->groupBy('targeted_body_part') as $bodyPart => $bodyData) {
                    $bodyPartKey = strtolower($bodyPart);
                    if (in_array($bodyPartKey, $bodyParts)) {
                        $sets[$monthYear][$bodyPartKey]['total_sets'] = $bodyData->sum('total_sets');
                        $sets[$monthYear][$bodyPartKey]['total_sets_completed'] = $bodyData->sum('total_sets_completed');
                    }
                }
            }
    
            return response()->json([
                'status' => 200,
                'percentages' => $percentages,
                'sets' => $sets,
                'message' => 'Workout analytics fetched successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserWorkoutAnalyticApi][fetchUserWorkoutAnalytic] Error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Error fetching workout analytics: ' . $e->getMessage(),
            ], 500);
        }
    }
    
}
