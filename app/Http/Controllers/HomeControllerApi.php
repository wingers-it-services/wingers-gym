<?php

namespace App\Http\Controllers;

use App\Enums\AttendenceStatusEnum;
use App\Models\Advertisement;
use App\Models\Gym;
use App\Models\GymUserAttendence;
use App\Models\Holiday;
use App\Models\UserSubscriptionHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeControllerApi extends Controller
{
    protected $advertisement;
    protected $holiday;
    protected $userSubscriptionHistory;
    protected $gymUserAttendence;
    protected $gym;

    public function __construct(
        Gym $gym,
        Holiday $holiday,
        Advertisement $advertisement,
        GymUserAttendence $gymUserAttendence,
        UserSubscriptionHistory $userSubscriptionHistory
    ) {
        $this->gym = $gym;
        $this->holiday = $holiday;
        $this->advertisement = $advertisement;
        $this->gymUserAttendence = $gymUserAttendence;
        $this->userSubscriptionHistory = $userSubscriptionHistory;
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
            $gym = $this->gym->find($request->gym_id);

            $subscription = $this->userSubscriptionHistory->where('user_id', $user->id)
                ->where('status', 1)
                ->where('gym_id', $request->gym_id)->first();
            // dd($subscription);
            $startDate = Carbon::parse($subscription->subscription_start_date);
            $endDate = Carbon::parse($subscription->subscription_end_date);
            $todayDate = Carbon::now()->startOfDay();

            $holidays = $this->holiday->where('gym_id', $gym->id)
                ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->pluck('date');

            $holidays = $holidays->map(function ($holidayDate) {
                return Carbon::parse($holidayDate)->format('Y-m-d');
            });

            $totalDays = $startDate->diffInDays($endDate) + 1;
            $presentCount = 0;
            $totalPresentDays = 0;
            $holidayCount = 0;
            $weekendCount = 0;
            $absentCount = 0;

            for ($date = $startDate; $date->lte($todayDate); $date->addDay()) {
                $dayOfWeek = $date->format('l');
                $formattedDate = $date->format('Y-m-d');

                // Check for weekends
                if ($dayOfWeek == 'Sunday') {
                    $weekendCount++;
                    $presentCount++; // Count weekends as present
                    continue;
                }

                // Check for holidays
                if ($holidays->contains($formattedDate)) {
                    $holidayCount++;
                    $presentCount++; // Count holidays as present
                    continue;
                }

                // Check for attendance
                $attendance = $this->gymUserAttendence->where('gym_id', $gym->id)
                    ->where('gym_user_id', $user->id)
                    ->where('year', $date->year)
                    ->where('month', $date->month)
                    ->first();

                    if (!$attendance) {
                        return response()->json([
                            'status'  => 422,
                            'message' => 'No attendance records found for the user.'
                        ], 422);
                    }

                $day = 'day' . $date->day;

                if ($attendance && $attendance->{$day} == AttendenceStatusEnum::PRESENT) {
                    $presentCount++;
                    $totalPresentDays++; // Increment actual present days
                }

                if ($attendance && $attendance->{$day} == AttendenceStatusEnum::ABSENT) {
                    $absentCount++;
                }
            }
    

            $pendingDays = $endDate->greaterThan($todayDate) ? (int)$todayDate->diffInDays($endDate) : 0;
            $actualWorkingDays = $totalDays - $weekendCount - $holidayCount;
            $pendingWorkingDays = min($pendingDays, $actualWorkingDays);
            $pendingDaysPercentage = $totalDays > 0 ? ($pendingWorkingDays / $totalDays) * 100 : 0;
            $presentPercentage = $actualWorkingDays > 0 ? ($presentCount / $actualWorkingDays) * 100 : 0;

            return response()->json([
                'status'                  => 200,
                'total_days'              => $totalDays,
                'present_days'            => $presentCount, // Includes present, weekend, and holiday
                'weekends'                => $weekendCount,
                'total_holidays'          => $holidayCount,
                'absents'                 => $absentCount,
                'pending_working_days'    => $pendingWorkingDays,
                'pending_days'            => $pendingDays,
                'pending_days_percentage' => number_format($pendingDaysPercentage, 2),
                'subs'                    => $subscription,
                'startDate'               => $startDate,
                'enddate'                 => $endDate,
                'present_percentage'      => number_format($presentPercentage, 2),
                'message'                 => 'User attendance percentage and pending days fetched successfully'
            ], 200);
        } catch (\Exception $e) {
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
                'status'                   => 200,
                'advertisement'            => $advertisementData->advertisement,
                'total_days'               => $attendanceData->total_days,
                'present_days'             => $attendanceData->present_days,
                'weekends'                 => $attendanceData->weekends,
                'absents'                  => $attendanceData->absents,
                // 'holidays'                 => $attendanceData->holidays,
                // 'total_weekends_till_toaday'           => $attendanceData->total_weekends,
                'total_holidays_till_toaday'           => $attendanceData->total_holidays,
                // 'pending_working_days'     => $attendanceData->pending_working_days,
                'pending_days'             => $attendanceData->pending_days,
                // 'present_days'             => 50,
                'biceps' => 70,
                'leg' => 70,
                'forearm' => 10,
                'tricep' => 11,
                'back' => 42,
                'shoulder' => 50,
                'chest' => 10,
                'abs' => 22,
                // 'pending_days_percentage'  => $attendanceData->pending_days_percentage,
                // 'subs'                     => $attendanceData->subs,
                // 'startDate'                => $attendanceData->startDate,
                // 'enddate'                  => $attendanceData->enddate,
                // 'present_percentage'       => $attendanceData->present_percentage,
                'message'                  => 'Advertisements and user attendance fetched successfully.',
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
