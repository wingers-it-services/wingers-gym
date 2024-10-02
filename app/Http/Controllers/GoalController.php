<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GoalController extends Controller
{
    protected $goal;

    public function __construct(
        Goal $goal
    ) {
        $this->goal = $goal;
    }

    public function viewAddGoal()
    {
        $status = null;
        $message = null;
        $goals = $this->goal->get();
        return view('GymOwner.add-goal', compact('status', 'message', 'goals'));
    }

    public function addGoal(Request $request)
    {
        try {
            $request->validate([
                'goal'  => 'required',
            ]);
            $this->goal->addGoal($request->all());
            return redirect()->back()->with('status', 'success')->with('message', 'Goal added successfully.');
        } catch (\Throwable $th) {
            Log::error("[GoalController][addGoal] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error adding goal. ' . $th->getMessage());
        }
    }

    public function updateGoal(Request $request)
    {
        try {
            $request->validate([
                'goal' => 'required',
            ]);
           
            $data = $request->all();

            $isGoalUpdate = $this->goal->updateGoal($data);

            if (!$isGoalUpdate) {
                return redirect()->back()->with('status', 'error')->with('message', 'Error while updating goal.');
            }
            return redirect()->back()->with('status', 'success')->with('message', 'Goal Updated successfully.');
        } catch (Exception $e) {
            Log::error('[GoalController][updateGoal] Error updating goal ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'error while updating goal.');
        }
    }

    public function deleteGoal($uuid)
    {
        $goal = $this->goal->where('uuid', $uuid)->firstOrFail();

        $goal->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'Goal deleted successfully!');
    }
}
