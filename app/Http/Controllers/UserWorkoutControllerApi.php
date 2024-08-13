<?php

namespace App\Http\Controllers;

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
            $workouts = $this->userWorkout->where('user_id',$user->id)->get();

            if ($workouts->isEmpty()) {
                return response()->json([
                    'status'   => 422,
                    'workouts' => $workouts,
                    'message'  => 'There is no workouts'
                ], 200);
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
