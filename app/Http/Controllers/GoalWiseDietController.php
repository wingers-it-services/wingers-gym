<?php

namespace App\Http\Controllers;

use App\Models\Diet;
use App\Models\Goal;
use App\Models\GoalWiseDiet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoalWiseDietController extends Controller
{
    protected $goalWiseDiet;
    protected $diet;
    protected $goal;

    public function __construct(
        GoalWiseDiet $goalWiseDiet,
        Diet $diet,
        Goal $goal
    ) {
        $this->goalWiseDiet = $goalWiseDiet;
        $this->diet = $diet;
        $this->goal = $goal;
    }

    public function viewGoalWiseDiet()
    {
        $status = null;
        $message = null;
        $gym = Auth::guard('gym')->user();
        $goalWiseDiets = $this->goalWiseDiet->with('goal','diet')->get();
        $diets = $this->diet->where('added_by', $gym->id)->get();
        $goals = $this->goal->get();
        return view(
            'GymOwner.add-goal-wise-diet',
            compact('status', 'message', 'goalWiseDiets', 'diets', 'goals')
        );
    }

    public function addGoalWiseDiet(Request $request)
    {
        try {
            $request->validate([
                'goal_id'  => 'required',
                'diet_id'  => 'required',
            ]);
            $existingDiet = $this->goalWiseDiet->where('diet_id', $request->diet_id)
                ->where('goal_id', $request->goal_id)
                ->first();

            if ($existingDiet) {
                return redirect()->back()->with('status', 'error')->with('message', 'This diet is already assigned to the corresponding goal');
            }

            $this->goalWiseDiet->addGoalWiseDiet($request->all());

            return redirect()->back()->with('status', 'success')->with('message', 'Diet added successfully.');
        } catch (\Throwable $th) {
            Log::error("[GoalWiseDietController][addGoalWiseDiet] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error adding diet according to goal. ' . $th->getMessage());
        }
    }
}
