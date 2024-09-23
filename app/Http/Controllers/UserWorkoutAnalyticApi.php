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
    
            $currentYear = Carbon::now()->year;
    
            // Fetch workout analytics for the entire year for percentage calculation
            $yearAnalytics = $this->workoutAnalytic->where('user_id', auth()->user()->id)
                ->where('gym_id', $request->gym_id)
                ->where('year', $currentYear)
                ->get()
                ->groupBy('targeted_body_part'); // Group by targeted body part
    
            if ($yearAnalytics->isEmpty()) {
                return response()->json([
                    'status'  => 422,
                    'message' => 'No workout analytics data found for the current year.',
                ], 422);
            }
    
            $percentages = [];
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
    
            // Loop through each body part and calculate totals and percentages
            foreach ($yearAnalytics as $bodyPart => $data) {
                // Initialize totals for allotted and completed sets for the year
                $totalAllottedSets = 0;
                $totalCompletedSets = 0;
    
                $currentBodyPartData = [
                    'body_part' => ucfirst($bodyPart),
                ];
    
                foreach ($months as $monthNum => $monthName) {
                    // Filter data for the current month
                    $monthData = $data->where('month', (int)$monthNum);
    
                    // Sum up the sets for the current month
                    $allottedSets = $monthData->sum('total_sets');
                    $completedSets = $monthData->sum('total_sets_completed');
    
                    // Add this month's data to the body part array
                    $currentBodyPartData[$monthName . '_month'] = $monthName;
                    $currentBodyPartData[$monthName . '_alloted_set'] = $allottedSets;
                    $currentBodyPartData[$monthName . '_completed_set'] = $completedSets;
    
                    // Accumulate yearly totals
                    $totalAllottedSets += $allottedSets;
                    $totalCompletedSets += $completedSets;
                }
    
                // Add the body part data to the sets array
                $sets[] = $currentBodyPartData;
    
                // Calculate the percentage
                $percentage = $totalAllottedSets > 0
                    ? round(($totalCompletedSets / $totalAllottedSets) * 100, 2)
                    : 0;
    
                // Add to percentages array
                $percentages[] = [
                    'title'      => ucfirst($bodyPart),
                    'subtitle'   => "Hello " . strtolower($bodyPart),
                    'percentage' => $percentage,
                ];
            }
    
            return response()->json([
                'status'      => 200,
                'percentages' => $percentages,
                'sets'        => $sets,
                'message'     => 'Workout analytics fetched successfully.',
            ], 200);
    
        } catch (Exception $e) {
            Log::error('[UserWorkoutAnalyticApi][fetchUserWorkoutAnalytic] Error: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching workout analytics: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    
   
}
