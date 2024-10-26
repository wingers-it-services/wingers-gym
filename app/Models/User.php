<?php

namespace App\Models;

use App\Enums\GymSubscriptionStatusEnum;
use App\Enums\GymUserAccountStatusEnum;
use App\Enums\UserTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\HasApiTokens;
use Ramsey\Uuid\Uuid;
use Throwable;

class User extends Authenticatable
{
    use HasApiTokens;
    use SoftDeletes;
    use Notifiable, HasApiTokens;
    protected $table = 'gym_users';
    protected $fillable = [
        'staff_assign_id',
        'profile_status',
        'subscription_status',
        'subscription_end_date',
        'coupon_id',
        'gym_id',
        'firstname',
        'lastname',
        'email',
        'gender',
        'subscription_id',
        'blood_group',
        'image',
        'joining_date',
        'address',
        'country',
        'state',
        'city',
        'zip_code',
        'phone_no',
        'password',
        'is_email_verified',
        'is_phone_no_verified',
        'profile_status',
        'dob',
        'height',
        'weight',
        'days',
        'trainer_id',
        'user_type',
        'subscription_start_date',
        'master_pin'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
            $model->master_pin = 'admin@2024';
        });

        static::updated(function ($user) {
            // Check if profile_status changed to 2
            if ($user->profile_status === 2 && $user->getOriginal('profile_status') !== 2) {
                // Allot all workouts for the user
                $user->allotSubscription($user);
                $user->allotWorkouts($user);
                $user->allotDiet($user);
            }
        });
    }

    public function allotSubscription($user)
    {
        try {
            // Fetch the gym with gym_type = 'admin'
            $gym = Gym::where('gym_type', 'admin')->first();
            if (!$gym) {
                throw new \Exception('Admin gym not found.');
            }

            // Fetch the subscription with 'Basic' name for the admin gym
            $subscription = GymSubscription::where('gym_id', $gym->id)
                ->where('amount', '0')
                ->first();
            if (!$subscription) {
                throw new \Exception('Basic subscription for admin gym not found.');
            }

            $validityMonths = $subscription->validity;

            // Set the start date and calculate the end date based on the validity in months
            $startDate = Carbon::now();
            $endDate = $startDate->copy()->addMonths($validityMonths);

            // Update user with subscription details
            $homeUser = User::findOrFail($user->id);
            $homeUser->update([
                'subscription_id' => $subscription->id,
                'subscription_start_date' => $startDate,
                'subscription_end_date' => $endDate,
                'subscription_status' => GymSubscriptionStatusEnum::ACTIVE,
            ]);

            // Create a record in the UserSubscriptionHistory table
            UserSubscriptionHistory::create([
                'user_id' => $homeUser->id,
                'subscription_id' => $subscription->id,
                'original_transaction_id' => 1, // Update as necessary
                'subscription_start_date' => $startDate,
                'subscription_end_date' => $endDate,
                'status' => GymSubscriptionStatusEnum::ACTIVE,
                'amount' => $subscription->amount,
                'gym_id' => $gym->id,
            ]);

        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::error('Error allotting subscription: ' . $e->getMessage());
        }
    }

    public function allotWorkouts($user)
    {
        // Fetch the gym with gym_type = 'admin'
        $gym = Gym::where('gym_type', 'admin')->first();

        // Fetch the weekend days for the gym from the GymWeekend table
        $weekendDays = GymWeekend::where('gym_id', $gym->id)->pluck('weekend_day')->toArray(); // Assuming 'weekend_day' stores day names like 'Saturday', 'Sunday'

        // Fetch user's goal ID from the goal_user table
        $userGoal = GoalUser::where('user_id', $user->id)->first();

        // Fetch user's level ID from the level_user table
        $userLevel = LevelUser::where('user_id', $user->id)->first();

        if ($userGoal && $userLevel) {
            // Fetch workouts based on goal, level, and day from GoalWiseWorkouts
            $goalWiseWorkouts = GoalWiseWorkouts::where('goal_id', $userGoal->goal_id)
                ->where('user_lebel_id', $userLevel->level_id)
                ->get();

            if ($goalWiseWorkouts->isNotEmpty()) {
                foreach ($goalWiseWorkouts as $goalWiseWorkout) {
                    $workout = $goalWiseWorkout->workout;
                    $workoutDay = $goalWiseWorkout->day; // Fetch the specific day for this workout

                    // Check if the workout's day is not a weekend for this gym
                    if (!in_array($workoutDay, $weekendDays)) {
                        // Create a new entry in the UserWorkout table for each workout and its specific day
                        UserWorkout::create([
                            'user_id' => $user->id, // Use the passed user ID
                            'workout_id' => $workout->id,
                            'day' => $workoutDay, // Allot for the specific day
                            'exercise_name' => $workout->name,
                            'sets' => $goalWiseWorkout->sets, // Use sets from GoalWiseWorkouts
                            'reps' => $goalWiseWorkout->reps, // Use reps from GoalWiseWorkouts
                            'weight' => $goalWiseWorkout->weight, // Use weight from GoalWiseWorkouts
                            'workout_des' => $workout->description,
                            'gym_id' => $gym->id,
                            'is_completed' => 0, // By default, the workout is not completed
                            'targeted_body_part' => $workout->targeted_body_part ?? 'Shoulder', // Default body part if not available
                        ]);
                    }
                }

                // Log success message
                Log::info("Goal and level-based workouts for user ID {$user->id} have been allotted for the specific days from gym admin.");

                // After allotting workouts, trigger the cron command for this user
                Artisan::call('user:workout', ['user_id' => $user->id]);
            } else {
                // Log warning if no workouts found for the user's goal and level
                Log::warning("No workouts found for user goal ID {$userGoal->goal_id} and level ID {$userLevel->level_id}.");
            }
        } else {
            // Log warning if no goal or level found for the user
            if (!$userGoal) {
                Log::warning("No goal found for user ID {$user->id}.");
            }

            if (!$userLevel) {
                Log::warning("No level found for user ID {$user->id}.");
            }
        }
    }

    // public function allotDiet($user)
    // {
    //     // Define the days of the week
    //     $allDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    //     // Fetch the gym with gym_type = 'admin'
    //     $gym = Gym::where('gym_type', 'admin')->first();

    //     // Fetch the weekend days for the gym from the weekend table
    //     $weekendDays = GymWeekend::where('gym_id', $gym->id)->pluck('weekend_day')->toArray(); // Assuming 'day' column stores day names like 'Saturday', 'Sunday'

    //     // Fetch user's goal ID from the goal_user table
    //     $userGoal = GoalUser::where('user_id', $user->id)->first();

    //     $userLevel = LevelUser::where('user_id', $user->id)->first();

    //     if ($userGoal) {
    //         // Fetch diet IDs associated with the user's goal from goal_wise_diets
    //         $goalDiets = GoalWiseDiet::where('goal_id', $userGoal->goal_id)
    //         ->where('user_lebel_id', $userLevel->level_id)
    //         ->get();

    //         // Fetch diets added by the admin gym that match the goal
    //         $diets = Diet::whereIn('id', $goalDiets)
    //             ->where('added_by', $gym->id)
    //             ->get();

    //         if ($diets->isNotEmpty()) {
    //             // Loop through each day (Monday to Sunday)
    //             foreach ($allDays as $currentDay) {
    //                 // Check if the current day is a weekend for this gym
    //                 if (!in_array($currentDay, $weekendDays)) {
    //                     foreach ($diets as $diet) {
    //                         // Create a new entry in the UserDiet table for each diet and each non-weekend day
    //                         UserDiet::create([
    //                             'user_id'                      => $user->id,
    //                             'day'                          => $currentDay, // Assign for each non-weekend day
    //                             'meal_name'                    => $diet->name,
    //                             'calories'                     => $diet->calories ?? 0, // Default values
    //                             'protein'                      => $diet->protein ?? 0,
    //                             'carbs'                        => $diet->carbs ?? 0,
    //                             'fats'                         => $diet->fats ?? 0,
    //                             'gym_id'                       => $gym->id,
    //                             'diet_id'                      => $diet->id,
    //                             'goal'                         => $userGoal->goal_id,
    //                             'meal_type'                    => $diet->meal_type ?? 'breakfast',
    //                             'diet_description'             => $diet->alternative_diet,
    //                             'alternative_diet_description' => $diet->alternative_diet ?? null,
    //                             'is_completed'                 => 0, // By default, the meal is not completed
    //                         ]);
    //                     }
    //                 }
    //             }
    //             // Log success message
    //             Log::info("Goal-based diets for user ID {$user->id} have been allotted for non-weekend days from gym admin.");

    //             // After allotting diets, trigger the cron command for this user
    //             Artisan::call('user:diets');
    //         } else {
    //             // Log warning if no diets found for the user's goal
    //             Log::warning("No diets found for user goal ID {$userGoal->goal_id}.");
    //         }
    //     } else {
    //         // Log warning if no goal found for the user
    //         Log::warning("No goal found for user ID {$user->id}.");
    //     }
    // }

    public function allotDiet($user)
    {
        // Fetch the gym with gym_type = 'admin'
        $gym = Gym::where('gym_type', 'admin')->first();

        // Fetch the weekend days for the gym from the weekend table
        $weekendDays = GymWeekend::where('gym_id', $gym->id)->pluck('weekend_day')->toArray();

        // Fetch user's goal ID from the goal_user table
        $userGoal = GoalUser::where('user_id', $user->id)->first();

        // Fetch user's level ID from the level_user table
        $userLevel = LevelUser::where('user_id', $user->id)->first();

        if ($userGoal && $userLevel) {
            // Fetch goal-wise diets associated with the user's goal and level
            $goalDiets = GoalWiseDiet::where('goal_id', $userGoal->goal_id)
                ->where('user_lebel_id', $userLevel->level_id)
                ->get();

            // Fetch diets from the Diet table for reference
            $dietIds = $goalDiets->pluck('diet_id')->toArray();
            $diets = Diet::whereIn('id', $dietIds)
                ->where('added_by', $gym->id)
                ->get()
                ->keyBy('id'); // Using keyBy to easily reference diet details by id

            if ($goalDiets->isNotEmpty()) {
                // Filter out weekend days from the goal-wise diets
                $goalDiets = $goalDiets->filter(function ($goalDiet) use ($weekendDays) {
                    // Ensure the day from the goal-wise diet is not a weekend
                    return !in_array($goalDiet->day, $weekendDays);
                });

                foreach ($goalDiets as $goalDiet) {
                    // Find the diet details
                    $diet = $diets->get($goalDiet->diet_id);

                    if ($diet) {
                        // Check if a diet entry for this user, day, and diet_id already exists to avoid duplication
                        $existingDiet = UserDiet::where('user_id', $user->id)
                            ->where('day', $goalDiet->day) // Now using day from GoalWiseDiet
                            ->where('diet_id', $diet->id)
                            ->exists();

                        // If no existing diet, create a new entry
                        if (!$existingDiet) {
                            UserDiet::create([
                                'user_id' => $user->id,
                                'day' => $goalDiet->day, // Assign day from GoalWiseDiet
                                'meal_name' => $diet->name,
                                'calories' => $goalDiet->calories ?? 0, // From GoalWiseDiet
                                'protein' => $goalDiet->protein ?? 0,  // From GoalWiseDiet
                                'carbs' => $goalDiet->carbs ?? 0,    // From GoalWiseDiet
                                'fats' => $goalDiet->fats ?? 0,     // From GoalWiseDiet
                                'gym_id' => $gym->id,
                                'diet_id' => $diet->id,
                                'goal' => $userGoal->goal_id,
                                'meal_type' => $diet->meal_type ?? 'breakfast',
                                'diet_description' => $diet->diet_description,
                                'alternative_diet_description' => $diet->alternative_diet ?? null,
                                'is_completed' => 0, // By default, the meal is not completed
                            ]);
                        }
                    }
                }

                // Log success message
                Log::info("Goal-based diets for user ID {$user->id} have been allotted for non-weekend days from gym admin.");

                // After allotting diets, trigger the cron command for this user
                Artisan::call('user:diets');
            } else {
                // Log warning if no diets found for the user's goal and level
                Log::warning("No diets found for user goal ID {$userGoal->goal_id} and level ID {$userLevel->level_id}.");
            }
        } else {
            // Log warning if no goal or level found for the user
            Log::warning("No goal or level found for user ID {$user->id}.");
        }
    }



    public function getImageAttribute()
    {
        $imagePath = $this->attributes['image'];
        $defaultImagePath = 'images/profile/no_profile.png';
        $fullImagePath = $imagePath;

        // Check if the file exists in the public directory
        if ($imagePath && file_exists(public_path($fullImagePath))) {
            return asset($fullImagePath);
        }

        return asset($defaultImagePath);
    }

    public function injuries()
    {
        return $this->belongsToMany(UserInjury::class, 'injury_users', 'user_id', 'injury_id');
    }

    public function staff()
    {
        return $this->belongsTo(GymStaff::class, 'staff_assign_id');
    }

    public function subscription()
    {
        return $this->belongsTo(GymSubscription::class, 'subscription_id');
    }

    public function trainerDetails()
    {
        // $trainer = GymStaff::
    }

    public function addUser(array $addUser, $imagePath, $gymId, $subscriptionId, $employeeId)
    {
        try {
            return $this->create([
                'gym_id' => $gymId,
                'employee_id' => $employeeId,
                'subscription_id' => $subscriptionId,
                'firstname' => $addUser['firstname'],
                'lastname' => $addUser['lastname'],
                'email' => $addUser['email'],
                'gender' => $addUser['gender'],
                'address' => $addUser['address'],
                'member_number' => $addUser['member_number'],
                'blood_group' => $addUser['blood_group'],
                'joining_date' => $addUser['joining_date'],
                'address' => $addUser['address'],
                'country' => $addUser['country'],
                'state' => $addUser['state'],
                'city' => $addUser['city'],
                'zip_code' => $addUser['zip_code'],
                'image' => $imagePath,
            ]);
        } catch (Throwable $e) {
            Log::error('[User][addUser] Error adding user detail: ' . $e->getMessage());
        }
    }

    public function updateUser(array $updateUser, $imagePath)
    {
        $userProfile = $this->where('id', auth()->user()->id)->first();

        // Check if the user exists
        if (!$userProfile) {
            return redirect()->back()->with('error', 'User not found');
        }
        try {
            $userProfile->update([
                'first_name' => $updateUser['first_name'],
                'last_name' => $updateUser['last_name'],
                'email' => $updateUser['email'],
                'gender' => $updateUser['gender'],
                'phone_no' => $updateUser['phone_no'],
                'username' => $updateUser['username'],
                'password' => $updateUser['password'],
            ]);
            if (isset($imagePath)) {
                $userProfile->update([
                    'image' => $imagePath
                ]);
            }

            return $userProfile->save();
        } catch (Throwable $e) {
            Log::error('[Gym][updateUser] Error while updating user detail: ' . $e->getMessage());
        }
    }

    public function addTrainer(array $gymTrainer)
    {
        $userId = $gymTrainer['user_id'];
        $trainerId = $gymTrainer['trainer_id'];
        $userProfile = $this->find($userId);

        // Check if the user exists
        if (!$userProfile) {
            return redirect()->back()->with('error', 'User not found');
        }
        try {
            if ($trainerId == "0") {
                $trainerId = null;
            }

            $userProfile->update([
                'trainer_id' => $trainerId
            ]);
            return $userProfile->save();
        } catch (Throwable $e) {
            Log::error('[Gym][addTrainer] Error while alloting Trainer detail: ' . $e->getMessage());
        }
    }

    public function createUserProfile(array $userDetail, $imagePath)
    {
        try {
            $gym = Gym::where('gym_type', 'admin')->first();
            $userProfile = $this->create([
                'firstname' => $userDetail['firstname'],
                'lastname' => $userDetail['lastname'],
                'email' => $userDetail['email'],
                'gender' => $userDetail['gender'],
                'phone_no' => $userDetail['phone_no'],
                'gym_id' => $gym->id,
                'password' => $userDetail['password'],
                'dob' => $userDetail['dob'],
                'address' => $userDetail['address'] ?? null,
                'country' => $userDetail['country'] ?? null,
                'state' => $userDetail['state'] ?? null,
                'city' => $userDetail['city'] ?? null,
                'zip_code' => $userDetail['zip_code'] ?? null,
                'profile_status' => GymUserAccountStatusEnum::PROFILE_DETAIL_COMPLETED,
                'is_email_verified' => true,
                'is_phone_no_verified' => true,
                'user_type' => UserTypeEnum::HOMEUSER,
            ]);

            if ($imagePath) {
                $userProfileData['image'] = $imagePath;
            }


            $adminGym = Gym::where('gym_type', 'admin')->first();

            if ($adminGym) {
                // Step 4: Insert the user and admin gym into gym_user_gym table
                GymUserGym::create([
                    'user_id' => $userProfile->id,
                    'gym_id' => $adminGym->id
                ]);
            } else {
                Log::warning('[User][createUserProfile] No admin gym found.');
            }

            return [
                'status' => 200,
                'message' => 'Profile created successfully',
                'user' => $userProfile
            ];
        } catch (Throwable $e) {
            Log::error('[User][createUserProfile] Error while creating user detail: ' . $e->getMessage());
            return [
                'status' => 500,
                'message' => 'An error occurred while creating the profile'
            ];
        }
    }

    public function profilePartFour(array $userDetail)
    {
        $userProfile = $this->where('uuid', $userDetail['uuid'])->first();

        // Check if the user exists
        if (!$userProfile) {
            return [
                'status' => 404,
                'message' => 'User not found'
            ];
        }

        try {
            // Update user profile details
            $userProfile->update([
                'height' => $userDetail['height'],
                'weight' => $userDetail['weight'],
                'days' => $userDetail['days']
            ]);

            // Save goals to goal_users table
            if (!empty($userDetail['goals'])) {
                foreach ($userDetail['goals'] as $goalId) {
                    // Check if the goal already exists for the user
                    $existingGoal = GoalUser::where('user_id', $userProfile->id)
                        ->where('goal_id', $goalId)
                        ->first();
                    if (!$existingGoal) {
                        GoalUser::create([
                            'user_id' => $userProfile->id,
                            'goal_id' => $goalId
                        ]);
                    }
                }
            }

            // Save levels to level_users table
            if (!empty($userDetail['levels'])) {
                foreach ($userDetail['levels'] as $levelId) {
                    // Check if the level already exists for the user
                    $existingLevel = LevelUser::where('user_id', $userProfile->id)
                        ->where('level_id', $levelId)
                        ->first();
                    if (!$existingLevel) {
                        LevelUser::create([
                            'user_id' => $userProfile->id,
                            'level_id' => $levelId
                        ]);
                    }
                }
            }

            $userProfile->profile_status = GymUserAccountStatusEnum::BODY_MESUREMENT_DETAIL; // Set to your desired status
            $userProfile->save();

            // Retrieve goals and levels for the user
            $goals = $userProfile->goals()->get();
            $levels = $userProfile->levels()->get();
            return [
                'status' => 200,
                'message' => 'Profile updated successfully',
                'user' => $userProfile,
                'goals' => $goals,
                'levels' => $levels
            ];
        } catch (Throwable $e) {
            Log::error('[User][profilePartFour] Error while completing user detail: ' . $e->getMessage());
            return [
                'status' => 500,
                'message' => 'An error occurred while updating the profile'
            ];
        }
    }

    public function updateUserProfile(array $userDetail)
    {
        try {
            $user = auth()->user();
            $userProfile = $this->find($user->id);


            // Check if the user exists
            if (!$userProfile) {
                return [
                    'status' => 404,
                    'message' => 'User not found'
                ];
            }

            // Update the basic profile information
            $userProfile->update([
                'firstname' => $userDetail['firstname'],
                'lastname' => $userDetail['lastname'],
                'gender' => $userDetail['gender'],
                'dob' => $userDetail['dob'],
                'height' => $userDetail['height'],
                'weight' => $userDetail['weight'],
                'days' => $userDetail['days'],
                'address' => $userDetail['address'],
                'country' => $userDetail['country'],
                'state' => $userDetail['state'],
                'city' => $userDetail['city'],
                'zip_code' => $userDetail['zip_code']
            ]);

            if (isset($userDetail['remove_image']) && $userDetail['remove_image'] == 1) {
                if ($userProfile->image && file_exists(public_path($userProfile->image))) {
                    unlink(public_path($userProfile->image));
                }
                $userProfile->image = null; // Remove the image path from the database
            }

            // Handle new image upload if 'image' is provided
            if (isset($userDetail['image'])) {
                if ($userProfile->image && file_exists(public_path($userProfile->image))) {
                    unlink(public_path($userProfile->image));
                }

                $imagePath = 'user_images/';
                $imageName = time() . '_' . $userDetail['image']->getClientOriginalName();
                $userDetail['image']->move(public_path($imagePath), $imageName);

                $userProfile->image = $imagePath . $imageName;
            }


            $userProfile->save();

            // Update injuries
            if (isset($userDetail['injury_ids']) && is_array($userDetail['injury_ids'])) {
                $newInjuryIds = $userDetail['injury_ids'];

                // Update or create new injury records
                foreach ($newInjuryIds as $injuryId) {
                    InjuryUser::updateOrCreate(
                        [
                            'user_id' => $userProfile->id,
                            'injury_id' => $injuryId
                        ]
                    );
                }

                // Delete injuries that are not in the new list
                InjuryUser::where('user_id', $userProfile->id)
                    ->whereNotIn('injury_id', $newInjuryIds)
                    ->delete();
            } else {
                // If no injury_ids are provided, remove all injury records for the user
                InjuryUser::where('user_id', $userProfile->id)->delete();
            }

            // Update goals
            if (!empty($userDetail['goals'])) {
                $newGoalIds = $userDetail['goals'];

                // Update or create new goal records
                foreach ($newGoalIds as $goalId) {
                    GoalUser::updateOrCreate(
                        [
                            'user_id' => $userProfile->id,
                            'goal_id' => $goalId
                        ]
                    );
                }

                // Delete goals that are not in the new list
                GoalUser::where('user_id', $userProfile->id)
                    ->whereNotIn('goal_id', $newGoalIds)
                    ->delete();
            } else {
                // If no goals are provided, remove all goal records for the user
                GoalUser::where('user_id', $userProfile->id)->delete();
            }

            // Update levels
            if (!empty($userDetail['levels'])) {
                $newLevelIds = $userDetail['levels'];

                // Update or create new level records
                foreach ($newLevelIds as $levelId) {
                    LevelUser::updateOrCreate(
                        [
                            'user_id' => $userProfile->id,
                            'level_id' => $levelId
                        ]
                    );
                }

                // Delete levels that are not in the new list
                LevelUser::where('user_id', $userProfile->id)
                    ->whereNotIn('level_id', $newLevelIds)
                    ->delete();
            } else {
                // If no levels are provided, remove all level records for the user
                LevelUser::where('user_id', $userProfile->id)->delete();
            }

            $injuries = $user->injuries()->get(['injury_id', 'injury_type', 'image']);  // Adjust fields as per your model
            $goals = $user->goals()->get(['goal_id', 'goal']);            // Adjust fields as per your model
            $levels = $user->levels()->get(['level_id', 'lebel']);

            return [
                'status' => 200,
                'message' => 'Profile updated successfully',
                'user' => $userProfile,
                'injuries' => $injuries,
                'goals' => $goals,
                'levels' => $levels,
            ];
        } catch (Throwable $e) {
            Log::error('[User][updateUserProfile] Error while updating user profile: ' . $e->getMessage());
            return [
                'status' => 500,
                'message' => 'An error occurred while updating the profile: ' . $e->getMessage()
            ];
        }
    }


    public function goalUsers()
    {
        return $this->hasMany(GoalUser::class);
    }

    public function levelUsers()
    {
        return $this->hasMany(LevelUser::class);
    }

    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'goal_users');
    }

    public function levels()
    {
        return $this->belongsToMany(UserLebel::class, 'level_users', 'user_id', 'level_id');
    }

    public function gyms()
    {
        return $this->belongsToMany(Gym::class, 'gym_user_gyms', 'user_id', 'gym_id');
    }

    public function trainer()
    {
        return $this->hasOneThrough(GymStaff::class, UsersTrainerHistry::class, 'user_id', 'id', 'id', 'trainer_id');
    }

    public function activeTrainers()
    {
        return $this->hasMany(UsersTrainerHistry::class)
            ->where('status', 1)
            ->with('trainer')
            ->latest('created_at');
    }

    public function fcmTokens()
    {
        return $this->hasMany(UserFcmToken::class, 'user_id');
    }
}
