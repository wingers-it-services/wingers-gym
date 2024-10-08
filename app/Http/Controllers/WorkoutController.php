<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\SessionTrait;
use Exception;
use Illuminate\Support\Facades\Auth;

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
        $gym = Auth::guard('gym')->user();
    
        if ($gym->gym_type == 'admin') {
            $workouts = $this->workout->get(); 

            foreach ($workouts as $workout) {
                $workout->is_editable = true; 
            }
        } else {
            $admin = $this->gym->where('gym_type', 'admin')->first();
            $workouts = $this->workout
                ->where('added_by', $gym->id)
                ->orWhere('added_by', $admin->id)
                ->get();
    
            foreach ($workouts as $workout) {
                $addedByGym = Gym::find($workout->added_by);
                if ($addedByGym && $addedByGym->gym_type == 'admin') {
                    $workout->is_editable = false; 
                } else {
                    $workout->is_editable = true; 
                }
            }
        }
    
        return view('GymOwner.add-workout', compact('workouts'));
    } 

    public function addWorkout(Request $request)
    {
        try {
            $gym = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

            $validatedData = $request->validate([
                'image'              => 'required',
                'vedio_link'         => 'required',
                'name'               => 'required',
                'gender'             => 'required',
                'category'           => 'required',
                'description'        => 'required',
                'user_type'          => 'required',
                'targeted_body_part' => 'required'
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

            return redirect()->back()->with('status', 'success')->with('message', 'Workout added successfully.');
        } catch (\Throwable $th) {
            Log::error("[WorkoutController][addWorkout] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $th->getMessage());
        }
    }

    public function updateWorkout(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'workout_id'         => 'required',
                'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'vedio_link'         => 'required',
                'name'               => 'required',
                'gender'             => 'required',
                'category'           => 'required',
                'description'        => 'required',
                'targeted_body_part' => 'required'
            ]);

            $workout = $this->workout->findOrFail($request->workout_id);


            if ($request->hasFile('image')) {
                if ($workout->image) {
                    $existingImagePath = public_path($workout->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }
                $imagefile = $request->file('image');
                $filename = time() . '_' . $imagefile->getClientOriginalName();
                $imagePath = 'workout_images/' . $filename;
                $imagefile->move(public_path('workout_images/'), $filename);
                $workout->image = $imagePath; // Update image path

            }

            $workout->vedio_link = $validatedData['vedio_link'];
            $workout->name = $validatedData['name'];
            $workout->gender = $validatedData['gender'];
            $workout->category = $validatedData['category'];
            $workout->targeted_body_part = $validatedData['targeted_body_part'];
            $workout->description = $validatedData['description'];

            $workout->save();

            return redirect()->back()->with('status', 'success')->with('message', 'Workout updated successfully.');
        } catch (Exception $e) {
            Log::error('[WorkoutController][updateWorkout] Error updating workout ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error while updating workout.');
        }
    }

    public function deleteWorkout($uuid)
    {
        $workout = $this->workout->where('uuid', $uuid)->firstOrFail();

        $workout->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'Workout deleted successfully!');
    }
}
