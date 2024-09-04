<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Diet;
use App\Models\GymStaff;
use App\Models\userBmi;
use App\Models\Gym;
use App\Models\GymSubscription;
use App\Models\GymUserSubscriptionsHistory;
use App\Models\User;
use App\Models\UserBodyMeasurement;
use App\Models\UserWorkout;
use App\Models\UserDiet;
use App\Models\UsersTrainerHistry;
use App\Models\UserSubscriptionHistory;
use App\Models\Workout;
use App\Services\UserService;
use App\Traits\SessionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    protected $designation;
    protected $gymSubscription;
    protected $userSubscriptionHistory;
    protected $trainersHistory;

    public function __construct(
        User $user,
        Gym $gym,
        UserWorkout $workout,
        UserDiet $diet,
        UserService $userService,
        UserBodyMeasurement $userBodyMeasurement,
        userBmi $bmi,
        GymStaff $gymStaff,
        Designation $designation,
        GymSubscription $gymSubscription,
        UserSubscriptionHistory $userSubscriptionHistory,
        UsersTrainerHistry $trainersHistory
    ) {
        $this->user = $user;
        $this->gym = $gym;
        $this->workout = $workout;
        $this->diet = $diet;
        $this->userService = $userService;
        $this->userBodyMeasurement = $userBodyMeasurement;
        $this->bmi = $bmi;
        $this->gymStaff = $gymStaff;
        $this->designation = $designation;
        $this->gymSubscription = $gymSubscription;
        $this->userSubscriptionHistory = $userSubscriptionHistory;
        $this->trainersHistory = $trainersHistory;
    }

    public function listGymUser()
    {
        $gymUser = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;
        $users = $this->user->where('gym_id', $gymId)->get();
        return view('GymOwner.gym-customers', compact('users'));
    }

    public function listGymUserSubscriptions()
    {
        $gymUser = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;
        $users = $this->user->where('gym_id', $gymId)->get();
        // Iterate over each user and calculate the remaining days
        foreach ($users as $user) {
            $start_date = strtotime($user->subscription_start_date);
            $end_date = strtotime($user->subscription_end_date);
            $current_date = strtotime(date('Y-m-d'));

            // Calculate the difference in days between the current date and the end date
            $user->remaining_days = ($end_date - $current_date) / (60 * 60 * 24);
        }
        return view('GymOwner.gym-customers-subscriptions', compact('users'));
    }

    public function customersAttendance()
    {
        $gym = Auth::guard('gym')->user();
        $gymStaffs = $this->user->where('gym_id', $gym->id)->get();
        return view('GymOwner.customers-attendance', compact('gymStaffs'));
    }

    public function addGymUser()
    {
        $gymUser = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;

        $gymStaff = GymStaff::join('designations', 'designations.id', 'gym_staffs.designation_id')
            ->where('gym_staffs.gym_id', $gymId)->get();
        $gymSubscriptions = $this->gymSubscription->where('gym_id', $gymId)->get();

        return view('GymOwner.add-gym-customer', compact('gymStaff', 'gymSubscriptions'));
    }

    public function addUserByGym(Request $request)
    {
        try {
            $validateData = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|unique:gym_users,email',
                'gender' => 'required',
                'subscription_id' => 'required',
                'blood_group' => 'nullable',
                'joining_date' => 'required|date',
                'address' => 'required',
                'country' => 'required',
                'state' => 'required',
                'zip_code' => 'required',
                'image' => 'required',
                'subscription_end_date' => 'required',
                'subscription_start_date' => 'required',
                'coupon_id' => 'nullable',
                'subscription_status' => 'nullable',
                'profile_status' => 'nullable',
                'staff_assign_id' => 'nullable',
                'password' => 'required',
                'phone_no' => 'required|unique:gym_users,phone_no'
            ]);

            $gymUser = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;

            $user = $this->userService->createUserAccount($validateData, $gymId);

            // Create the user account
            if ($user) {
                $user = User::where('email', $validateData['email'])->first(); // Adjust the query as needed
            }

            // Save to user_subscription_histories
            UserSubscriptionHistory::create([
                'user_id' => $user->id,
                'subscription_id' => $request->subscription_id,
                'original_transaction_id' => 1, // Assuming you have this value, or you may need to adjust
                'subscription_start_date' => $request->subscription_start_date,
                'subscription_end_date' => $request->subscription_end_date,
                'status' => $user->subscription_status,
                'amount' => $request->amount, // Ensure this is part of the request or calculate it
                'coupon_id' => 2,
                'gym_id' => $gymId
            ]);

            return redirect()->route('gymCustomerList')->with('status', 'success')->with('message', 'User Added Successfully');
        } catch (\Exception $e) {
            Log::error('[GymUserController][addUserByGym] Error adding user: ' . $e->getMessage());
            return back()->with('status', 'error')->with('message', 'User Not Added' . $e->getMessage());
        }
    }


    public function showUserProfile($uuid)
    {
        $userDetail = $this->user->where('uuid', $uuid)->first();
        $gymUser = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;
        $userId = $userDetail->id;
        $designations = $this->designation->get();
        $workouts = $this->workout->where('gym_id', $gymId)->where('user_id', $userId)->get();
        $diets = $this->diet->where('gym_id', $gymId)->where('user_id', $userId)->get();
        $gymSubscriptions = $this->gymSubscription->where('gym_id', $gymId)->get();
        $bmis = $this->bmi->with('bodyMeasurement')->where('gym_id', $gymId)->where('user_id', $userId)->get();
        $subscriptionId = $userDetail->subscription_id;
        $userSubscriptions = $this->userSubscriptionHistory->where('gym_id', $gymId)->where('user_id', $userId)->get();
        $trainers = $this->gymStaff
            ->where('gym_id', $gymId)
            ->whereHas('designation', function ($query) {
                $query->where('is_assigned_to_member', 1);
            })
            ->get();
        $trainersHistories = $this->trainersHistory->where('gym_id', $gymId)->where('user_id', $userId)->get();

        return view('GymOwner.view-gym-customer-details', compact('userDetail', 'designations', 'gymSubscriptions', 'userSubscriptions', 'workouts', 'diets', 'trainers', 'bmis', 'trainersHistories'));
    }

    public function viewUpdateUser(Request $request, $uuid)
    {

        $userDetail = $this->user->where('uuid', $uuid)->first();

        $gym = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;
        $gymStaff = GymStaff::join('designations', 'designations.id', 'gym_staffs.designation_id')
            ->where('gym_staffs.gym_id', $gymId)->get();
        $gymSubscriptions = $this->gymSubscription->where('gym_id', $gymId)->get();
        $selectedSubscriptionId = $userDetail->subscription_id;

        return view('GymOwner.edit-gym-customer', compact('userDetail', 'gymStaff', 'gymSubscriptions', 'selectedSubscriptionId'));
    }

    public function updateUser(Request $request, $uuid)
    {
        try {
            $user = $this->user->where('uuid', $uuid)->first();

            $request->validate([
                'email' => 'required',
                'gender' => 'required',
                'blood_group' => 'nullable',
                'address' => 'required',
                'country' => 'required',
                'state' => 'required',
                'zip_code' => 'required',
                'image' => 'nullable',
                'staff_assign_id' => 'nullable',
                'password' => 'required',
                'joining_date' => 'required'
            ]);

            $gymUser = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;

            if (isset($request->image)) {
                // Delete existing image only if a new one is provided
                if ($user->image) {
                    $oldImagePath = public_path($user->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                // Upload the new image
            }

            $isProfileUpdated = $this->userService->createUserAccount($request->all(), $gymId);

            if ($isProfileUpdated) {
                return redirect()->back()->with('status', 'success')->with('message', 'User updated successfully.');
            }
            return redirect()->route('listGymUser')->with('status', 'error')->with('message', 'error while updating user.');
        } catch (\Exception $e) {
            Log::error('[GymUserController][updateUser] Error updating user ' . 'Request=' . $request . ', Exception=' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'error while updating user.' . $e->getMessage());
        }
    }

    public function addUserWorkout(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "user_id"       => 'required',
                "exercise_name" => 'required',
                "day"           => 'required',
                "sets"          => 'required|integer|min:1',
                "reps"          => 'required|integer|min:1',
                "weight"        => 'required|numeric|min:0',
                "workout_des"   => 'required',
                "workout_id"    => 'required'
            ]);

            $gymUser = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;

            $this->workout->addWorkout($validatedData, $gymId);

            return redirect()->back()->with('status', 'success')->with('message', 'Workout data saved successfully.');
        } catch (Throwable $th) {
            Log::error("[GymUserController][addUserWorkout] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Failed to save workout data. Please try again.');
        }
    }


    public function addUserDiet(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "user_id"                       => 'required',
                "meal_name"                     => 'required',
                "calories"                      => 'required|integer|min:0',
                "protein"                       => 'required|integer|min:0',
                "carbs"                         => 'required|numeric|min:0',
                "fats"                          => 'required|numeric|min:0',
                "diet_id"                       => 'required',
                "goal"                          => 'required',
                "meal_type"                     => 'required',
                "diet_description"              => 'required',
                "alternative_diet_description"  => 'required',
                "day"                           => 'required'
            ]);

            $gymUser = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;

            $this->diet->addUserDiet($validatedData, $gymId);

            return redirect()->back()->with('status', 'success')->with('message', 'Diet data saved successfully.');
        } catch (Throwable $th) {
            Log::error("[GymUserController][addUserDiet] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Failed to save workout data. Please try again.');
        }
    }

    public function updateUserWorkout(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'user_id'       => 'required',
                'workout_id'    => 'required',
                'day'           => 'required',
                'exercise_name' => 'required',
                'sets'          => 'required|integer|min:1',
                'reps'          => 'required|integer|min:1',
                'weight'        => 'required|numeric|min:0',
                'workout_des'   => 'required',
            ]);

            $workout = $this->workout->findOrFail($request->workout_id);
            $workout->update($validatedData);

            // Redirect back with a success message
            return redirect()->back()->with('status', 'success')->with('message', 'Workout updated successfully.');
        } catch (Throwable $th) {
            Log::error("[GymUserController][updateUserWorkout] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Failed to update workout data. Please try again.');
        }
    }

    public function updateUserDiet(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'diet_id'                       => 'required',
                'user_id'                       => 'required',
                'meal_name'                     => 'required',
                "calories"                      => 'required|integer|min:0',
                "protein"                       => 'required|integer|min:0',
                "carbs"                         => 'required|numeric|min:0',
                "fats"                          => 'required|numeric|min:0',
                "goal"                          => 'required',
                "meal_type"                     => 'required',
                "diet_description"              => 'required',
                "alternative_diet_description"  => 'required',
                "day"                           => 'required'
            ]);

            // Find the workout by ID
            $diet = $this->diet->findOrFail($request->diet_id);
            $diet->update($validatedData);

            // Redirect back with a success message
            return redirect()->back()->with('status', 'success')->with('message', 'Diet updated successfully.');
        } catch (Throwable $th) {
            Log::error("[GymUserController][updateUserDiet] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Failed to update workout data. Please try again.');
        }
    }

    public function deleteUserWorkout($uuid)
    {
        $workout = $this->workout->where('uuid', $uuid)->firstOrFail();

        $workout->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'Workout deleted successfully!');
    }

    public function deleteUserDiet($uuid)
    {
        $diet = $this->diet->where('uuid', $uuid)->firstOrFail();

        $diet->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'Diet deleted successfully!');
    }

    public function deleteGymUser($uuid)
    {
        $user = $this->user->where('uuid', $uuid)->firstOrFail();

        $user->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'User deleted successfully!');
    }

    public function allocateTrainerToUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "trainer_id" => 'required',
                "user_id" => 'required',
                "status" => 'required'
            ]);

            $gymUser = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;

            $activeTrainer = $this->trainersHistory->where([
                ['user_id', '=', $validatedData['user_id']],
                ['status', '=', \App\Enums\TrainerAssignToUserStatus::ACTIVE],
            ])->first();

            if ($activeTrainer) {
                return redirect()->back()->with('status', 'error')->with('message', 'A trainer is already allocated to this user.');
            }
            $this->trainersHistory->addTrainer($validatedData, $gymId);

            return redirect()->back()->with('status', 'success')->with('message', 'Trainer Alloted succesfully.');
        } catch (Throwable $th) {
            Log::error("[GymUserController][allocateTrainerToUser] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Failed to allocate trainer. Please try again.' . $th->getMessage());
        }
    }

    public function deleteTrainer($uuid)
    {
        $trainer = $this->trainersHistory->where('uuid', $uuid)->firstOrFail();

        $trainer->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'Trainer deleted successfully!');
    }

    public function checkSubscription(Request $request, $userId)
    {
        // Check if the user has an existing subscription
        $existingSubscription = UserSubscriptionHistory::where('user_id', $userId)->latest()->first();

        if ($existingSubscription) {
            return response()->json([
                'status' => 'exists',
                'message' => 'The user already has an existing subscription.',
                'end_date' => $existingSubscription->end_date
            ]);
        } else {
            // Create a new subscription
            $subscription = UserSubscriptionHistory::create([
                'user_id' => $userId,
                'subscription_id' => $request->subscription_id,
                'original_transaction_id' => 1, // Assuming you have this value, or you may need to adjust
                'joining_date' => $request->joining_date,
                'end_date' => $request->end_date,
                'status' => 2,
                'amount' => $request->amount, // Ensure this is part of the request or calculate it
                'coupon_id' => 2,
            ]);

            return response()->json([
                'status' => 'created',
                'message' => 'Subscription added successfully!',
                'subscription' => $subscription
            ]);
        }
    }

    public function updateSubscription(Request $request, $userId)
    {
        // Inactivate the existing subscription in UserSubscriptionHistory table
        $subscriptionHistory = $this->userSubscriptionHistory->where('user_id', $userId)->latest()->update(['status' => 0]);

        // Update the subscription details in gym_users table
        User::where('user_id', $userId)->update([
            'subscription_id' => $request->subscription_id,
            'joining_date' => $request->joining_date,
            'end_date' => $request->end_date,
            'amount' => $request->amount,
            'status' => 2 // Assuming this status column exists in the gym_users table as well
        ]);

        // Create a new entry in the UserSubscriptionHistory table
        $subscription = UserSubscriptionHistory::create([
            'user_id' => $userId,
            'subscription_id' => $request->subscription_id,
            'original_transaction_id' => 1, // Assuming you have this value, or you may need to adjust
            'joining_date' => $request->joining_date,
            'end_date' => $request->end_date,
            'status' => 2,
            'amount' => $request->amount, // Ensure this is part of the request or calculate it
            'coupon_id' => 2,
        ]);

        return response()->json([
            'status' => 'updated',
            'message' => 'Subscription updated successfully!',
            'subscription' => $subscription
        ]);
    }

    public function addUserSubscriptionByGym(Request $request)
    {
        try {
            $gymUser = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;

            $validatedData = $request->validate([
                'user_id' => 'required',
                'subscription_id' => 'required|exists:gym_subscriptions,id',
                'subscription_start_date' => 'required|date',
                'amount' => 'required|numeric',
                'subscription_end_date' => 'required|date',
                'description' => 'required|string',
            ]);

            // Fetch user subscription status
            $userSubscription = $this->userSubscriptionHistory->where('user_id', $validatedData['user_id'])
                ->orderBy('subscription_end_date', 'desc')
                ->first();

            // Check if user already has an active subscription
            if ($userSubscription && $userSubscription->status == 1 && $userSubscription->end_date > now()) {
                // If subscription is active, return an error message with SweetAlert
                return redirect()->back()->with('status', 'error')->with('message', 'User already has an active subscription until ' . $userSubscription->end_date);
            }

            // Fetch subscription details
            $subscription = $this->gymSubscription->find($validatedData['subscription_id']);

            // Create user subscription history
            $this->userSubscriptionHistory->create([
                'gym_id' => $gymId,
                'original_transaction_id' => 1,
                'user_id' => $validatedData['user_id'],
                'subscription_id' => $subscription->id,
                'subscription_start_date' => $validatedData['subscription_start_date'],
                'subscription_end_date' => $validatedData['subscription_end_date'],
                'amount' => $validatedData['amount'],
                'status' => 1,
                'coupon_id' => 2,
                'description' => $validatedData['description'],
            ]);

            return redirect()->back()
                ->with('status', 'success')
                ->with('message', 'Subscription added successfully');
        } catch (Throwable $th) {
            Log::error("[GymUserController][addUserSubscription] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $th->getMessage());
        }
    }

    public function autocompleteWorkout(Request $request)
    {
        $gymUser = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;
        $query = $request->get('query');

        // Fetch both name and id
        $workouts = Workout::where('name', 'LIKE', "%{$query}%")
            ->where('added_by', $gymId)
            ->get(['id', 'name']);

        return response()->json($workouts);
    }


    public function fetchWorkoutDetails(Request $request)
    {
        $exerciseName = $request->input('exercise_name');
        $workout = Workout::where('name', $exerciseName)->first();

        if ($workout) {
            return response()->json([
                'image' => asset($workout->image),
                'gender' => $workout->gender,
                'category' => $workout->category,
                'vedio_link' => $workout->vedio_link,
                'description' => $workout->description
            ]);
        } else {
            return response()->json(null);
        }
    }

    public function getUserBmi($bmiId)
    {
        $bmi = $this->bmi->where('id', $bmiId)->first();

        $bodyMeasurement = $this->userBodyMeasurement->where('bmi_id', $bmiId)->first();

        if ($bmi && $bodyMeasurement) {
            return response()->json([
                'success' => true,
                'bmi' => $bmi,
                'bodyMeasurement' => $bodyMeasurement,
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function autocompleteDiet(Request $request)
    {
        $gymUser = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;
        $query = $request->get('query');
        $workouts = Diet::where('name', 'LIKE', "%{$query}%")->where('gym_id', $gymId)->pluck('name');

        return response()->json($workouts);
    }

    public function fetchDietDetails(Request $request)
    {
        $goal = $request->input('goal');
        // $gender = $request->input('gender');
        $mealType = $request->input('meal_type');
        $mealName = $request->input('meal_name');

        // Query to match the diet based on the provided filters
        $diet = Diet::where('goal', $goal)
            ->where('meal_type', $mealType)
            ->where('name', $mealName)
            ->first();

        if ($diet) {
            return response()->json([
                'image' => asset($diet->image),
                'id'     => $diet->id,
                'calories' => $diet->calories,
                'protein' => $diet->protein,
                'carbs' => $diet->carbs,
                'fats' => $diet->fats,
                'diet' => $diet->diet,
                'alternative_diet' => $diet->alternative_diet,
                'goal' => $diet->goal
                // 'gender' => $diet->gender
            ]);
        } else {
            return response()->json(null);
        }
    }




    public function updateSubscriptionStatus(Request $request, $user_id)
    {
        try {
            // Validate the status input
            $validatedData = $request->validate([
                'status' => 'required|integer|in:0,1,2',
            ]);


            // Find the latest subscription history entry by user_id
            $subscriptionHistory = $this->userSubscriptionHistory
                ->where('user_id', $user_id)
                ->orderBy('subscription_end_date', 'desc')
                ->first();

            if (!$subscriptionHistory) {
                return redirect()->back()->with('status', 'error')->with('message', 'No subscription history found for the user.');
            }

            // Update the status
            $subscriptionHistory->update([
                'status' => $validatedData['status']
            ]);

            return redirect()->back()->with('status', 'success')->with('message', 'Subscription status updated successfully');
        } catch (Throwable $th) {
            Log::error("[GymUserController][updateSubscriptionStatus] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Failed to update subscription status. Please try again.' . $th->getMessage());
        }
    }

    public function deleteSubcriptionHistory($uuid)
    {
        $subHistory = $this->userSubscriptionHistory->where('uuid', $uuid)->firstOrFail();

        $subHistory->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'User Subscription History deleted successfully!');
    }

    public function updateTrainerStatus(Request $request, $user_id)
    {
        try {
            // Validate the status input
            $validatedData = $request->validate([
                'status' => 'required|integer|in:0,1',
                'trainer_id' => 'required', // Ensure trainer_id is provided and valid
            ]);

            // If the status is set to ACTIVE
            if ($validatedData['status'] == \App\Enums\TrainerAssignToUserStatus::ACTIVE) {
                // Check if there is already an active trainer for the user
                $activeTrainer = $this->trainersHistory
                    ->where('user_id', $user_id)
                    ->where('status', \App\Enums\TrainerAssignToUserStatus::ACTIVE)
                    ->first();

                if ($activeTrainer) {
                    return redirect()->back()->with('status', 'error')->with('message', 'Another trainer is already active. Please deactivate the existing trainer before assigning a new one.');
                }

                // Deactivate all other trainers for the user (optional, if you want to enforce single active trainer)
                $this->trainersHistory->where('user_id', $user_id)
                    ->where('status', \App\Enums\TrainerAssignToUserStatus::ACTIVE)
                    ->update(['status' => \App\Enums\TrainerAssignToUserStatus::INACTIVE]);
            }

            // Find the specific trainer history entry
            $trainerHistory = $this->trainersHistory
                ->where('user_id', $user_id)
                ->where('id', $validatedData['trainer_id']) // Ensure the trainer_id is provided in the request
                ->first();

            if (!$trainerHistory) {
                return redirect()->back()->with('status', 'error')->with('message', 'Trainer not found for the user.');
            }

            // Update the status
            $trainerHistory->update([
                'status' => $validatedData['status']
            ]);

            return redirect()->back()->with('status', 'success')->with('message', 'Trainer status updated successfully.');
        } catch (Throwable $th) {
            Log::error("[GymUserController][updateTrainerStatus] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Failed to update trainer status. Please try again.' . $th->getMessage());
        }
    }

    public function fetchUserDetails(Request $request)
    {
        $email = $request->query('email');
        $phone_no = $request->query('phone_no');

        // Build the query
        $query = User::query();

        if ($email) {
            $query->where('email', $email);
        }

        if ($phone_no) {
            $query->orWhere('phone_no', $phone_no);
        }

        // Fetch all users that match the criteria
        $users = $query->get();

        if ($users->isNotEmpty()) {
            return response()->json(['success' => true, 'users' => $users]);
        } else {
            return response()->json(['success' => false, 'message' => 'User not found.']);
        }
    }


}
