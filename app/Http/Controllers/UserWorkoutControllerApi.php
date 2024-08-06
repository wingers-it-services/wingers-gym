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
