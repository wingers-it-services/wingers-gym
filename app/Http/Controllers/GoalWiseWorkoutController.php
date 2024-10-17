<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\GoalWiseWorkouts;
use App\Models\UserLebel;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoalWiseWorkoutController extends Controller
{
    protected $goalWiseWorkouts;
    protected $workout;
    protected $goal;
    protected $level;

    public function __construct(
        GoalWiseWorkouts $goalWiseWorkouts,
        UserLebel $level,
        Workout $workout,
        Goal $goal
    ) {
        $this->goalWiseWorkouts = $goalWiseWorkouts;
        $this->level = $level;
        $this->workout = $workout;
        $this->goal = $goal;
    }

    public function viewGoalWiseWorkout()
    {
        $status = null;
        $message = null;
        $gym = Auth::guard('gym')->user();
        $goalWiseWorkouts = $this->goalWiseWorkouts->with('goal', 'workout')->get();
        $workouts = $this->workout->where('added_by', $gym->id)->get();
        // $goals = $this->goal->get();
        $levels = $this->level->get();

        $goals = Goal::with(['goalWiseWorkouts.level', 'goalWiseWorkouts.workout'])->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    

        return view(
            'GymOwner.add-goal-wise-workout',
            compact('status', 'message', 'goalWiseWorkouts', 'workouts', 'goals','levels','days')
        );

        // return view(
        //     'GymOwner.abc',
        //     compact('status', 'message', 'goalWiseWorkouts', 'workouts', 'goals','levels')
        // );


    }

    public function addGoalWiseWorkouts(Request $request)
    {
        try {
            $request->validate([
                'goal_id'     => 'required',
                'workout_id'  => 'required',
                'sets'        => 'required',
                'reps'        => 'required',
                'weight'      => 'required'
            ]);
            
            $existingWorkout = $this->goalWiseWorkouts->where('workout_id', $request->workout_id)
                ->where('goal_id', $request->goal_id)
                ->first();

            if ($existingWorkout) {
                return redirect()->back()->with('status', 'error')->with('message', 'This workout is already assigned to the corresponding goal');
            }

            $this->goalWiseWorkouts->addGoalWiseWorkout($request->all());

            return redirect()->back()->with('status', 'success')->with('message', 'Workout added successfully.');
        } catch (\Throwable $th) {
            Log::error("[GoalWiseWorkoutController][addGoalWiseWorkouts] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error adding workout according to goal. ' . $th->getMessage());
        }
    }
}
