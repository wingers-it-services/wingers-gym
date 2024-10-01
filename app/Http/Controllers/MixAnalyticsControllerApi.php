<?php

namespace App\Http\Controllers;

use App\Models\DietAnalytic;
use App\Models\WorkoutAnalytic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MixAnalyticsControllerApi extends Controller
{
    protected $dietAnalytic;
    protected $workoutAnalytic;

    public function __construct(
        DietAnalytic $dietAnalytic,
        WorkoutAnalytic $workoutAnalytic,
    ) {
        $this->dietAnalytic = $dietAnalytic;
        $this->workoutAnalytic = $workoutAnalytic;
    }

    public function fetchUserMixAnalytic(Request $request)
    {
        try {
            // Validate the request for gym_id
            $request->validate([
                'gym_id' => 'required|exists:gyms,id'
            ]);

            $userId = auth()->user()->id;
            $gymId = $request->gym_id;
            $currentYear = Carbon::now()->year;

            // Fetch diet analytics for the current year
            $currentYearDietAnalytics = $this->dietAnalytic->where('user_id', $userId)
                ->where('gym_id', $gymId)
                ->where('year', $currentYear)
                ->get();

            // Fetch workout analytics for the current year
            $yearAnalytics = $this->workoutAnalytic->where('user_id', $userId)
                ->where('gym_id', $gymId)
                ->where('year', $currentYear)
                ->get()
                ->groupBy('targeted_body_part');

            // Check if both data sets are empty or null and return 422 response
            if ($currentYearDietAnalytics->isEmpty() && $yearAnalytics->isEmpty()) {
                return response()->json([
                    'status'  => 422,
                    'message' => 'No analytics data available for the current year.'
                ], 422);
            }

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

            // Process workout analytics
            $sets = [];
            $workoutPercentages = [];

            if ($yearAnalytics->isNotEmpty()) {
                foreach ($yearAnalytics as $bodyPart => $data) {
                    $totalAllottedSets = 0;
                    $totalCompletedSets = 0;

                    $currentBodyPartData = [
                        'title' => ucfirst($bodyPart) . ' chart',
                        'body_part' => ucfirst($bodyPart),
                    ];

                    foreach ($months as $monthNum => $monthName) {
                        $monthData = $data->where('month', (int)$monthNum);
                        $allottedSets = $monthData->sum('total_sets');
                        $completedSets = $monthData->sum('total_sets_completed');

                        $currentBodyPartData[$monthName . '_month'] = $monthName;
                        $currentBodyPartData[$monthName . '_alloted_set'] = $allottedSets;
                        $currentBodyPartData[$monthName . '_completed_set'] = $completedSets;

                        $totalAllottedSets += $allottedSets;
                        $totalCompletedSets += $completedSets;
                    }

                    $sets[] = $currentBodyPartData;

                    // Calculate the percentage for each body part
                    $percentage = $totalAllottedSets > 0
                        ? round(($totalCompletedSets / $totalAllottedSets) * 100, 2)
                        : 0;

                    $workoutPercentages[] = [
                        'title'      => ucfirst($bodyPart),
                        'subtitle'   => "Workout " . strtolower($bodyPart),
                        'percentage' => $percentage,
                    ];
                }
            }

            // Process diet analytics
            $dietPercentages = [
                [
                    'title'      => 'carbs',
                    'subtitle'   => 'carbs',
                    'percentage' => round($currentYearDietAnalytics->avg('carb_percentage'), 2) ?? 0
                ],
                [
                    'title'      => 'fats',
                    'subtitle'   => 'fats',
                    'percentage' => round($currentYearDietAnalytics->avg('fat_percentage'), 2) ?? 0
                ],
                [
                    'title'      => 'protein',
                    'subtitle'   => 'protein',
                    'percentage' => round($currentYearDietAnalytics->avg('protein_percentage'), 2) ?? 0
                ],
                [
                    'title'      => 'calories',
                    'subtitle'   => 'calories',
                    'percentage' => round($currentYearDietAnalytics->avg('calories_percentage'), 2) ?? 0
                ]
            ];

            // Prepare diet analytics data for all months
            $dietAllMonthData = [];
            $dietMonths = [];
            foreach ($currentYearDietAnalytics as $data) {
                $monthName = Carbon::createFromFormat('m', $data->month)->format('M'); // Convert month number to short month name

                // Initialize month data if not already done
                if (!isset($months[$data->month])) {
                    $dietMonths[$data->month] = [
                        'total_fats'        => 0,
                        'consumed_fats'     => 0,
                        'total_carbs'       => 0,
                        'consumed_carbs'    => 0,
                        'total_protein'     => 0,
                        'consumed_protein'  => 0,
                        'total_calories'    => 0,
                        'consumed_calories' => 0,
                        'color'             => '#FFD700',
                    ];
                }

                // Sum up the totals and consumed values for each month
                $dietMonths[$data->month]['total_fats'] += $data->total_fats;
                $dietMonths[$data->month]['consumed_fats'] += $data->total_fats_consumed;
                $dietMonths[$data->month]['total_carbs'] += $data->total_carbs;
                $dietMonths[$data->month]['consumed_carbs'] += $data->total_carbs_consumed;
                $dietMonths[$data->month]['total_protein'] += $data->total_protein;
                $dietMonths[$data->month]['consumed_protein'] += $data->total_protein_consumed;
                $dietMonths[$data->month]['total_calories'] += $data->total_calories;
                $dietMonths[$data->month]['consumed_calories'] += $data->total_calories_consumed;
            }

            // Format month data for response
            foreach ($dietMonths as $month => $data) {
                $monthName = Carbon::createFromFormat('m', $month)->format('M'); // Convert month number to short month name
                $dietAllMonthData[] = [
                    'title'             => $monthName.' Diet',
                    'month'             => $monthName,
                    'total_fats'        => $data['total_fats'],
                    'consumed_fats'     => $data['consumed_fats'],
                    'total_carbs'       => $data['total_carbs'],
                    'consumed_carbs'    => $data['consumed_carbs'],
                    'total_protein'     => $data['total_protein'],
                    'consumed_protein'  => $data['consumed_protein'],
                    'total_calories'    => $data['total_calories'],
                    'consumed_calories' => $data['consumed_calories'],
                    'color'             => $data['color']
                ];
            }

            return response()->json([
                'status' => 200,
                'title'=>'Yearly Analytic',
                'message' => 'Analytics fetched successfully for the year.',
                'percentages' => array_merge($dietPercentages, $workoutPercentages),
                'workout_sets' => $sets,
                'dietAllMonthData' => $dietAllMonthData
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching user mix analytics: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Internal server error.'
            ], 500);
        }
    }
}
