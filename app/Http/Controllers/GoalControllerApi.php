<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GoalControllerApi extends Controller
{
    protected $goal;

    public function __construct(Goal $goal)
    {
        $this->goal = $goal;
    }

   /**
    * The function fetches goals data and returns a JSON response with success or error messages.
    * 
    * @param Request request The `fetchGoal` function is designed to retrieve goals from the database
    * and return a JSON response with the fetched goals. Here's a breakdown of the function:
    * 
    * @return The `fetchGoal` function returns a JSON response with status code 200 if goals are
    * fetched successfully. If there are no goals available, it returns a message stating "There is no
    * goal". If an error occurs during the fetching process, it returns a JSON response with status
    * code 500 and an error message.
    */
    public function fetchGoal(Request $request)
    {
        try {
            $goals = $this->goal->get();

            if ($goals->isEmpty()) {
                return response()->json([
                    'status'   => 200,
                    'goals'    => $goals,
                    'message'  => 'There is no goal'
                ], 200);
            }

            return response()->json([
                'status'   => 200,
                'goals'    => $goals,
                'message'  => 'Goal Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[GoalControllerApi][fetchGoal]Error fetching goals details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching goal details: ' . $e->getMessage()
            ], 500);
        }
    }
}
