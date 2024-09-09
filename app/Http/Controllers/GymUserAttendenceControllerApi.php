<?php

namespace App\Http\Controllers;

use App\Enums\AttendenceStatusEnum;
use App\Models\Gym;
use App\Models\GymUserAttendence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

class GymUserAttendenceControllerApi extends Controller
{
    protected $gymUserAttendence;
    protected $gym;

    public function __construct(
        GymUserAttendence $gymUserAttendence,
        Gym $gym
    ) {
        $this->gymUserAttendence = $gymUserAttendence;
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
            $request->validate([
                'gym_id'  => 'required|exists:gyms,id',
                'month'   => 'required',
                'year'    => 'required'
            ]);
           
            $user = auth()->user();

            $attendance = $this->gymUserAttendence
                ->where('gym_id', $request->gym_id)
                ->where('gym_user_id', $user->id)
                ->where('month', $request->month)
                ->where('year', $request->year)
                ->first();

            if (!$attendance) {
                return response()->json([
                    'status'  => 404,
                    'message' => 'No attendance found for the given user and period.'
                ], 404);
            }

            // Get the number of days in the provided month and year
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);

            // Loop through the valid days for the month and get the status and corresponding color
            $attendanceData = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $status = $attendance->{'day' . $day};
                if ($status) {
                    $attendanceData[] = [
                        'day'    => $day,
                        'status' => $status,
                        'color'  => AttendenceStatusEnum::getColor($status),
                    ];
                }
            }

            return response()->json([
                'status'     => 200,
                'attendence' => $attendanceData,
                'message'    => 'Attendence fetched successfully'
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'status'     => 500,
                'message'    => 'Error fetching Attendence' . $e->getMessage()
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
            $attendance->$dayField = AttendenceStatusEnum::PRESENT;

            $attendance->save();

            // Return success response
            return response()->json([
                'status'  => 200,
                'attendence' => $attendance,
                'message' => 'Attendance marked successfully',
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Error in Attendance mark' . $e->getMessage(),
            ], 500);
        }
    }
}
