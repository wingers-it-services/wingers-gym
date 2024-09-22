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
            // Validate gym_id presence and existence
            $request->validate([
                'gym_id' => 'required|exists:gyms,id'
            ]);
    
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
    
            // Fetch workout analytics for the current month and year for percentage calculation
            $currentMonthAnalytics = WorkoutAnalytic::where('user_id', auth()->user()->id)
                ->where('gym_id', $request->gym_id)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->get()
                ->groupBy('targeted_body_part');
    
            // Fetch workout analytics for all months for allotted and completed sets calculation
            $allMonthAnalytics = WorkoutAnalytic::where('user_id', auth()->user()->id)
                ->where('gym_id', $request->gym_id)
                ->get()
                ->groupBy(function ($item) {
                    return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT); // Group by year-month
                });
    
            // Initialize percentages array for the current month
            $percentages = [];
    
            // Loop through current month analytics for percentage calculation and custom response structure
            foreach ($currentMonthAnalytics as $bodyPart => $data) {
                $percentages[] = [
                    'title' => ucfirst($bodyPart), // Use the actual dynamic targeted body part
                    'subtitle' => "Hello " . strtolower($bodyPart), // Custom subtitle message
                    'percentage' => round($data->avg('percentage'), 2), // Calculate and format percentage
                ];
            }
    
            // Initialize array for all month sets
            $sets = [];
    
            // Define a default color if not using a predefined map
            $defaultColor = '#FFD700';
    
            // Loop through all month analytics to calculate allotted and completed sets month-wise
            foreach ($allMonthAnalytics as $monthYear => $data) {
                // Split the monthYear into year and month parts for readability
                [$year, $month] = explode('-', $monthYear);
                $monthName = Carbon::createFromFormat('m', $month)->format('M'); // Convert month number to short month name (e.g., Jan, Feb)
    
                // Group by body parts to calculate sets for each body part in that month
                $bodyPartData = $data->groupBy('targeted_body_part');
                foreach ($bodyPartData as $bodyPart => $bodyData) {
                    // Calculate total allotted and completed sets for the body part
                    $totalAllotedSets = $bodyData->sum('total_sets');
                    $totalCompletedSets = $bodyData->sum('total_sets_completed');
    
                    // Add the set data for this body part in this month
                    $sets[] = [
                        'month' => $monthName, // Month short name like Jan, Feb, etc.
                        'body_part' => ucfirst($bodyPart), // Use the dynamic body part name
                        'alloted_set' => $totalAllotedSets,
                        'completed_set' => $totalCompletedSets,
                        'color' => $defaultColor // You can define colors dynamically if needed
                    ];
                }
            }
    
            return response()->json([
                'status' => 200,
                'percentages' => $percentages, // Custom formatted body part percentages
                'sets' => $sets,               // Custom sets data with dynamic body part names
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
