<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Diet;
use App\Models\Gym;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\SessionTrait;
use Exception;
use Illuminate\Support\Facades\Auth;

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
        $gym = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;
        $diets = $this->diet->where('gym_id', $gymId)->get();
        return view('GymOwner.add-diet', compact('diets'));
    }

    public function addDiet(Request $request)
    {
        try {
            $gym = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

            $validatedData = $request->validate([
                'image' => 'required',
                'name' => 'required',
                'diet' => 'required',
                'gender' => 'required',
                'alternative_diet' => 'nullable',
                'min_age' => 'required',
                'max_age' => 'required',
                'goal' => 'required',
                'calories' => 'nullable',
                'protein' => 'required',
                'carbs' => 'required',
                'fats' => 'required',
                'meal_type' => 'required'
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $userImage = $request->file('image');
                $filename = time() . '_' . $userImage->getClientOriginalName();
                $imagePath = 'diet_images/' . $filename;
                $userImage->move(public_path('diet_images/'), $filename);
            }

            $this->diet->addDiet($validatedData, $imagePath, $gymId);

            return redirect()->back()->with('status', 'success')->with('message', 'Diet added successfully.');
        } catch (\Throwable $th) {
            Log::error("[DietController][addDiet] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function updateDiet(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'diet_id' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                'name' => 'required',
                'gender' => 'required',
                'diet' => 'required',
                'alternative_diet' => 'nullable',
                'min_age' => 'required|integer',
                'max_age' => 'required|integer',
                'goal' => 'required',
                'calories' => 'nullable',
                'protein' => 'required',
                'carbs' => 'required',
                'fats' => 'required',
                'meal_type' => 'required'
            ]);

            $diet = $this->diet->findOrFail($request->diet_id);

            $imagePath = $diet->image; // Default to existing image path

            if ($request->hasFile('image')) {
                if ($diet->image) {
                    $existingImagePath = public_path($diet->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }
                $imagefile = $request->file('image');
                $filename = time() . '_' . $imagefile->getClientOriginalName();
                $imagePath = 'diet_images/' . $filename;
                $imagefile->move(public_path('diet_images/'), $filename);
            }

            $diet->update([
                'name' => $validatedData['name'],
                'gender' => $validatedData['gender'],
                'diet' => $validatedData['diet'],
                'alternative_diet' => $validatedData['alternative_diet'],
                'min_age' => $validatedData['min_age'],
                'max_age' => $validatedData['max_age'],
                'goal' => $validatedData['goal'],
                'image' => $imagePath,
                'calories' => $validatedData['calories'],
                'protein' => $validatedData['protein'],
                'carbs' => $validatedData['carbs'],
                'fats' => $validatedData['fats'],
                'meal_type' => $validatedData['meal_type'],

            ]);

            return redirect()->back()->with('status', 'success')->with('message', 'Diet updated successfully.');
        } catch (Exception $e) {
            Log::error('[DietController][updateDiet] Error updating diet ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error while updating diet.' . $e->getMessage());
        }
    }

    public function deleteDiet($uuid)
    {
        $diet = $this->diet->where('uuid', $uuid)->firstOrFail();

        $diet->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'Diet deleted successfully!');
    }
}
