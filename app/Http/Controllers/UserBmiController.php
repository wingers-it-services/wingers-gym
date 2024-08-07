<?php

namespace App\Http\Controllers;

use App\Models\Gym;
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
    protected $gym;


    public function __construct(UserBodyMeasurement $userBodyMeasurement,userBmi $bmi, Gym $gym)
    {
        $this->userBodyMeasurement = $userBodyMeasurement;
        $this->bmi = $bmi;
        $this->gym = $gym;
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
            ]);

            $userId = $request->all()['user_id'];
            $gym_uuid = $this->getGymSession()['uuid'];
            $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;
            $this->userBodyMeasurement->createBodyMeasurement($validatedData, $userId, $gymId);
            $this->bmi->createBmi($validatedData, $userId, $gymId);

            return redirect()->back()->with('status', 'success')->with('message', 'Data saved successfully.');
        } catch (\Throwable $th) {
            Log::error("[UserBmiController][createUserBmi] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
