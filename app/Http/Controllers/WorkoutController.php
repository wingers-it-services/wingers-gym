<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\SessionTrait;

class WorkoutController extends Controller
{
    use SessionTrait;
    protected $workout;
    protected $gym;

    public function __construct(
        Workout $workout,
        Gym $gym,
    ) {
        $this->workout = $workout;
        $this->gym = $gym;
    }
    public function viewWorkout()
    {
        $workouts = $this->workout->all();

        return view('GymOwner.add-workout', compact('workouts'));
    }

    public function addWorkout(Request $request)
    {
        try {
            $gym_uuid = $this->getGymSession()['uuid'];
            $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;

            $validatedData = $request->validate([
                'image' => 'required',
                'vedio_link' => 'required',
                'name' => 'required',
                'gender' => 'required',
                'category' => 'required',
                'description' => 'required',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $userImage = $request->file('image');
                $filename = time() . '_' . $userImage->getClientOriginalName();
                $imagePath = 'workout_images/' . $filename;
                $userImage->move(public_path('workout_images/'), $filename);
            }

            // Assuming you have a method addCoupon in your GymCoupon model
            $this->workout->addWorkout($validatedData, $imagePath, $gymId);

            return redirect()->back()->with('status', 'success')->with('message', 'Coupon added successfully.');
        } catch (\Throwable $th) {
            Log::error("[AdminCouponController][addAdminCoupon] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
