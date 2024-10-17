<?php

namespace App\Http\Controllers;

use App\Models\Diet;
use App\Models\Goal;
use App\Models\GoalWiseDiet;
use App\Models\UserLebel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoalWiseDietController extends Controller
{
    protected $goalWiseDiet;
    protected $diet;
    protected $goal;
    protected $level;

    public function __construct(
        GoalWiseDiet $goalWiseDiet,
        UserLebel $level,
        Diet $diet,
        Goal $goal
    ) {
        $this->goalWiseDiet = $goalWiseDiet;
        $this->level = $level;
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
        $levels = $this->level->get();
        return view(
            'GymOwner.add-goal-wise-diet',
            compact('status', 'message', 'goalWiseDiets', 'diets', 'goals','levels')
        );
    }

    public function addGoalWiseDiet(Request $request)
    {
        try {
            $request->validate([
                'goal_id'  => 'required',
                'diet_id'  => 'required',
            ]);

            $this->goalWiseDiet->addGoalWiseDiet($request->all());

            return redirect()->back()->with('status', 'success')->with('message', 'Diet added successfully.');
        } catch (\Throwable $th) {
            Log::error("[GoalWiseDietController][addGoalWiseDiet] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error adding diet according to goal. ' . $th->getMessage());
        }
    }
}
