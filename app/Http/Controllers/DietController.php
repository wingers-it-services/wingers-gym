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
        if ($gym->gym_type == 'admin') {
            $diets = $this->diet->get();

            foreach ($diets as $diet) {
                $diet->is_editable = true;
            }
        } else {
            $admin = $this->gym->where('gym_type', 'admin')->first();

            $diets = $this->diet->where('added_by', $gym->id)->orWhere('added_by', $admin->id)->get();
            foreach ($diets as $diet) {
                $addedByGym = Gym::find($diet->added_by);
                if ($addedByGym && $addedByGym->gym_type == 'admin') {
                    $diet->is_editable = false;
                } else {
                    $diet->is_editable = true;
                }
            }
        }
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
                $diet->image = $imagePath; // Update image path
            }

            $diet->name = $validatedData['name'];
            $diet->gender = $validatedData['gender'];
            $diet->diet = $validatedData['diet'];
            $diet->alternative_diet = $validatedData['alternative_diet'];
            $diet->min_age = $validatedData['min_age'];
            $diet->max_age = $validatedData['max_age'];
            $diet->calories = $validatedData['calories'];
            $diet->protein = $validatedData['protein'];
            $diet->carbs = $validatedData['carbs'];
            $diet->fats = $validatedData['fats'];
            $diet->meal_type = $validatedData['meal_type'];
            $diet->goal = $validatedData['goal'];

            $diet->save();

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
