<?php

namespace App\Http\Controllers;

use App\Models\userBmi;
use App\Models\UserBodyMeasurement;
use App\Traits\SessionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserBmiController extends Controller
{
    use SessionTrait;
    protected $userBodyMeasurement;
    protected $bmi;


    public function __construct(UserBodyMeasurement $userBodyMeasurement,userBmi $bmi)
    {
        $this->userBodyMeasurement = $userBodyMeasurement;
        $this->bmi = $bmi;
    }

    public function createUserBodyMeasurement(Request $request)
    {
        // dd($request->all());
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
                "age" => 'required'
            ]);

            $userId = $request->all()['user_id'];
            $this->userBodyMeasurement->createBodyMeasurement($validatedData, $userId);
            $this->bmi->createBmi($validatedData, $userId);

            return redirect()->back()->with('success', 'Data saved successfully.');
        } catch (\Throwable $th) {
            Log::error("[UserBmiController][createUserBmi] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
