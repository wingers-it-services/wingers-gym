<?php

namespace App\Http\Controllers;

use App\Models\DietAnalytic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DietAnalyticControllerApi extends Controller
{

    protected $dietAnalytic;

    public function __construct(
        DietAnalytic $dietAnalytic
    ) {
        $this->dietAnalytic = $dietAnalytic;
    }

    public function fetchUserDietAnalytic(Request $request)
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

            // Check if the data is empty or null and return 422 response
            if ($currentYearDietAnalytics->isEmpty()) {
                return response()->json([
                    'status'  => 422,
                    'message' => 'No diet analytics data available for the current year.'
                ], 422);
            }

            // Prepare default percentage array
            $percentages = [
                [
                    'title'      => 'carbs',
                    'subtitle'   => 'carbs',
                    'percentage' => 0
                ],
                [
                    'title'      => 'fats',
                    'subtitle'   => 'fats defats',
                    'percentage' => 0
                ],
                [
                    'title'      => 'protein',
                    'subtitle'   => 'protein',
                    'percentage' => 0
                ],
                [
                    'title'      => 'calories',
                    'subtitle'   => 'calories',
                    'percentage' => 0
                ]
            ];

            // Prepare dynamic array for all months data (total and consumed values)
            $allMonthData = [];
            $months = [];

            foreach ($currentYearDietAnalytics as $data) {
                $monthName = Carbon::createFromFormat('m', $data->month)->format('M'); // Convert month number to short month name

                // Initialize month data if not already done
                if (!isset($months[$data->month])) {
                    $months[$data->month] = [        
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
                $months[$data->month]['total_fats'] += $data->total_fats;
                $months[$data->month]['consumed_fats'] += $data->total_fats_consumed;
                $months[$data->month]['total_carbs'] += $data->total_carbs;
                $months[$data->month]['consumed_carbs'] += $data->total_carbs_consumed;
                $months[$data->month]['total_protein'] += $data->total_protein;
                $months[$data->month]['consumed_protein'] += $data->total_protein_consumed;
                $months[$data->month]['total_calories'] += $data->total_calories;
                $months[$data->month]['consumed_calories'] += $data->total_calories_consumed;
            }

            // Format month data for response
            foreach ($months as $month => $data) {
                $monthName = Carbon::createFromFormat('m', $month)->format('M'); // Convert month number to short month name
                $allMonthData[] = [
                    'title'             => 'sdsdfds',
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

            // Calculate average percentages
            if ($currentYearDietAnalytics->isNotEmpty()) {
                $percentages = [
                    [
                        'title'      => 'carbs',
                        'subtitle'   => 'carbs',
                        'percentage' => round($currentYearDietAnalytics->avg('carb_percentage'), 2)
                    ],
                    [
                        'title'      => 'fats',
                        'subtitle'   => 'fats defats',
                        'percentage' => round($currentYearDietAnalytics->avg('fat_percentage'), 2)
                    ],
                    [
                        'title'      => 'protein',
                        'subtitle'   => 'protein',
                        'percentage' => round($currentYearDietAnalytics->avg('protein_percentage'), 2)
                    ],
                    [
                        'title'      => 'calories',
                        'subtitle'   => 'calories',
                        'percentage' => round($currentYearDietAnalytics->avg('calories_percentage'), 2)
                    ]
                ];
            }

            return response()->json([
                'status'       => 200,
                'title'        => 'fgghhj',
                'percentages'  => $percentages,
                'allMonthData' => $allMonthData,
                'message'      => 'Diet analytics fetched successfully for the year.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('[DietAnalyticControllerApi][fetchUserDietAnalytic] Error: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching diet analytics: ' . $e->getMessage(),
            ], 500);
        }
    }
}
