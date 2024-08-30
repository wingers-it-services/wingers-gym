<?php

namespace App\Http\Controllers;

use App\Models\CurrentDayWorkout;
use App\Models\UserWorkout;
use App\Traits\errorResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserWorkoutControllerApi extends Controller
{
    use errorResponseTrait;
    protected $userWorkout;

    public function __construct(
        UserWorkout $userWorkout,
    ) {
        $this->userWorkout = $userWorkout;
    }

  /**
   * The function fetches a user's workouts and returns a JSON response with the workout details or an
   * error message if there is an issue.
   * 
   * @return The `fetchUserWorkout` function returns a JSON response with status, workouts data, and a
   * message.
   */
    public function fetchUserWorkout()
    {
        try {
            $user = auth()->user(); 
             $currentDay = strtolower(now()->format('l')); // Get the current day of the week in lowercase (e.g., 'monday')
dd($currentDay);
            $workouts = $this->userWorkout->where('user_id', $user->id)
                                          ->where('day', $currentDay)
                                          ->with('workoutDetails')
                                          ->get();

            if ($workouts->isEmpty()) {
                return response()->json([
                    'status'   => 422,
                    'workouts' => $workouts,
                    'message'  => 'There is no workouts'
                ], 422);
            }

            return response()->json([
                'status'    => 200,
                'workouts'  => $workouts,
                'message'   => 'User workouts Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserWorkoutControllerApi][fetchUserWorkout]Error fetching workouts details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching workouts details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function fetchCurrentDayWorkout()
    {
        try {
            $user = auth()->user();
            $workouts = CurrentDayWorkout::get();
            foreach ($workouts as $workout) {
                $workout->details = json_decode($workout->details, true);
            }
            
            if ($workouts->isEmpty()) {
                return response()->json([
                    'status'   => 422,
                    'workouts' => $workouts,
                    'message'  => 'There is no workouts'
                ], 422);
            }

            return response()->json([
                'status'    => 200,
                'workouts'  => $workouts,
                'message'   => 'User workouts Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserWorkoutControllerApi][fetchUserWorkout]Error fetching workouts details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching workouts details: ' . $e->getMessage()
            ], 500);
        }
    }
}
