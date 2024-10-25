<?php

namespace App\Http\Controllers;

use App\Enums\GymSubscriptionStatusEnum;
use App\Models\Designation;
use App\Models\Diet;
use App\Models\Goal;
use App\Models\GymStaff;
use App\Models\userBmi;
use App\Models\Gym;
use App\Models\GymSubscription;
use App\Models\GymUserAttendence;
use App\Models\GymUserGym;
use App\Models\GymWeekend;
use App\Models\Holiday;
use App\Models\User;
use App\Models\UserBodyMeasurement;
use App\Models\UserSubscriptionPayment;
use App\Models\UserWorkout;
use App\Models\UserDiet;
use App\Models\UsersTrainerHistry;
use App\Models\UserSubscriptionHistory;
use App\Models\Workout;
use App\Services\UserService;
use App\Traits\SessionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
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
    protected $gymUserAttendance;
    protected $customerPayments;

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
        UsersTrainerHistry $trainersHistory,
        GymUserAttendence $gymUserAttendance,
        UserSubscriptionPayment $customerPayments
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
        $this->trainersHistory = $trainersHistory;
        $this->gymUserAttendance = $gymUserAttendance;
        $this->customerPayments = $customerPayments;
    }

    public function listGymUser()
    {
        $gymUser = Auth::guard('gym')->user();
        $users = $gymUser->users;
        return view('GymOwner.gym-customers', compact('users'));
    }

    public function listGymUserSubscriptions()
    {
        $gymUser = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;
        // Fetch users with their subscription data (including trashed)
        $users = $this->userSubscriptionHistory->with([
            'users' => function ($query) {
                $query->withTrashed();
            }, // Assuming 'users' is the name of a relationship
            'subscription' => function ($query) {
                $query->withTrashed();
            }
        ])->where('gym_id', $gymId)
            ->where('status', '1') // Assuming status '1' means active
            ->get();

        // Calculate remaining days for each subscription
        foreach ($users as $user) {
            if ($user->subscription_end_date) {
                $endDate = Carbon::parse($user->subscription_end_date);
                $daysRemaining = (int) now()->diffInDays($endDate, false); // Force integer cast
                $user->remaining_days = $daysRemaining >= 0 ? $daysRemaining : 0;
            } else {
                $user->remaining_days = null; // No end date, so no remaining days
            }
        }
        return view('GymOwner.gym-customers-subscriptions', compact('users'));
    }

    public function customersAttendance()
    {
        $gym = Auth::guard('gym')->user();
        $gymUsers = $gym->users;
        return view('GymOwner.customers-attendance', compact('gymUsers'));
    }

    public function addGymUser()
    {
        $gymUser = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;

        $goals = Goal::get();

        $gymStaff = GymStaff::join('designations', 'designations.id', 'gym_staffs.designation_id')
            ->where('gym_staffs.gym_id', $gymId)->get();
        $gymSubscriptions = $this->gymSubscription->where('gym_id', $gymId)->get();

        return view('GymOwner.add-gym-customer', compact('gymStaff', 'gymSubscriptions', 'goals'));
    }

    public function viewCustomerPayment()
    {
        $gymUser = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;
        $customerPayments = $this->customerPayments
            ->with([
                'subscription' => function ($query) {
                    $query->withTrashed();
                }
            ])->where('gym_id', $gymId)->orderBy('created_at', 'desc')->get();

        return view('GymOwner.customers-payment', compact('customerPayments'));
    }

    public function addUserByGym(Request $request)
    {
        try {
            $validateData = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'gender' => 'required',
                'subscription_id' => 'required',
                'blood_group' => 'nullable',
                'joining_date' => 'required|date',
                'address' => 'required',
                'country' => 'required',
                'state' => 'required',
                'zip_code' => 'required',
                'image' => 'nullable',
                'subscription_end_date' => 'required',
                'subscription_start_date' => 'required',
                'coupon_id' => 'nullable',
                'subscription_status' => 'nullable',
                'staff_assign_id' => 'nullable',
                'password' => 'required',
                'phone_no' => 'required',
                'dob' => 'required',
                'city' => 'required'
            ]);


            $today = Carbon::today();  // This sets the date to today without the time part
            $subscriptionStartDate = Carbon::parse($request->subscription_start_date);

            $status = ($subscriptionStartDate->greaterThanOrEqualTo($today)) ? GymSubscriptionStatusEnum::ACTIVE : GymSubscriptionStatusEnum::INACTIVE;

            $gymId = Auth::guard('gym')->user()->id;

            if ($request->filled('user_id')) {
                // If user_id is present, update the existing user
                $user = User::findOrFail($request->user_id);
                $imagePath = $user->image; // Default to existing image path

                if ($request->hasFile('image')) {
                    // Delete the existing image if it exists
                    if ($user->image) {
                        $existingImagePath = public_path($user->image);
                        if (file_exists($existingImagePath)) {
                            unlink($existingImagePath);
                        }
                    }

                    // Handle new image upload
                    $imageFile = $request->file('image');
                    $filename = time() . '_' . $imageFile->getClientOriginalName();
                    $imagePath = 'user_images/' . $filename;

                    // Move the image file to the public directory
                    if (!$imageFile->move(public_path('user_images'), $filename)) {
                        return back()->with('status', 'error')->with('message', 'Image upload failed');
                    }
                }

                // Update the user data, but only include 'image' if a new image was uploaded
                $updateData = $validateData;
                // unset($updateData['profile_status']);
                if ($request->hasFile('image')) {
                    $updateData['image'] = $imagePath;
                }

                $user->update($updateData);

                // Check if the user is already associated with this gym
                $existingGymUser = GymUserGym::where('user_id', $user->id)
                    ->where('gym_id', $gymId)
                    ->first();

                if ($existingGymUser) {
                    return redirect()->back()->with('status', 'error')->with('message', 'This user is already associated with this gym.');
                }

                // Associate the user with the gym
                GymUserGym::create([
                    'gym_id' => $gymId,
                    'user_id' => $user->id
                ]);
                // Update or create the user subscription history
                UserSubscriptionHistory::create([
                    'user_id' => $user->id,
                    'subscription_id' => $request->subscription_id,
                    'original_transaction_id' => 1, // Assuming you have this value, or you may need to adjust
                    'subscription_start_date' => $request->subscription_start_date,
                    'subscription_end_date' => $request->subscription_end_date,
                    'status' => $status,
                    'amount' => $request->amount, // Ensure this is part of the request or calculate it
                    'coupon_id' => $request->coupon_id,
                    'gym_id' => $gymId
                ]);
            } else {
                // If no user_id, create a new user
                $userCreated = $this->userService->createUserAccount($validateData, $gymId);


                // Create the user account
                if ($userCreated) {
                    $adminGym = $this->gym->where('gym_type', 'admin')->first();
                    $user = User::where('email', $validateData['email'])->first(); // Adjust the query as needed
                    GymUserGym::firstOrCreate([
                        'user_id' => $user->id,
                        'gym_id' => $gymId,
                    ]);
                    GymUserGym::firstOrCreate([
                        'user_id' => $user->id,
                        'gym_id' => $adminGym->id, // Home gym ID
                    ]);

                    // Save to user_subscription_histories
                    UserSubscriptionHistory::create([
                        'user_id' => $user->id,
                        'subscription_id' => $request->subscription_id,
                        'original_transaction_id' => 1, // Adjust as necessary
                        'subscription_start_date' => $request->subscription_start_date,
                        'subscription_end_date' => $request->subscription_end_date,
                        'status' => $status,
                        'amount' => $request->amount, // Ensure this is part of the request or calculate it
                        'coupon_id' => $request->coupon_id,
                        'gym_id' => $gymId
                    ]);
                }
            }

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
        $userSubscriptions = $this->userSubscriptionHistory->with([
            'subscription' => function ($query) {
                $query->withTrashed();
            }
        ])->where('gym_id', $gymId)->where('user_id', $userId)->get();
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
            $updatedData = $request->except(['profile_status']);
            $isProfileUpdated = $this->userService->createUserAccount($updatedData, $gymId);

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
                "user_id" => 'required',
                "exercise_name" => 'required',
                "day" => 'required',
                "sets" => 'required|integer|min:1',
                "reps" => 'required|integer|min:1',
                "weight" => 'required|numeric|min:0',
                "workout_des" => 'required',
                "workout_id" => 'required',
                "targeted_body_part" => 'required'
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
                "diet_id" => 'required',
                "goal" => 'required',
                "meal_type" => 'required',
                "diet_description" => 'required',
                "alternative_diet_description" => 'nullable',
                "day" => 'required'
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
                'day' => 'required',
                'exercise_name' => 'required',
                'sets' => 'required|integer|min:1',
                'reps' => 'required|integer|min:1',
                'weight' => 'required|numeric|min:0',
                'workout_des' => 'required',
                'targeted_body_part' => 'required',
            ]);

            $workout = $this->workout->findOrFail($request->id);
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
                "goal" => 'required',
                "meal_type" => 'required',
                "diet_description" => 'required',
                "alternative_diet_description" => 'required',
                "day" => 'required'
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

            // Fetch the latest subscription history for the user
            $userSubscription = $this->userSubscriptionHistory->where('user_id', $validatedData['user_id'])
                ->where('status', GymSubscriptionStatusEnum::ACTIVE)
                ->orderBy('subscription_end_date', 'desc')
                ->first();


            $newStartDate = Carbon::parse($validatedData['subscription_start_date']);
            $newEndDate = Carbon::parse($validatedData['subscription_end_date']);

            // Scenario 1: Check if the new subscription starts within the existing subscription period
            if ($userSubscription && $userSubscription->status == GymSubscriptionStatusEnum::ACTIVE && $userSubscription->subscription_end_date > now()) {
                $currentStartDate = Carbon::parse($userSubscription->subscription_start_date);
                $currentEndDate = Carbon::parse($userSubscription->subscription_end_date);

                if ($newStartDate->between($currentStartDate, $currentEndDate)) {
                    // Mark the existing subscription as inactive
                    $userSubscription->update(['status' => GymSubscriptionStatusEnum::INACTIVE]);

                    // Add new subscription as active
                    $this->userSubscriptionHistory->create([
                        'gym_id' => $gymId,
                        'original_transaction_id' => 1,
                        'user_id' => $validatedData['user_id'],
                        'subscription_id' => $validatedData['subscription_id'],
                        'subscription_start_date' => $validatedData['subscription_start_date'],
                        'subscription_end_date' => $validatedData['subscription_end_date'],
                        'amount' => $validatedData['amount'],
                        'status' => GymSubscriptionStatusEnum::ACTIVE,
                        'coupon_id' => $request->coupon_id,
                        'description' => $validatedData['description'],
                    ]);

                    // Show SweetAlert for inactivated previous subscription
                    return redirect()->back()->with('status', 'success')
                        ->with('message', 'Current subscription was inactivated and the new subscription has been activated.');
                }
            }

            // Scenario 2: If the new subscription starts after the current subscription period
            if ($userSubscription && $newStartDate->greaterThan($userSubscription->subscription_end_date)) {
                // Keep the existing subscription active until the new one starts

                // Add new subscription but mark as pending (or any other inactive status)
                $this->userSubscriptionHistory->create([
                    'gym_id' => $gymId,
                    'original_transaction_id' => 1,
                    'user_id' => $validatedData['user_id'],
                    'subscription_id' => $validatedData['subscription_id'],
                    'subscription_start_date' => $validatedData['subscription_start_date'],
                    'subscription_end_date' => $validatedData['subscription_end_date'],
                    'amount' => $validatedData['amount'],
                    'status' => GymSubscriptionStatusEnum::INACTIVE, // Set status as pending initially
                    'coupon_id' => $request->coupon_id,
                    'description' => $validatedData['description'],
                ]);

                // Show SweetAlert message that the new subscription will start after current one ends
                return redirect()->back()->with('status', 'success')
                    ->with('message', 'Current subscription will remain active until ' . Carbon::parse($userSubscription->subscription_end_date)->format('jS M Y') . ' New subscription started from ' . Carbon::parse($newStartDate)->format('jS M Y'));
            }

            return redirect()->back()->with('status', 'error')->with('message', 'User is already in an active subscription until ' . Carbon::parse($userSubscription->subscription_end_date)->format('jS M Y'));
        } catch (Throwable $th) {
            Log::error("[GymUserController][addUserSubscription] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Failed to add subscription. ' . $th->getMessage());
        }
    }


    public function autocompleteWorkout(Request $request)
    {
        $gymUser = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;
        $query = $request->get('query');

        $admin = $this->gym->where('gym_type', 'admin')->first();
        // Fetch both name and id
        $workouts = Workout::where('name', 'LIKE', "%{$query}%")
            ->where('added_by', $gymId)
            ->orWhere('added_by', $admin->id)
            ->get(['id', 'name']);

        return response()->json($workouts);
    }


    public function fetchWorkoutDetails(Request $request)
    {
        $exerciseId = $request->input('workout_id');
        $workout = Workout::find($exerciseId);

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

        $admin = $this->gym->where('gym_type', 'admin')->first();
        // Fetch both name and id

        $gymId = $this->gym->where('uuid', $gymUser->uuid)->first()->id;
        $query = $request->get('query');
        $workouts = Diet::where('name', 'LIKE', "%{$query}%")
            ->where('gym_id', $gymId)
            ->orWhere('added_by', $admin->id)
            ->pluck('name');

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
                'id' => $diet->id,
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

    public function markGymUserAttendance(Request $request)
    {
        try {
            $request->validate([
                "gymId" => 'required',
                "userId" => 'required',
                "attendanceStatus" => 'nullable',
                "day" => 'required'
            ]);

            $now = Carbon::now();
            $year = $now->year;
            $month = $now->month;

            // Prepare the data for the specific day
            $attendanceData = [];
            $attendanceField = 'day' . $request->day;

            // If attendanceStatus is null, unmark the day (set it to null)
            if (is_null($request->attendanceStatus)) {
                $attendanceData[$attendanceField] = null;
            } else {
                $attendanceData[$attendanceField] = $request->attendanceStatus;
            }

            // Check if the user already exists in the attendance table for the month
            $existingUser = GymUserAttendence::where([
                'gym_user_id' => $request->userId,
                'gym_id' => $request->gymId,
                'month' => $month,
                'year' => $year
            ])->first();

            // If the user doesn't exist, store holidays and weekends
            if (!$existingUser) {
                // Store weekends and holidays in the attendance table
                $this->storeHolidaysAndWeekends($request->gymId, $request->userId, $month, $year);
            }

            $gym = $this->gymUserAttendance->updateOrCreate(
                [
                    'gym_user_id' => $request->userId,
                    'gym_id' => $request->gymId,
                    'month' => $month,
                    'year' => $year
                ],
                $attendanceData
            );

            return response()->json(['status' => 200, 'data' => $gym], 200);
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][markGymUserAttendance] error " . $th->getMessage());
            return response()->json(['status' => 500], 500);
        }
    }

    public function getGymHolidaysAndWeekendsOnGymAttendance($gymId)
    {
        try {
            // Fetch holidays (date-wise)
            $holidays = Holiday::where('gym_id', $gymId)->pluck('date')->toArray();

            // Fetch weekends (day-wise)
            $weekends = GymWeekend::where('gym_id', $gymId)->pluck('weekend_day')->toArray();

            return response()->json([
                'status' => 200,
                'holidays' => $holidays, // Holidays array in 'YYYY-MM-DD' format
                'weekends' => $weekends, // Weekends array (days of the week, e.g., 0 for Sunday, 6 for Saturday)
            ], 200);
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][getGymHolidaysAndWeekends] error " . $th->getMessage());
            return response()->json(['status' => 500], 500);
        }
    }

    public function fetchUserAttendanceChart(Request $request)
    {
        try {
            $request->validate([
                "gymId" => 'required',
                "userId" => 'required'
            ]);

            $now = Carbon::now();
            $year = $now->year;
            $month = $now->month;

            // Fetch attendance for the user
            $gym = GymUserAttendence::where([
                'gym_user_id' => $request->userId,
                'gym_id' => $request->gymId,
                'month' => $month,
                'year' => $year
            ])->first();

            // Fetch holidays
            $holidays = Holiday::where('gym_id', $request->gymId)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->pluck('date')
                ->toArray();

            // Fetch weekends dynamically from the gym_weekends table
            $weekendDays = GymWeekend::where('gym_id', $request->gymId)
                ->pluck('weekend_day')  // Assuming 'weekend_day' stores day names like 'Sunday', 'Saturday'
                ->map(function ($day) {
                    return Carbon::parse($day)->dayOfWeek; // Convert day names to Carbon's dayOfWeek integer
                })
                ->toArray();


            // Fetch weekends for the given month based on gym-specific weekend days
            $weekends = [];
            for ($i = 1; $i <= Carbon::create($year, $month)->daysInMonth; $i++) {
                $day = Carbon::create($year, $month, $i);
                if (in_array($day->dayOfWeek, $weekendDays)) {
                    $weekends[] = $day->toDateString();
                }
            }

            // Prepare the default data in case no attendance is marked
            if (!$gym) {
                return response()->json([
                    'status' => 200,
                    'data' => [
                        "Absent" => 0,
                        "Holiday" => count($holidays),
                        "Weekend" => count($weekends),
                        "Present" => 0,
                        "Unmarked" => Carbon::create($year, $month)->daysInMonth - count($holidays) - count($weekends)
                    ],
                    'holidays' => $holidays,
                    'weekends' => $weekends
                ], 200);
            }

            // Parse the attendance data and count presence, absence, and unmarked days
            $gym = $gym->toArray();

            $data = [
                "Absent" => 0,
                "Holiday" => count($holidays),
                "Weekend" => count($weekends),
                "Present" => 0,
                "Unmarked" => 0
            ];

            for ($i = 1; $i <= 31; $i++) {
                switch ($gym['day' . $i]) {
                    case 1:
                        $data["Present"] += 1;
                        break;
                    case null:
                        $data["Unmarked"] += 1;
                        break;
                    case 2:
                        $data["Absent"] += 1;
                }
            }

            return response()->json([
                'status' => 200,
                'data' => $data,
                'gym' => $gym,
                'holidays' => $holidays,
                'weekends' => $weekends
            ], 200);
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][fetchUserAttendanceChart] error " . $th->getMessage());
            return response()->json(['status' => 500, 'data' => null], 500);
        }
    }

    public function storeHolidaysAndWeekends($gymId, $userId, $month, $year)
    {
        try {

            $holidays = Holiday::where('gym_id', $gymId)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->pluck('date')
                ->toArray();

            // Fetch weekends dynamically from the gym_weekends table
            $weekendDays = GymWeekend::where('gym_id', $gymId)
                ->pluck('weekend_day')  // Assuming 'weekend_day' stores day names like 'Sunday', 'Saturday'
                ->map(function ($day) {
                    return Carbon::parse($day)->dayOfWeek; // Convert day names to Carbon's dayOfWeek integer
                })
                ->toArray();

            // Fetch weekends for the given month based on gym-specific weekend days
            $weekends = [];
            for ($i = 1; $i <= Carbon::create($year, $month)->daysInMonth; $i++) {
                $day = Carbon::create($year, $month, $i);
                if (in_array($day->dayOfWeek, $weekendDays)) {
                    $weekends[] = $day->toDateString();
                }
            }

            // Find or create a new attendance record for the user for the given month
            $attendanceRecord = GymUserAttendence::firstOrCreate(
                [
                    'gym_id' => $gymId,
                    'gym_user_id' => $userId,
                    'month' => $month,
                    'year' => $year
                ]
            );

            // Prepare the weekend fields to update (e.g., 'day1', 'day2', ..., 'dayX')
            $weekendAttendanceData = [];
            foreach ($weekends as $weekendDate) {
                $day = Carbon::parse($weekendDate)->day;
                $attendanceField = 'day' . $day;
                $weekendAttendanceData[$attendanceField] = \App\Enums\AttendenceStatusEnum::WEEKEND; // 3 is for WEEKEND status, adjust this as necessary
            }

            $holidaysAttendanceData = [];
            foreach ($holidays as $holidayDate) {
                $day = Carbon::parse($holidayDate)->day;
                $attendanceField = 'day' . $day;
                $holidaysAttendanceData[$attendanceField] = \App\Enums\AttendenceStatusEnum::HOLIDAY;
            }


            // Update the attendance record with weekend days marked as '3'
            $attendanceRecord->update($weekendAttendanceData);
            $attendanceRecord->update($holidaysAttendanceData);

            return response()->json(['message' => 'Weekends stored successfully in attendance table.'], 200);
        } catch (\Exception $e) {
            Log::error("[GymStaffController][storeHolidaysAndWeekends] error " . $e->getMessage());
            return response()->json(['error' => 'Failed to store weekends in attendance table.'], 500);
        }
    }
}
