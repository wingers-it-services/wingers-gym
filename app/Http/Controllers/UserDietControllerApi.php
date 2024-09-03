<?php

namespace App\Http\Controllers;

use App\Models\CurrentDayDiet;
use App\Models\UserDiet;
use App\Traits\errorResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserDietControllerApi extends Controller
{
    use errorResponseTrait;
    protected $userDiet;
    protected $currentDayDiet;

    public function __construct(
        UserDiet $userDiet,
        CurrentDayDiet $currentDayDiet
    ) {
        $this->userDiet = $userDiet;
        $this->currentDayDiet = $currentDayDiet;
    }

    /**
     * This PHP function fetches a user's diet details based on the current day and gym ID, calculating
     * total calories, protein, carbs, and fats consumed.
     * 
     * @param Request request The `fetchUserDiet` function is responsible for fetching diet details for
     * a user based on the current day and gym ID provided in the request. Here's a breakdown of the
     * function:
     * 
     * @return The `fetchUserDiet` function returns a JSON response with the following structure:
     * - If the user is not authenticated, it returns a 401 status with a message 'User not
     * authenticated'.
     * - If there are no diets for the user on the current day, it returns a 422 status with a message
     * 'There are no diets'.
     * - If the diets are successfully fetched, it returns a
     */
    public function fetchUserDiet(Request $request)
    {
        try {
            $request->validate([
                'gym_id'   => 'required',
                'gym_id.*' => 'exists:gyms,id'
            ]);
            $user = auth()->user();
            $currentDay = strtolower(now()->format('l'));

            if (!$user) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'User not authenticated',
                ], 401);
            }

            $diets = $this->userDiet
                ->where('user_id', $user->id)
                ->where('day', $currentDay)
                ->where('gym_id', $request->gym_id)
                ->with(['dietsDetails:id,id,image', 'currentDayDiet:id,user_diet_id,is_completed'])->get();

            $totalCalories = 0;
            $totalProtein = 0;
            $totalCarbs = 0;
            $totalFats = 0;

            foreach ($diets as $diet) {
                if ($diet->dietsDetails) {
                    $diet->image = $diet->dietsDetails->image;
                }
                unset($diet->dietsDetails);

                $totalCalories += $diet->calories;
                $totalProtein += $diet->protein;
                $totalCarbs += $diet->carbs;
                $totalFats += $diet->fats;
            }

            if ($diets->isEmpty()) {
                return response()->json([
                    'status'   => 422,
                    'diets'    => $diets,
                    'message'  => 'There are no diets'
                ], 422);
            }

            return response()->json([
                'status'         => 200,
                'diets'          => $diets,
                'total_calories' => $totalCalories,
                'total_protein'  => $totalProtein,
                'total_carbs'    => $totalCarbs,
                'total_fats'     => $totalFats,
                'message'        => 'User diets fetched successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserDietControllerApi][fetchUserDiet] Error fetching diets details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching diets details: ' . $e->getMessage()
            ], 500);
        }
    }

   /**
    * This PHP function updates the status of a user's current day diet based on the provided request
    * data.
    * 
    * @param Request request The `updateUserDietStatus` function is responsible for updating the status
    * of a user's current day diet based on the provided request parameters. Let's break down the
    * parameters required in the request:
    * 
    * @return The `updateUserDietStatus` function returns a JSON response with the status code, diet
    * information, and a message indicating the result of updating the current day diet status.
    */
    public function updateUserDietStatus(Request $request)
    {
        try {
            $request->validate([
                'current_day_diet_id' => 'required|exists:current_day_diets,id',
                'is_completed'        => 'required|in:0,1',
            ]);

            $currentDayDiet = $this->currentDayDiet->where('id', $request->current_day_diet_id)
                ->where('user_id', auth()->user()->id)
                ->first();

            if (!$currentDayDiet) {
                return response()->json([
                    'status'  => 404,
                    'message' => 'Invalid diet or diet not found'
                ], 404);
            }
            $currentDayDiet->is_completed = $request->is_completed;
            $result = $currentDayDiet->save();

            if ($result) {
                return response()->json([
                    'status'  => 200,
                    'diet'    => $currentDayDiet,
                    'message' => 'Current day diet status updated successfully'
                ]);
            } else {
                return response()->json([
                    'status'  => 500,
                    'diet'    => $currentDayDiet,
                    'message' => 'Failed to update current day diet status'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('[UserDietController][updateUserDietStatus] Error updating current day diet status: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'An error occurred while updating current day diet status. Please try again later. ' . $e->getMessage()
            ], 500);
        }
    }
}
