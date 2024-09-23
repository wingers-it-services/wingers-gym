<?php

namespace App\Http\Controllers;

use App\Models\WorkoutAnalytic;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserWorkoutAnalyticApi extends Controller
{
    protected $workoutAnalytic;

    public function __construct(
        WorkoutAnalytic $workoutAnalytic,
    ) {
        $this->workoutAnalytic = $workoutAnalytic;
    }

    public function fetchUserWorkoutAnalytic(Request $request)
    {
        try {
            $request->validate([
                'gym_id' => 'required|exists:gyms,id'
            ]);
    
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
    
            // Fetch workout analytics for the current month and year for percentage calculation
            $currentMonthAnalytics = $this->workoutAnalytic->where('user_id', auth()->user()->id)
                ->where('gym_id', $request->gym_id)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->get()
                ->groupBy('targeted_body_part');
    
            // Return 422 if no data is found for the current month
            if ($currentMonthAnalytics->isEmpty()) {
                return response()->json([
                    'status'  => 422,
                    'message' => 'No workout analytics data found for the current month.',
                ], 422);
            }
    
            $percentages = [];
    
            // Loop through current month analytics for percentage calculation and custom response structure
            foreach ($currentMonthAnalytics as $bodyPart => $data) {
                $percentages[] = [
                    'title'      => ucfirst($bodyPart), // Use the actual dynamic targeted body part
                    'subtitle'   => "Hello " . strtolower($bodyPart), // Custom subtitle message
                    'percentage' => round($data->avg('percentage'), 2), // Calculate and format percentage
                ];
            }
    
            $yearAnalytics = $this->workoutAnalytic->where('user_id', auth()->user()->id)
                ->where('gym_id', $request->gym_id)
                ->where('year', $currentYear) // Filter by the current year
                ->get()
                ->groupBy('targeted_body_part'); // Group by targeted body part
    
            // Return 422 if no yearly data is found
            if ($yearAnalytics->isEmpty()) {
                return response()->json([
                    'status'  => 422,
                    'message' => 'No workout analytics data found for the current year.',
                ], 422);
            }
    
            $sets = [];
    
            $months = [
                '01' => 'Jan',
                '02' => 'Feb',
                '03' => 'March',
                '04' => 'April',
                '05' => 'May',
                '06' => 'June',
                '07' => 'July',
                '08' => 'August',
                '09' => 'Sept',
                '10' => 'Oct',
                '11' => 'Nov',
                '12' => 'Dec'
            ];
    
            // Loop through body part data and aggregate sets for each month
            foreach ($yearAnalytics as $bodyPart => $data) {
                // Initialize dynamic month-wise values for each body part
                $currentBodyPartData = [
                    'body_part' => ucfirst($bodyPart), // Capitalize body part name
                ];
    
                // Loop through the data for this body part and assign sets to months dynamically
                foreach ($months as $monthNum => $monthName) {
                    // Filter data for the current month
                    $monthData = $data->where('month', (int)$monthNum); // Ensure month matches
    
                    // Sum up the sets for the current month
                    $totalAllotedSets = $monthData->sum('total_sets');
                    $totalCompletedSets = $monthData->sum('total_sets_completed');
    
                    // Add this month's data to the body part array
                    $currentBodyPartData[$monthName . '_month'] = $monthName;
                    $currentBodyPartData[$monthName . '_alloted_set'] = $totalAllotedSets;
                    $currentBodyPartData[$monthName . '_completed_set'] = $totalCompletedSets;
                }
    
                // Add the body part data to the sets array
                $sets[] = $currentBodyPartData;
            }
    
            return response()->json([
                'status'      => 200,
                'percentages' => $percentages,
                'sets'        => $sets,
                'message'     => 'Workout analytics fetched successfully.',
            ], 200);
    
        } catch (\Exception $e) {
            Log::error('[UserWorkoutAnalyticApi][fetchUserWorkoutAnalytic] Error: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching workout analytics: ' . $e->getMessage(),
            ], 500);
        }
    }    
}
