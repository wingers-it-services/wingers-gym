<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Gym;
use App\Models\UserWorkout;
use App\Models\UserDiet;
use App\Models\UserBodyMeasurement;
use App\Models\userBmi;
use App\Models\GymStaff;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Traits\SessionTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminUserController extends Controller
{
    use SessionTrait;
    protected $user;
    protected $gym;
    protected $userService;
    protected $workout;
    protected $diet;
    protected $userBodyMeasurement;
    protected $bmi;
    protected $gymStaff;

    public function __construct(AdminUser $user, Gym $gym,  UserService $userService, UserWorkout $workout, UserDiet $diet, UserBodyMeasurement $userBodyMeasurement, userBmi $bmi, GymStaff $gymStaff)
    {
        $this->user = $user;
        $this->gym = $gym;
        $this->userService = $userService;
        $this->workout = $workout;
        $this->diet = $diet;
        $this->userBodyMeasurement = $userBodyMeasurement;
        $this->bmi = $bmi;
        $this->gymStaff = $gymStaff;
    }

    public function showAddUsers()
    {
        $status = null;
        $message = null;
        $gyms = $this->gym->get();

        return view('admin.adminUser.addAdminUsers', compact('status', 'message', 'gyms'));
    }

    public function addUserByadmin(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'gym_id' => 'nullable',
                'user_type' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'gender' => 'required',
                'phone_no' => 'required',
                'username' => 'required',
                'password' => 'required',
                'image' => 'required'
            ]);

            $imagePath = null;
            $data = $request->all();
            if ($request->hasFile('image')) {
                $imagePath = $this->userService->uploadUserProfileImage($request->file('image'));
            }

            if ($validatedData['user_type'] == \App\Enums\UserTypeEnum::HOMEUSER) {
                $validatedData['gym_id'] = 0;
            }

            $this->user->addUser($validatedData, $imagePath);

            return back()->with('status', 'success')->with('message', 'User Added Successfully');
        } catch (\Exception $e) {
            Log::error('[AdminUserController][addUserByadmin] Error adding user: ' . $e->getMessage());
            return back()->with('status', 'error')->with('message', 'User Not Added');
        }
    }

    public function gymUserList()
    {
        $gymUserType = \App\Enums\UserTypeEnum::GYMUSER;
        $gymUsers = $this->user->where('user_type', $gymUserType)->get();
        return view('admin.adminUser.gymUserList', compact('gymUsers'));
    }

    public function homeUserList()
    {
        $gymUserType = \App\Enums\UserTypeEnum::HOMEUSER;
        $homeUsers = $this->user->where('user_type', $gymUserType)->get();
        return view('admin.adminUser.homeUserList', compact('homeUsers'));
    }


    public function viewEditUser($uuid)
    {
        $user = $this->user->where('uuid', $uuid)->first();
        $gyms = $this->gym->get();
        $workouts = $this->workout->all();
        $diets = $this->diet->all();

        $gymId = $this->gym->where('uuid', $this->getGymSession()['uuid'])->first()->id;
        $userId = $user->id;
        $bmis = $this->bmi->where('user_id', $userId)->get();
        $trainers = $this->gymStaff->where('designation_id', "1")->get();
        $trainers = $this->gymStaff->where('gym_id', $gymId)->where('designation_id', "1")->get();
        return view('admin.adminUser.editAdminUser', compact('user', 'gyms', 'workouts', 'diets', 'bmis', 'trainers'));
    }

    /**
     * The function `updateAdminUser` in PHP updates an admin user's profile with validation, image
     * upload, and error handling.
     * 
     * @param Request request The `updateAdminUser` function is used to update an admin user's profile
     * based on the provided request data. The function first validates the incoming request data to
     * ensure that all required fields are present. If an image file is included in the request, it is
     * uploaded using the `uploadUserProfileImage`
     * 
     * @return a redirect response. If the user profile is successfully updated, it redirects to the
     * 'gymUserList' route with a success message. If there is an error during the update process, it
     * redirects back with an error message.
     */
    public function updateAdminUser(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'uuid' => 'required',
                'user_type' => 'required',
                'gym_id' => 'required',
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
                $imagePath = $this->userService->uploadUserProfileImage($request->file('image'));
            }

            $isProfileUpdated = $this->user->updateUser($validatedData, $imagePath);



            if ($isProfileUpdated) {
                return redirect()->route('gymUserList')->with('status', 'success')->with('message', 'User updated successfully.');
            }
            return redirect()->back()->with('status', 'error')->with('message', 'error while updating user.');
        } catch (\Exception $e) {
            Log::error('[AdminUserController][updateAdminUser] Error updating user ' . 'Request=' . $request . ', Exception=' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'error while updating user.');
        }
    }

    /**
     * The function `addAdminWorkout` in PHP validates and saves workout data, handling errors if any
     * occur.
     * 
     * @param Request request The `addAdminWorkout` function is a PHP function that receives a `Request`
     * object as a parameter. The function attempts to validate the data in the request using specific
     * rules for each field. If the validation is successful, it calls the `addWorkout` method of the
     * `
     * 
     * @return The function `addAdminWorkout` is returning a redirect back to the previous page with a
     * success message if the workout data is saved successfully. If there is an error during the
     * process, it will log the error message and return a redirect back to the previous page with an
     * error message.
     */
    public function addAdminWorkout(Request $request)
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

    /**
     * The function `addAdminDiet` validates and saves diet data for a user, handling errors and logging
     * if necessary.
     * 
     * @param Request request The `addAdminDiet` function is used to add a new diet entry for a user
     * with the provided data. Here is an explanation of the parameters being validated in the
     * `` array:
     * 
     * @return The function `addAdminDiet` is returning a redirect back to the previous page with a
     * success message 'Diet data saved successfully.' if the data validation and saving process is
     * successful. If an error occurs during the process, it will log the error message and return a
     * redirect back to the previous page with an error message 'Failed to save workout data. Please try
     * again.'
     */
    public function addAdminDiet(Request $request)
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

    public function updateAdminWorkout(Request $request)
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

    public function updateAdminDiet(Request $request)
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

    public function UserBodyMeasurement(Request $request)
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
            Log::error("[AdminUserController][UserBodyMeasurement] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
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
