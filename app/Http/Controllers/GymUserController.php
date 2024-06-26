<?php

namespace App\Http\Controllers;

use App\Models\GymStaff;
use App\Models\userBmi;
use App\Models\Gym;
use App\Models\GymSubscription;
use App\Models\User;
use App\Models\UserBodyMeasurement;
use App\Models\UserWorkout;
use App\Models\UserDiet;
use App\Services\UserService;
use App\Traits\SessionTrait;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class GymUserController extends Controller
{
    use SessionTrait;
    protected $user;
    protected $gym;
    protected $workout;
    protected $diet;
    protected $userService;
    protected $userBodyMeasurement;
    protected $bmi;
    protected $gymStaff;

    public function __construct(
        User $user,
        Gym $gym,
        UserWorkout $workout,
        UserDiet $diet,
        UserService $userService,
        UserBodyMeasurement $userBodyMeasurement,
        userBmi $bmi,
        GymStaff $gymStaff
    ) {
        $this->user = $user;
        $this->gym = $gym;
        $this->workout = $workout;
        $this->diet = $diet;
        $this->userService = $userService;
        $this->userBodyMeasurement = $userBodyMeasurement;
        $this->bmi = $bmi;
        $this->gymStaff = $gymStaff;
    }

    public function listGymUser()
    {
        $gym_uuid = $this->getGymSession()['uuid'];
        $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;
        $users = $this->user->where('gym_id', $gymId)->get();


        return view('GymOwner.gym-customers', compact('users'));
    }

    public function addGymUser()
    {
        $gym_uuid = $this->getGymSession()['uuid'];
        $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;

        $gymStaff = GymStaff::join('designations', 'designations.id', 'gym_staffs.designation_id')
            ->where('gym_staffs.gym_id', $gymId)->get();

        $gymSubscription = GymSubscription::where('gym_id', $gymId)->get();


        return view('GymOwner.add-gym-customer', compact('gymStaff','gymSubscription'));
    }

    public function addUserByGym(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'gender' => 'required',
                'phone_no' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required'

            ]);

            $gym_uuid = $this->getGymSession()['uuid'];
            $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;

            $this->userService->createUserAccount($request->all(), $gymId);



            return back()->with('status', 'success')->with('message', 'User Added Succesfully');
        } catch (\Exception $e) {
            Log::error('[GymUserController][addUserByGym]Error adding : ' . 'Request=' . $e->getMessage());
            return back()->with('status', 'error')->with('message', 'User Not Added ');
        }
    }


    public function showUserProfile(Request $request)
    {
        $uuid = $request->input('uuid');
        $userDetail = $this->user->where('uuid', $uuid)->first();
        $workouts = $this->workout->all();
        $diets = $this->diet->all();

        $gymId = $this->gym->where('uuid', $this->getGymSession()['uuid'])->first()->id;
        $userId = $userDetail->id;
        $bmis = $this->bmi->where('user_id', $userId)->get();
        $trainers = $this->gymStaff->where('designation_id', "1")->get();
        $trainers = $this->gymStaff->where('gym_id', $gymId)->where('designation_id', "1")->get();
        // dd($gymId);
        return view('GymOwner.User.userProfile', compact('userDetail', 'workouts', 'diets', 'bmis', 'trainers'));
    }

    public function updateUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'uuid' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'gender' => 'required',
                'phone_no' => 'required',
                'username' => 'required',
                'password' => 'required',
                'image' => 'nullable'
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $gymImage = $request->file('image');
                $filename = time() . '_' . $gymImage->getClientOriginalName();
                $imagePath = 'gymProfile_images/' . $filename;
                $gymImage->move(public_path('gymProfile_images/'), $filename);
            }

            $isProfileUpdated = $this->user->updateUser($validatedData, $imagePath);

            if ($isProfileUpdated) {
                return redirect()->route('listGymUser')->with('status', 'success')->with('message', 'User profile and workout data updated successfully.');
            }
            return redirect()->back()->with('status', 'error')->with('message', 'error while updating user.');
        } catch (\Exception $e) {
            Log::error('[GymDetailController][updateUser] Error updating user ' . 'Request=' . $request . ', Exception=' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'error while updating user.');
        }
    }

    public function addUserWorkout(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "user_id" => 'required',
                "exercise_name" => 'required',
                "sets" => 'required|integer|min:1',
                "reps" => 'required|integer|min:1',
                "weight" => 'required|numeric|min:0',
                "notes" => 'required',
            ]);

            $this->workout->addWorkout($validatedData);

            return redirect()->back()->with('success', 'Workout data saved successfully.');
        } catch (Throwable $th) {
            Log::error("[GymUserController][addUserWorkout] error " . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to save workout data. Please try again.');
        }
    }


    public function addUserDiet(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "user_id" => 'required',
                "meal_name" => 'required',
                "calories" => 'required|integer|min:0',
                "protein" => 'required|integer|min:0',
                "carbs" => 'required|numeric|min:0',
                "fats" => 'required|numeric|min:0',
                "notes" => 'required',
            ]);

            $this->diet->addUserDiet($validatedData);

            return redirect()->back()->with('success', 'Diet data saved successfully.');
        } catch (Throwable $th) {
            Log::error("[GymUserController][addUserDiet] error " . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to save workout data. Please try again.');
        }
    }

    public function updateUserWorkout(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'workout_id' => 'required|exists:user_workouts,id',
                'user_id' => 'required|exists:users,id',
                'exercise_name' => 'required|string',
                'sets' => 'required|integer|min:1',
                'reps' => 'required|integer|min:1',
                'weight' => 'required|numeric|min:0',
                'notes' => 'nullable|string',
            ]);

            // Find the workout by ID
            $workout = $this->workout->findOrFail($validatedData['workout_id']);

            // Update the workout attributes
            $workout->exercise_name = $validatedData['exercise_name'];
            $workout->sets = $validatedData['sets'];
            $workout->reps = $validatedData['reps'];
            $workout->weight = $validatedData['weight'];
            $workout->notes = $validatedData['notes'];

            // Save the changes
            $workout->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Workout updated successfully.');
        } catch (Throwable $th) {
            Log::error("[GymUserController][updateUserWorkout] error " . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to update workout data. Please try again.');
        }
    }

    public function updateUserDiet(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'diet_id' => 'required|exists:user_diets,id',
                'user_id' => 'required|exists:users,id',
                'meal_name' => 'required|string',
                "calories" => 'required|integer|min:0',
                "protein" => 'required|integer|min:0',
                "carbs" => 'required|numeric|min:0',
                "fats" => 'required|numeric|min:0',
                "notes" => 'nullable|string',
            ]);

            // Find the workout by ID
            $diet = $this->diet->findOrFail($validatedData['diet_id']);

            $diet->meal_name = $validatedData['meal_name'];
            $diet->calories = $validatedData['calories'];
            $diet->protein = $validatedData['protein'];
            $diet->carbs = $validatedData['carbs'];
            $diet->fats = $validatedData['fats'];
            $diet->notes = $validatedData['notes'];
            // Save the changes
            $diet->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Diet updated successfully.');
        } catch (Throwable $th) {
            Log::error("[GymUserController][updateUserDiet] error " . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to update workout data. Please try again.');
        }
    }

    public function allocateTrainerToUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "trainer_id" => 'required',
                "user_id" => 'required'
            ]);

            $this->user->addTrainer($validatedData);

            return redirect()->back()->with('success', 'Trainer Alloted succesfully.');
        } catch (Throwable $th) {
            Log::error("[GymUserController][allocateTrainerToUser] error " . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to allocate trainer. Please try again.');
        }
    }
}
