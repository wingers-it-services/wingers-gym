<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\GymStaff;
use App\Models\userBmi;
use App\Models\Gym;
use App\Models\GymSubscription;
use App\Models\GymUserSubscriptionsHistory;
use App\Models\User;
use App\Models\UserBodyMeasurement;
use App\Models\UserWorkout;
use App\Models\UserDiet;
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
    protected $userHistory;

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
        UserSubscriptionHistory $userHistory
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
        $this->userHistory = $userHistory;
    }

    public function listGymUser()
    {
        $gymUser = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;
        $users = $this->user->where('gym_id', $gymId)->get();
        return view('GymOwner.gym-customers', compact('users'));
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
                'firstname'         => 'required',
                'lastname'          => 'required',
                'email'             => 'required|unique:gym_users,email',
                'gender'            => 'required',
                'subscription_id'   => 'required',
                'blood_group'       => 'nullable',
                'joining_date'      => 'required|date',
                'address'           => 'required',
                'country'           => 'required',
                'state'             => 'required',
                'zip_code'          => 'required',
                'image'             => 'required',
                'end_date'          => 'required',
                'coupon_id'         => 'nullable',
                'subscription_status'  => 'nullable',
                'profile_status'       => 'nullable',
                'staff_assign_id'      => 'nullable',
                'password'             => 'required'
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
                'joining_date' => $request->joining_date,
                'end_date' => $request->end_date,
                'status' => $user->subscription_status,
                'amount' => $request->amount, // Ensure this is part of the request or calculate it
                'coupon_id' => 2,
                'gym_id' => $gymId
            ]);

            return redirect()->route('gymCustomerList')->with('status', 'success')->with('message', 'User Added Successfully');
        } catch (\Exception $e) {
            Log::error('[GymUserController][addUserByGym] Error adding user: ' . $e->getMessage());
            return back()->with('status', 'error')->with('message', 'User Not Added');
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

        $subscriptionId = $userDetail->subscription_id;
        $userSubscriptions = $this->userHistory->where('gym_id', $gymId)->where('user_id', $userId)->get();
        $bmis = $this->bmi->with('bodyMeasurement')->where('gym_id', $gymId)->where('user_id', $userId)->get();
        $bodyMeasurement = $this->userBodyMeasurement->where('gym_id', $gymId)->where('user_id', $userId)->get();
        $trainers = $this->gymStaff->where('gym_id', $gymId)->where('designation_id', 1)->get();

        return view('GymOwner.view-gym-customer-details', compact('userDetail',  'designations', 'gymSubscriptions', 'userSubscriptions', 'workouts', 'diets', 'bmis', 'trainers', 'bodyMeasurement'));
    }

    public function updateUser(Request $request)
    {
        try {
            $request->validate([
                'email' => 'nullable',
                'member_number'     => 'required',
                'employee_id'       => 'required',
                'subscription_id'   => 'required',
                'blood_group'       => 'nullable',
                'joining_date'      => 'required',
                'address'           => 'required',
                'country'           => 'required',
                'state'             => 'required',
                'zip_code'          => 'required',
                'image'             => 'nullable'
            ]);

            $gymUser = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;

            $isProfileUpdated = $this->userService->createUserAccount($request->all(), $gymId);

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
                "user_id" => 'required',
                "meal_name" => 'required',
                "calories" => 'required|integer|min:0',
                "protein" => 'required|integer|min:0',
                "carbs" => 'required|numeric|min:0',
                "fats" => 'required|numeric|min:0',
                "notes" => 'required',
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
                'user_id' => 'required',
                'workout_id' => 'required',
                'exercise_name' => 'required',
                'sets' => 'required|integer|min:1',
                'reps' => 'required|integer|min:1',
                'weight' => 'required|numeric|min:0',
                'notes' => 'required',
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
                'diet_id' => 'required',
                'user_id' => 'required',
                'meal_name' => 'required',
                "calories" => 'required|integer|min:0',
                "protein" => 'required|integer|min:0',
                "carbs" => 'required|numeric|min:0',
                "fats" => 'required|numeric|min:0',
                "notes" => 'nullable|string',
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

    public function deleteWorkout($uuid)
    {
        $workout = $this->workout->where('uuid', $uuid)->firstOrFail();

        $workout->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'Workout deleted successfully!');
    }

    public function deleteDiet($uuid)
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
                "staff_assign_id" => 'required',
                "user_id" => 'required'
            ]);

            $this->user->addTrainer($validatedData);

            return redirect()->back()->with('status', 'success')->with('message', 'Trainer Alloted succesfully.');
        } catch (Throwable $th) {
            Log::error("[GymUserController][allocateTrainerToUser] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Failed to allocate trainer. Please try again.');
        }
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
        $subscriptionHistory = $this->userHistory->where('user_id', $userId)->latest()->update(['status' => 0]);

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
                'joining_date' => 'required|date',
                'amount' => 'required|numeric',
                'end_date' => 'required|date',
                'description' => 'required|string',
            ]);

            // Fetch user subscription status
            $userSubscription = $this->userHistory->where('user_id', $validatedData['user_id'])
                ->orderBy('end_date', 'desc')
                ->first();

            // Check if user already has an active subscription
            if ($userSubscription && $userSubscription->status == 1 && $userSubscription->end_date > now()) {
                // If subscription is active, return an error message with SweetAlert
                return redirect()->back()->with('status', 'error')->with('message', 'User already has an active subscription until ' . $userSubscription->end_date);
            }

            // Fetch subscription details
            $subscription = $this->gymSubscription->find($validatedData['subscription_id']);

            // Create user subscription history
            $this->userHistory->create([
                'gym_id' => $gymId,
                'original_transaction_id' => 1,
                'user_id' => $validatedData['user_id'],
                'subscription_id' => $subscription->id,
                'joining_date' => $validatedData['joining_date'],
                'end_date' => $validatedData['end_date'],
                'amount' => $validatedData['amount'],
                'status' => 1,
                'coupon_id' => 2,
                'description' => $validatedData['description'],
            ]);

            return redirect()->back()
                ->with('status', 'success')
                ->with('message', 'Subscription added successfully');
        } catch (Throwable $th) {
            Log::error("[GymSubscriptionController][addUserSubscription] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $th->getMessage());
        }
    }


    public function autocompleteWorkout(Request $request)
    {
        $gymUser = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;
        $query = $request->get('query');
        $workouts = Workout::where('name', 'LIKE', "%{$query}%")->where('added_by', $gymId)->pluck('name');

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
}
