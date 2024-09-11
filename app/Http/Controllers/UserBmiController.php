<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\userBmi;
use App\Models\UserBodyMeasurement;
use App\Traits\SessionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserBmiController extends Controller
{
    use SessionTrait;
    protected $userBodyMeasurement;
    protected $bmi;
    protected $gym;


    public function __construct(UserBodyMeasurement $userBodyMeasurement, userBmi $bmi, Gym $gym)
    {
        $this->userBodyMeasurement = $userBodyMeasurement;
        $this->bmi = $bmi;
        $this->gym = $gym;
    }

    public function createUserBodyMeasurement(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "user_id" => 'required',
                "chest" => 'required',
                "triceps" => 'required',
                "biceps" => 'required',
                "lats" => 'required',
                "shoulder" => 'required',
                "abs" => 'required',
                "forearms" => 'required',
                "traps" => 'required',
                "glutes" => 'required',
                "quads" => 'required',
                "hamstring" => 'required',
                "calves" => 'required',
                "height" => 'required',
                "weight" => 'required',
                "bmi" => 'required',
                "month" => 'required'
            ]);

            $userId = $request->all()['user_id'];
            $gym = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;
            // Create the BMI record first
            $bmi = $this->bmi->createBmi($validatedData, $userId, $gymId);

            // Create the body measurement record with the newly created bmi_id
            $this->userBodyMeasurement->createBodyMeasurement($validatedData, $userId, $gymId, $bmi->id);

            return redirect()->back()->with('status', 'success')->with('message', 'Data saved successfully.');
        } catch (\Throwable $th) {
            Log::error("[UserBmiController][createUserBmi] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $th->getMessage());
        }
    }

    public function updateUserBmi(Request $request)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'user_id' => 'required',
                'height' => 'required|numeric|min:1',
                'weight' => 'required|numeric|min:1',
                'bmi' => 'required|numeric|min:0',
                // Add validation rules for body measurements
                'chest' => 'nullable|numeric|min:0',
                'triceps' => 'nullable|numeric|min:0',
                'biceps' => 'nullable|numeric|min:0',
                'lats' => 'nullable|numeric|min:0',
                'shoulder' => 'nullable|numeric|min:0',
                'abs' => 'nullable|numeric|min:0',
                'forearms' => 'nullable|numeric|min:0',
                'traps' => 'nullable|numeric|min:0',
                'glutes' => 'nullable|numeric|min:0',
                'quads' => 'nullable|numeric|min:0',
                'hamstring' => 'nullable|numeric|min:0',
                'calves' => 'nullable|numeric|min:0',
                'month'  => 'required'
            ]);

            // Update or create the BMI record
            $bmi = $this->bmi->updateOrCreate(
                ['user_id' => $request->user_id],
                [
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'bmi' => $request->bmi,
                    'month' => $request->month
                ]
            );

            // Update or create the body measurement record
            $bodyMeasurement = $this->userBodyMeasurement->updateOrCreate(
                ['user_id' => $request->user_id],
                [
                    'chest' => $request->chest,
                    'triceps' => $request->triceps,
                    'biceps' => $request->biceps,
                    'lats' => $request->lats,
                    'shoulder' => $request->shoulder,
                    'abs' => $request->abs,
                    'forearms' => $request->forearms,
                    'traps' => $request->traps,
                    'glutes' => $request->glutes,
                    'quads' => $request->quads,
                    'hamstring' => $request->hamstring,
                    'calves' => $request->calves,
                ]
            );

            return redirect()->back()->with('status', 'success')->with('message', 'Body Measurement And BMI Updated Successfully');
        } catch (Throwable $th) {
            Log::error("[GymUserController][updateUserBmi] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $th->getMessage());
        }
    }

    public function deleteBmi($uuid)
    {
        $bmi = $this->bmi->where('uuid', $uuid)->firstOrFail();
        $bodyMeasure = $this->userBodyMeasurement->where('bmi_id',$bmi->id)->firstOrFail();

        $bmi->delete();
        $bodyMeasure->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'User BMI deleted successfully!');
    }
}
