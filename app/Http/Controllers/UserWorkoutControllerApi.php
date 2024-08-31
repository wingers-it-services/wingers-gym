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
    protected $currentDayWorkout;

    public function __construct(
        UserWorkout $userWorkout,
        CurrentDayWorkout $currentDayWorkout
    ) {
        $this->userWorkout = $userWorkout;
        $this->currentDayWorkout = $currentDayWorkout;
    }

    /**
     * The function fetches a user's workouts and returns a JSON response with the workout details or an
     * error message if there is an issue.
     * 
     * @return The `fetchUserWorkout` function returns a JSON response with status, workouts data, and a
     * message.
     */
    public function fetchUserWorkout(Request $request)
    {
        try {
            $request->validate([
                'gym_id'   => 'required',
                'gym_id.*' => 'exists:gyms,id'
            ]);

            $user = auth()->user();
            $currentDay = strtolower(now()->format('l'));

            $workouts = $this->userWorkout->where('user_id', $user->id)
                ->where('day', $currentDay)
                ->where('gym_id', $request->gym_id)
                ->with('workoutDetails:id,id,category,image')
                ->get();

            foreach ($workouts as $workout) {
                if ($workout->workoutDetails) {
                    $workout->category = $workout->workoutDetails->category;
                    $workout->image = $workout->workoutDetails->image;
                }

                unset($workout->workoutDetails);
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

    public function fetchCurrentDayWorkout(Request $request)
    {
        try {
            $request->validate([
                'user_workout_id'   => 'required',
                'user_workout_id.*' => 'exists:user_workouts,id'
            ]);
            $user = auth()->user();
            $workout = $this->currentDayWorkout
                ->where('user_workout_id', $request->user_workout_id)
                ->with('workoutDetails')->first();

            // foreach ($workouts as $workout) {
            $workout->details = json_decode($workout->details, true);
            // }

            // if ($workouts->isEmpty()) {
            //     return response()->json([
            //         'status'   => 422,
            //         'workouts' => $workouts,
            //         'message'  => 'There is no workouts'
            //     ], 422);
            // }

            return response()->json([
                'status'    => 200,
                'workouts'  => $workout,
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

    public function updateCurrentWorkout(Request $request)
    {
        try {
            $request->validate([
                'current_day_workout_id' => 'required|exists:current_day_workouts,id',
                'set'                    => 'required', 
                'status'                 => 'required|string', 
                'time'                   => 'required|string',  
            ]);

            $updateCurrentDayDetails = [
                'current_day_workout_id' => $request->current_day_workout_id,
                'set'                    => $request->set,
                'status'                 => $request->status,
                'time'                   => $request->time,
            ];

            // Call the updateCurrentWorkout method in the model
            $result = $this->currentDayWorkout->updateCurrentWorkout($updateCurrentDayDetails);
            $updatedWorkout = $this->currentDayWorkout->find($request->current_day_workout_id);

            // Handle the response based on the result
            if ($result) {
                return response()->json([
                    'status'  => 200,
                    'workout' => $updatedWorkout,
                    'message' => 'Workout details updated successfully'
                ]);
            } else {
                return response()->json([
                    'status'  => 500,
                    'workout' => $updatedWorkout,
                    'message' => 'Failed to update workout details'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('[UserWorkoutController][updateCurrentWorkout] Error updating workout details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'An error occurred while updating workout details. Please try again later.' . $e->getMessage()
            ], 500);
        }
    }
}
