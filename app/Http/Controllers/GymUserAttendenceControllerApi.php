<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\GymUserAttendence;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GymUserAttendenceControllerApi extends Controller
{
    protected $gymUserAttendencer;
    protected $gym;

    public function __construct(
        GymUserAttendence $gymUserAttendencer,
        Gym $gym
    ) {
        $this->gymUserAttendencer = $gymUserAttendencer;
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

        $this->gymUserAttendencer
            ->where('gym_id', $request->gym_id)
            ->where('user_id', $user->id)
            ->get();
    }

    public function markAttendance(Request $request)
    {
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

        

        $attendance = $this->gymUserAttendencer->firstOrNew([
            'gym_user_id' => $user->id,
            'gym_id'      => $gymId,
            'month'       => $currentMonth,
            'year'        => $currentYear,
        ]);


        $dayField = 'day' . $currentDay;
        $attendance->$dayField = $request->status;
    }
}
