<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Diet;
use App\Models\Gym;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\SessionTrait;

class DietController extends Controller
{
    use SessionTrait;
    protected $diet;
    protected $gym;

    public function __construct(
        Diet $diet,
        Gym $gym,
    ) {
        $this->diet = $diet;
        $this->gym = $gym;
    }
    public function viewDiet()
    {
        $diets = $this->diet->all();
        return view('GymOwner.add-diet', compact('diets'));
    }

    public function addDiet(Request $request)
    {
        try {
            $gym_uuid = $this->getGymSession()['uuid'];
            $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;

            $validatedData = $request->validate([
                'image' => 'required',
                'name' => 'required',
                'diet' => 'required',
                'gender' => 'required',
                'alternative_diet' => 'nullable',
                'min_age' => 'required',
                'max_age' => 'required',
                'goal' => 'required'
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $userImage = $request->file('image');
                $filename = time() . '_' . $userImage->getClientOriginalName();
                $imagePath = 'diet_images/' . $filename;
                $userImage->move(public_path('diet_images/'), $filename);
            }

            // Assuming you have a method addCoupon in your GymCoupon model
            $this->diet->addDiet($validatedData, $imagePath, $gymId);

            return redirect()->back()->with('status', 'success')->with('message', 'Coupon added successfully.');
        } catch (\Throwable $th) {
            Log::error("[WorkoutController][addDiet] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
