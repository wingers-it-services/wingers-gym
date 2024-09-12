<?php

namespace App\Http\Controllers;

use App\Enums\AttendenceStatusEnum;
use App\Models\Gym;
use App\Models\GymUserAttendence;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class GymUserAttendenceControllerApi extends Controller
{
    protected $gymUserAttendence;
    protected $gym;
    protected $holiday;

    public function __construct(
        GymUserAttendence $gymUserAttendence,
        Holiday $holiday,
        Gym $gym
    ) {
        $this->gymUserAttendence = $gymUserAttendence;
        $this->holiday = $holiday;
        $this->gym = $gym;
    }

    // public function markAttendance(Request $request)
    // {
    //     dd($request->all());
    //     $request->validate([
    //         'gym_user_id' => 'required|exists:gym_users,id',
    //         'gym_id'      => 'required|exists:gyms,id',
    //         'status'      => 'required'
    //     ]);

    //     $gymUserId = $request->input('gym_user_id');
    //     $gymId = $request->input('gym_id');
    //     $currentDay = Carbon::now()->day;
    //     $currentMonth = Carbon::now()->month;
    //     $currentYear = Carbon::now()->year;

    //     $attendance = GymUserAttendence::firstOrNew([
    //         'gym_user_id' => $gymUserId,
    //         'gym_id'      => $gymId,
    //         'month'       => $currentMonth,
    //         'year'        => $currentYear,
    //     ]);

    //     $dayField = 'day' . $currentDay;
    //     $attendance->$dayField = $request->status; // Mark as present

    //     $attendance->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Attendance marked successfully',
    //         'attendance' => $attendance,
    //     ]);
    // }

    public function fetchUserAttendence(Request $request)
    {
        $request->validate([
            'gym_id'      => 'required|exists:gyms,id',
        ]);

        $user = auth()->user();

        $this->gymUserAttendence
            ->where('gym_id', $request->gym_id)
            ->where('user_id', $user->id)
            ->get();
    }

    public function getUserAttendance(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'gym_id' => 'required|exists:gyms,id',
                'month'  => 'required|integer|min:1|max:12',
                'year'   => 'required|integer|min:1900|max:' . date('Y')
            ]);
    
            // Get the authenticated user
            $user = auth()->user();
    
            // Fetch the attendance record for the given gym, user, month, and year
            $attendance = $this->gymUserAttendence
                ->where('gym_id', $request->gym_id)
                ->where('gym_user_id', $user->id)
                ->where('month', $request->month)
                ->where('year', $request->year)
                ->first();
    
            // Get the number of days in the provided month and year
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);
    
            // Fetch holidays for the specified gym within the given month and year
            $holidays = $this->holiday->where('gym_id', $request->gym_id)
                ->whereMonth('date', $request->month)
                ->whereYear('date', $request->year)
                ->pluck('date'); // Get dates of holidays
    
            // Convert holiday dates to an array of day numbers
            $holidayDays = $holidays->map(function ($holidayDate) {
                return \Carbon\Carbon::parse($holidayDate)->day;
            })->toArray();
    
            // Initialize counters for present, absent, holiday, and weekends (Sundays)
            $presentCount = 0;
            $absentCount = 0;
            $holidayCount = 0;
            $weekendCount = 0;
    
            // Prepare an array to store attendance data for each day of the month
            $attendanceData = [];
    
            // Loop through all days of the month
            for ($day = 1; $day <= $daysInMonth; $day++) {
                // Get the attendance status for the current day, defaulting to ABSENT if no record
                $status = $attendance ? (int)$attendance->{'day' . $day} : 0;
    
                // Get the day of the week (e.g., Sunday, Monday)
                $date = \DateTime::createFromFormat('Y-m-d', "{$request->year}-{$request->month}-{$day}");
                $dayName = $date->format('l'); // 'l' returns the full day name (e.g., Sunday, Monday)
    
                // Check if it's a holiday
                $isHoliday = in_array($day, $holidayDays);
    
                // Set the status to HOLIDAY if it's a holiday
                if ($isHoliday) {
                    $status = AttendenceStatusEnum::HOLIDAY;
                } elseif ($dayName == 'Sunday') {
                    $weekendCount++;
                    $status = AttendenceStatusEnum::WEEKEND; // Override status to WEEKEND for Sundays
                }
    
                // Count the status
                if ($status == AttendenceStatusEnum::PRESENT) {
                    $presentCount++;
                } elseif ($status == AttendenceStatusEnum::ABSENT) {
                    $absentCount++;
                } elseif ($status == AttendenceStatusEnum::HOLIDAY) {
                    $holidayCount++;
                }
    
                // Add the day, status, and color to the attendanceData array
                $attendanceData[] = [
                    'day'    => $day,
                    'status' => $status,
                    'color'  => AttendenceStatusEnum::getColor($status),
                ];
            }
    
            // Calculate the percentages
            $totalDays = $daysInMonth;
            $presentPercentage = ($presentCount / $totalDays) * 100;
            $absentPercentage = ($absentCount / $totalDays) * 100;
            $holidayPercentage = ($holidayCount / $totalDays) * 100;
            $weekendPercentage = ($weekendCount / $totalDays) * 100;
    
            // Assign color codes based on the status
            $presentColor = AttendenceStatusEnum::getColor(AttendenceStatusEnum::PRESENT);
            $absentColor = AttendenceStatusEnum::getColor(AttendenceStatusEnum::ABSENT);
            $holidayColor = AttendenceStatusEnum::getColor(AttendenceStatusEnum::HOLIDAY);
            $weekendColor = AttendenceStatusEnum::getColor(AttendenceStatusEnum::WEEKEND);
    
            // Return the attendance data and summary in the response
            return response()->json([
                'status'       => 200,
                'attendance'   => $attendanceData,
                'present_percentage' => [
                    'percentage' => number_format($presentPercentage, 2),
                    'color'      => $presentColor
                ],
                'absent_percentage' => [
                    'percentage' => number_format($absentPercentage, 2),
                    'color'      => $absentColor
                ],
                'holiday_percentage' => [
                    'percentage' => number_format($holidayPercentage, 2),
                    'color'      => $holidayColor
                ],
                'weekend_percentage' => [
                    'percentage' => number_format($weekendPercentage, 2),
                    'color'      => $weekendColor // Custom color for Sundays (Weekends)
                ],
                'message' => 'Attendance fetched successfully'
            ], 200);
        } catch (Throwable $e) {
            // Handle exceptions and return a 500 error response
            Log::error('[GymUserAttendenceControllerApi][getUserAttendance]' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching attendance: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function markAttendance(Request $request)
    {
        try {
            $request->validate([
                'gym_uuid'      => 'required|exists:gyms,uuid'
            ]);

            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'User not authenticated',
                ], 401);
            }

            $gymId = $this->gym->where('uuid', $request->gym_uuid)->pluck('id')->first();

            $today = Carbon::now();
            $currentDay = $today->day;
            $currentMonth = $today->month;
            $currentYear = $today->year;

            $attendance = $this->gymUserAttendence->firstOrNew([
                'gym_user_id' => $user->id,
                'gym_id'      => $gymId,
                'month'       => $currentMonth,
                'year'        => $currentYear,
            ]);

            $dayField = 'day' . $currentDay;

            if ($attendance->$dayField != 0) {
                return response()->json([
                    'status'  => 409,
                    'message' => 'Attendance already marked for today',
                ], 409);  
            }

            $attendance->$dayField = AttendenceStatusEnum::PRESENT;

            $attendance->save();

            // Return success response
            return response()->json([
                'status'  => 200,
                'attendence' => $attendance,
                'message' => 'Attendance marked successfully',
            ], 200);
        } catch (Throwable $e) {
            Log::error('[GymUserAttendenceControllerApi][markAttendance]'.$e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error in Attendance mark' . $e->getMessage(),
            ], 500);
        }
    }
}
