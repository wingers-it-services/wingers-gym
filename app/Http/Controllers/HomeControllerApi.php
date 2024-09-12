<?php

namespace App\Http\Controllers;

use App\Enums\AttendenceStatusEnum;
use App\Models\Advertisement;
use App\Models\Gym;
use App\Models\GymUserAttendence;
use App\Models\Holiday;
use App\Models\User;
use App\Models\UserSubscriptionHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeControllerApi extends Controller
{
    protected $advertisement;

    public function __construct(
        Advertisement $advertisement
    ) {
        $this->advertisement = $advertisement;
    }

    public function fetchAdvertisement(Request $request)
    {
        try {

            $advertisement = $this->advertisement->get();

            if (!$advertisement) {
                return response()->json([
                    'status'        => 422,
                    'advertisement' => null,
                    'message'       => 'No advertisement found.',
                ], 422);
            }

            return response()->json([
                'status'        => 200,
                'advertisement' => $advertisement,
                'message'       => 'advertisement fetched successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('[AdvertisementControllerApi][fetchAdvertisement] Error fetching advertisement details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching advertisement details: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getUserAttendancePercentage(Request $request)
    {
        try {
            $request->validate([
                'gym_id' => 'required|exists:gyms,id',
            ]);

            $user = auth()->user();
            $gym = Gym::find($request->gym_id);

            $subscription = UserSubscriptionHistory::where('user_id', $user->id)
                ->where('status', 1)
                ->where('gym_id', $request->gym_id)->first();

            $startDate = Carbon::parse($subscription->subscription_start_date);
            $endDate = Carbon::parse($subscription->subscription_end_date);
            $todayDate = Carbon::now()->startOfDay(); 

            $holidays = Holiday::where('gym_id', $gym->id)
                ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->pluck('date'); 

            $holidays = $holidays->map(function ($holidayDate) {
                return Carbon::parse($holidayDate)->format('Y-m-d');
            });

            $totalDays = $startDate->diffInDays($endDate) + 1; 
            $presentCount = 0;
            $holidayCount = 0;
            $weekendCount = 0;

            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $dayOfWeek = $date->format('l'); 

                if ($dayOfWeek == 'Sunday') {
                    $weekendCount++;
                    continue; 
                }
                if ($holidays->contains($date->format('Y-m-d'))) {
                    $holidayCount++;
                    continue; 
                }

                $attendance = GymUserAttendence::where('gym_id', $gym->id)
                    ->where('gym_user_id', $user->id)
                    ->where('year', $date->year)
                    ->where('month', $date->month)
                    ->first();

                $day = 'day' . $date->day;
                if ($attendance && $attendance->{$day} == AttendenceStatusEnum::PRESENT) {
                    $presentCount++;
                }
            }

            $pendingDays = $endDate->greaterThan($todayDate) ? (int)$todayDate->diffInDays($endDate) : 0;

            $actualWorkingDays = $totalDays - $weekendCount - $holidayCount;

            $pendingWorkingDays = min($pendingDays, $actualWorkingDays - $presentCount);

            $pendingDaysPercentage = $totalDays > 0 ? ($pendingWorkingDays / $totalDays) * 100 : 0;

            $presentPercentage = $actualWorkingDays > 0 ? ($presentCount / $actualWorkingDays) * 100 : 0;

            return response()->json([
                'status'                 => 200,
                'total_days'             => $totalDays,
                'present_days'           => $presentCount,
                'weekends'               => $weekendCount,
                'holidays'               => $holidayCount,
                'pending_days'           => $pendingWorkingDays, // Pending working days after today
                'pending_days_percentage' => number_format($pendingDaysPercentage, 2), // Pending days percentage
                'subs'                   => $subscription,
                'startDate'              => $startDate,
                'enddate'                => $endDate,
                'present_percentage'     => number_format($presentPercentage, 2),
                'message'                => 'User attendance percentage and pending days fetched successfully'
            ], 200);
        } catch (\Exception $e) {
            // Handle exception and log errors
            Log::error('[GymUserAttendanceController][getUserAttendancePercentage] ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching user attendance percentage: ' . $e->getMessage()
            ], 500);
        }
    }

    public function fetchAdvertisementAndAttendance(Request $request)
    {
        try {
            $advertisementResponse = $this->fetchAdvertisement($request);
            $advertisementData = $advertisementResponse->getData();

            if ($advertisementData->status !== 200) {
                return $advertisementResponse; 
            }

            $attendanceResponse = $this->getUserAttendancePercentage($request);
            $attendanceData = $attendanceResponse->getData();

            if ($attendanceData->status !== 200) {
                return $attendanceResponse; 
            }

            return response()->json([
                'status'                 => 200,
                'advertisement'          => $advertisementData->advertisement,
                'total_days'             => $attendanceData->total_days,
                'present_days'           => $attendanceData->present_days,
                'weekends'               => $attendanceData->weekends,
                'holidays'               => $attendanceData->holidays,
                'pending_days'           => $attendanceData->pending_days,
                'pending_days_percentage' => $attendanceData->pending_days_percentage,
                'subs'                   => $attendanceData->subs,
                'startDate'              => $attendanceData->startDate,
                'enddate'                => $attendanceData->enddate,
                'present_percentage'     => $attendanceData->present_percentage,
                'message'                => 'Advertisements and user attendance fetched successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('[HomeControllerApi][fetchAdvertisementAndAttendance] Error: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
