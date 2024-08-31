<?php

namespace App\Http\Controllers;

use App\Models\UserDiet;
use App\Traits\errorResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserDietControllerApi extends Controller
{
    use errorResponseTrait;
    protected $userDiet;

    public function __construct(
        UserDiet $userDiet,
    ) {
        $this->userDiet = $userDiet;
    }

    /**
     * The function fetches a user's diet information and returns it in a JSON response, handling
     * authentication, empty results, and error cases.
     * 
     * @return The `fetchUserDiet` function returns a JSON response with different status codes and
     * messages based on the outcome of fetching user diets.
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
                ->with('dietsDetails:id,id,image')->get();

            $totalCalories = 0;
            $totalProtein = 0;
            $totalCarbs = 0;
            $totalFats = 0;

            foreach ($diets as $diet) {
                if ($diet->dietsDetails) {
                    $diet->image = $diet->dietsDetails->image;
                }
                unset($diet->dietsDetails);

                // Summing up the nutritional values
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

    public function updateUserDietStatus(Request $request)
    {
        try {
            $request->validate([
                'user_diet_id' => 'required|exists:user_diets,id',
                'is_completed' => 'required|in:0,1',
            ]);
            // Call the model method to update the diet status
            $result = $this->userDiet->updateUserDietStatus($request->all());
            $userDiet = $this->userDiet->find($request->user_diet_id);
            // Handle the response
            if ($result) {
                return response()->json([
                    'status'  => 200,
                    'diet'    => $userDiet,
                    'message' => 'User diet status updated successfully'
                ]);
            } else {
                return response()->json([
                    'status'  => 500,
                    'diet'    => $userDiet,
                    'message' => 'Failed to update user diet status'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('[UserDietController][updateUserDietStatus] Error updating user diet status: ' . $e->getMessage());

            return response()->json([
                'status'  => 500,
                'message' => 'An error occurred while updating user diet status. Please try again later.' . $e->getMessage()
            ], 500);
        }
    }
}
