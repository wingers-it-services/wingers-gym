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

            // Fetch workouts for the current day, gym, and user
            $workouts = $this->currentDayWorkout
                ->whereHas('userWorkout', function ($query) use ($user, $currentDay, $request) {
                    $query->where('user_id', $user->id)
                        ->where('day', $currentDay)
                        ->where('gym_id', $request->gym_id);
                })
                ->with(['userWorkout.workoutDetails:id,id,category,image'])
                ->get();

            // Initialize the flag to true and then check
            $allCompleted = 1;

            foreach ($workouts as $workout) {
                if ($workout->workoutDetails) {
                    $workout->exercise_name = $workout->workoutDetails->name;
                    $workout->category = $workout->workoutDetails->category;
                    $workout->image = $workout->workoutDetails->image;
                }

                unset($workout->workoutDetails);

                // Check if the current workout is completed
                if (!$workout->is_completed) {
                    $allCompleted = 0; // If any workout is not completed, set to false
                }
            }

            if ($workouts->isEmpty()) {
                return response()->json([
                    'status'   => 422,
                    'workouts' => $workouts,
                    'message'  => 'There are no workouts'
                ], 422);
            }

            return response()->json([
                'status'         => 200,
                'workouts'       => $workouts,
                'all_completed'  => $allCompleted ? 1 : 0, // Return 1 if all workouts are completed, 0 otherwise
                'message'        => 'User workouts fetched successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserWorkoutControllerApi][fetchUserWorkout] Error fetching workout details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching workout details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function fetchCurrentDayWorkout(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'user_workout_id'   => 'required|exists:user_workouts,id'
            ]);

            // Get authenticated user
            $user = auth()->user();

            // Fetch the workout with details for the current day
            $workout = $this->currentDayWorkout
                ->where('user_workout_id', $request->user_workout_id)
                ->with('workoutDetails')
                ->first();

            // Decode workout details from JSON
            $workout->details = json_decode($workout->details, true);

            // Initialize counters
            $totalCompletedSets = 0;
            $totalTimeSeconds = 0; // Time in seconds
            $totalCompletedExercises = 0;

            // Loop through workout details and calculate totals
            foreach ($workout->details as $sets) {
                foreach ($sets as $set) {
                    if ($set['status'] == 'completed') {
                        $totalCompletedSets++;
                        $totalCompletedExercises++;

                        // Convert "mm:ss" to seconds
                        list($minutes, $seconds) = explode(':', $set['time']);
                        $totalTimeSeconds += $minutes * 60 + $seconds;
                    }
                }
            }

            // Convert total time back to "mm:ss"
            $totalMinutes = floor($totalTimeSeconds / 60);
            $totalSeconds = $totalTimeSeconds % 60;
            $totalTimeTaken = sprintf('%02d:%02d', $totalMinutes, $totalSeconds);

            // Return the response with calculated totals
            return response()->json([
                'status'                    => 200,
                'workouts'                  => $workout,
                'total_completed_sets'      => $totalCompletedSets,
                'total_time_taken'          => $totalTimeTaken,
                'total_completed_exercises' => $totalCompletedExercises,
                'message'                   => 'User workouts Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserWorkoutControllerApi][fetchCurrentDayWorkout] Error fetching workouts details: ' . $e->getMessage());
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

    public function fetchTotalCompletedCounts(Request $request)
    {
        try {
            $request->validate([
                'gym_id'   => 'required',
                'gym_id.*' => 'exists:gyms,id'
            ]);

            $user = auth()->user();
            $currentDay = strtolower(now()->format('l'));

            // Fetch all workouts for the current day
            $workouts = $this->userWorkout->where('user_id', $user->id)
                ->where('day', $currentDay)
                ->where('gym_id', $request->gym_id)
                ->with(['workoutDetails', 'currentDayWorkout'])
                ->get();

            $totalCompletedWorkouts = 0;
            $totalCompletedSets = 0;
            $totalTimeTaken = 0; // Initialize total time taken
            $allCompleted = true; // Assume all are completed initially

            foreach ($workouts as $workout) {
                // Check if the current workout is completed
                if ($workout->currentDayWorkout && $workout->currentDayWorkout->is_completed) {
                    $totalCompletedWorkouts++;
                } else {
                    $allCompleted = false; // If any workout is not completed, set to false
                }

                // Process the details field to calculate completed sets and total time
                if ($workout->currentDayWorkout && $workout->currentDayWorkout->details) {
                    $details = json_decode($workout->currentDayWorkout->details, true);

                    foreach ($details as $set) {
                        foreach ($set as $setDetails) {
                            if ($setDetails['status'] === 'completed') {
                                $totalCompletedSets++;

                                // Calculate total time taken for completed sets
                                $timeParts = explode(':', $setDetails['time']);
                                $totalTimeTaken += $timeParts[0] * 60 + $timeParts[1]; // Convert time to seconds
                            }
                        }
                    }
                }

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
                    'message'  => 'There are no workouts'
                ], 422);
            }

            return response()->json([
                'status'                   => 200,
                'total_completed_workouts' => $totalCompletedWorkouts,
                'total_completed_sets'     => $totalCompletedSets,
                'total_time_taken'         => $totalTimeTaken . ' seconds', // Return total time in seconds
                'all_completed'            => $allCompleted ? 1 : 0, // Return 1 if all workouts are completed, 0 otherwise
                'message'                  => 'User workouts count fetched successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserWorkoutControllerApi][fetchTotalCompletedCounts] Error fetching workout details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching workout details: ' . $e->getMessage()
            ], 500);
        }
    }
}
