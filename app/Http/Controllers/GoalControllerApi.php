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
