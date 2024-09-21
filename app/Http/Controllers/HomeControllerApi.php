<?php

namespace App\Http\Controllers;

use App\Enums\AttendenceStatusEnum;
use App\Enums\GymSubscriptionStatusEnum;
use App\Models\Advertisement;
use App\Models\Gym;
use App\Models\GymUserAttendence;
use App\Models\Holiday;
use App\Models\UserSubscriptionHistory;
use App\Models\WorkoutAnalytic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeControllerApi extends Controller
{
    protected $gym;
    protected $holiday;
    protected $advertisement;
    protected $workoutAnalytic;
    protected $gymUserAttendence;
    protected $userSubscriptionHistory;

    public function __construct(
        Gym $gym,
        Holiday $holiday,
        Advertisement $advertisement,
        WorkoutAnalytic $workoutAnalytic,
        GymUserAttendence $gymUserAttendence,
        UserSubscriptionHistory $userSubscriptionHistory
    ) {
        $this->gym = $gym;
        $this->holiday = $holiday;
        $this->advertisement = $advertisement;
        $this->workoutAnalytic = $workoutAnalytic;
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

            $subscription = $this->userSubscriptionHistory
                ->where('user_id', $user->id)
                ->where('status', GymSubscriptionStatusEnum::ACTIVE)
                ->where('gym_id', $request->gym_id)->first();

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

                $day = 'day' . $date->day;

                if ($attendance && $attendance->{$day} == AttendenceStatusEnum::PRESENT) {
                    $presentCount++;
                    $totalPresentDays++; // Increment actual present days
                }

                if ($attendance && $attendance->{$day} == AttendenceStatusEnum::ABSENT) {
                    $absentCount++;
                }
            }

            if ($todayDate->lessThan($startDate)) {
                // If the subscription hasn't started yet, pending days should be counted from the start date (inclusive)
                $pendingDays = $endDate->greaterThanOrEqualTo($startDate) ? (int)$startDate->diffInDays($endDate->addDay()) : 0;
            } else {
                // If the subscription has already started, count from the current date (inclusive)
                $pendingDays = $endDate->greaterThanOrEqualTo($todayDate) ? (int)$todayDate->diffInDays($endDate->addDay()) : 0;
            }
            $actualWorkingDays = $totalDays - $weekendCount - $holidayCount;
            $pendingWorkingDays = min($pendingDays, $actualWorkingDays);
            $pendingDaysPercentage = $totalDays > 0 ? ($pendingWorkingDays / $totalDays) * 100 : 0;
            $presentPercentage = $actualWorkingDays > 0 ? ($presentCount / $actualWorkingDays) * 100 : 0;

            return response()->json([
                'status'                  => 200,
                'total_days'              => $totalDays ?? 0,
                'present_days'            => $presentCount ?? 0, // Includes present, weekend, and holiday
                'weekends'                => $weekendCount ?? 0,
                'total_holidays'          => $holidayCount ?? 0,
                'absents'                 => $absentCount ?? 0,
                'pending_working_days'    => $pendingWorkingDays,
                'pending_days'            => $pendingDays ?? 0,
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
            Log::info('[HomeControllerApi][fetchAdvertisementAndAttendance] Start fetching data');

            // Fetch Advertisement
            $advertisementResponse = $this->fetchAdvertisement($request);
            $advertisementData = $advertisementResponse->getData();
            Log::info('[HomeControllerApi][fetchAdvertisementAndAttendance] Advertisement Data:', (array)$advertisementData);

            // Fetch Attendance
            $attendanceResponse = $this->getUserAttendancePercentage($request);
            $attendanceData = $attendanceResponse->getData();
            Log::info('[HomeControllerApi][fetchAdvertisementAndAttendance] Attendance Data:', (array)$attendanceData);

            // Fetch Analytics
            $analyticsResponse = $this->fetchAnalytics($request);
            $analyticsData = $analyticsResponse->getData();
            Log::info('[HomeControllerApi][fetchAdvertisementAndAttendance] Analytics Data:', (array)$analyticsData);

            // Prepare response structure
            $response = [
                'status'        => 200,
                'message'       => '',
                'advertisement' => null,
                'total_days'    => 0,
                'present_days'  => 0,
                'pending_days'  => 0,
                'biceps'        => 0,
                'leg'           => 0,
                'forearm'       => 0,
                'tricep'        => 0,
                'back'          => 0,
                'shoulder'      => 0,
                'chest'         => 0,
                'abs'           => 0,
            ];

            // Handle Advertisement Response
            if ($advertisementData->status === 200) {
                $response['advertisement'] = $advertisementData->advertisement;
            } else if ($advertisementData->status === 422) {
                $response['message'] .= 'Advertisement data could not be fetched. ';
            }

            // Handle Attendance Response
            if ($attendanceData->status === 200) {
                $response['total_days'] = $attendanceData->total_days;
                $response['present_days'] = $attendanceData->present_days;
                $response['pending_days'] = $attendanceData->pending_days;
            } else if ($attendanceData->status === 422) {
                $response['message'] .= 'Attendance data could not be fetched. ';
            }

            // Handle Analytics Response
            if ($analyticsData->status === 200) {
                $response['biceps'] = $analyticsData->analytics->biceps ?? 0;
                $response['leg'] = $analyticsData->analytics->leg ?? 0;
                $response['forearm'] = $analyticsData->analytics->forearm ?? 0;
                $response['tricep'] = $analyticsData->analytics->triceps ?? 0;
                $response['back'] = $analyticsData->analytics->back ?? 0;
                $response['shoulder'] = $analyticsData->analytics->shoulder ?? 0;
                $response['chest'] = $analyticsData->analytics->chest ?? 0;
                $response['abs'] = $analyticsData->analytics->abs ?? 0;
            } else if ($analyticsData->status === 422) {
                $response['message'] .= 'Analytics data could not be fetched. ';
            }

            // Set success message if all responses are successful
            if ($advertisementData->status === 200 && $attendanceData->status === 200 && $analyticsData->status === 200) {
                $response['message'] = 'Advertisements, user attendance, and analytics fetched successfully.';
            } else {
                if (!$response['message']) {
                    $response['message'] = 'Some data could not be fetched.';
                }
            }

            Log::info('[HomeControllerApi][fetchAdvertisementAndAttendance] Final Response:', $response);

            return response()->json($response, 200);
        } catch (\Exception $e) {
            Log::error('[HomeControllerApi][fetchAdvertisementAndAttendance] Error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Separate function to fetch analytics
    public function fetchAnalytics(Request $request)
    {
        try {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            // Fetch workout analytics for the current month and year, grouped by targeted body part
            $analytics = $this->workoutAnalytic
                ->where('user_id', auth()->user()->id)
                ->where('gym_id', $request->gym_id)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->get()
                ->groupBy('targeted_body_part');

            // If no analytics found for the current month
            if ($analytics->isEmpty()) {
                return response()->json([
                    'status' => 422,
                    'analytics' => null,
                    'message' => 'No analytics found for the current month.',
                ], 422);
            }

            // Prepare the response with specific body parts
            $response = [
                'shoulder' => 0,
                'abs'      => 0,
                'leg'      => 0,
                'chest'    => 0,
                'back'     => 0,
                'biceps'   => 0,
                'triceps'  => 0,
                'forearm'  => 0,
            ];

            // Calculate average percentage for each body part and map to response
            foreach ($analytics as $bodyPart => $data) {
                $averagePercentage = $data->avg('percentage');

                // Map the body part to the response (ensure the body part names match your database)
                switch (strtolower($bodyPart)) {
                    case 'shoulder':
                        $response['shoulder'] = round($averagePercentage, 2);
                        break;
                    case 'abs':
                        $response['abs'] = round($averagePercentage, 2);
                        break;
                    case 'leg':
                        $response['leg'] = round($averagePercentage, 2);
                        break;
                    case 'chest':
                        $response['chest'] = round($averagePercentage, 2);
                        break;
                    case 'back':
                        $response['back'] = round($averagePercentage, 2);
                        break;
                    case 'biceps':
                        $response['biceps'] = round($averagePercentage, 2);
                        break;
                    case 'triceps':
                        $response['triceps'] = round($averagePercentage, 2);
                        break;
                    case 'forearm':
                        $response['forearm'] = round($averagePercentage, 2);
                        break;
                }
            }

            return response()->json([
                'status'    => 200,
                'analytics' => $response,
                'message'   => 'Analytics fetched successfully for the current month.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('[HomeControllerApi][fetchAnalytics] Error fetching analytics details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching analytics details: ' . $e->getMessage(),
            ], 500);
        }
    }
}
