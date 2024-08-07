<?php

namespace App\Models;

use App\Enums\GymUserAccountStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\HasApiTokens;
use Ramsey\Uuid\Uuid;
use Throwable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable, HasApiTokens;
    protected $table = 'gym_users';
    protected $fillable = [
        'staff_assign_id',
        'profile_status',
        'subscription_status',
        'end_date',
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
        'zip_code',
        'phone_no',
        'password',
        'is_email_verified',
        'is_phone_no_verified',
        'profile_status',
        'dob',
        'height',
        'weight',
        'days'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function injuries()
    {
        return $this->belongsToMany(UserInjury::class, 'injury_user');
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
                'gym_id'          => $gymId,
                'employee_id'     => $employeeId,
                'subscription_id' => $subscriptionId,
                'firstname'       => $addUser['firstname'],
                'lastname'        => $addUser['lastname'],
                'email'           => $addUser['email'],
                'gender'          => $addUser['gender'],
                'address'         => $addUser['address'],
                'member_number'   => $addUser['member_number'],
                'blood_group'     => $addUser['blood_group'],
                'joining_date'    => $addUser['joining_date'],
                'address'         => $addUser['address'],
                'country'         => $addUser['country'],
                'state'           => $addUser['state'],
                'zip_code'        => $addUser['zip_code'],
                'image'           => $imagePath,
            ]);
        } catch (Throwable $e) {
            Log::error('[User][addUser] Error adding user detail: ' . $e->getMessage());
        }
    }

    public function updateUser(array $updateUser, $imagePath)
    {

        // dd($updateUser);
        $uuid = $updateUser['uuid'];
        $userProfile = User::where('uuid', $uuid)->first();

        // Check if the user exists
        if (!$userProfile) {
            return redirect()->back()->with('error', 'User not found');
        }
        try {
            $userProfile->update([
                'first_name' => $updateUser['first_name'],
                'last_name'  => $updateUser['last_name'],
                'email'      => $updateUser['email'],
                'gender'     => $updateUser['gender'],
                'phone_no'   => $updateUser['phone_no'],
                'username'   => $updateUser['username'],
                'password'   => $updateUser['password'],
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
        $userProfile = User::find($userId);

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

    public function completeUserProfile(array $userDetail, $imagePath)
    {
        // Check if the email or phone number is provided
        if ((!isset($userDetail['email']) && !isset($userDetail['phone_no'])) || 
        (isset($userDetail['email']) && isset($userDetail['phone_no']))) {
       return [
                'status'  => 422,
                'message' => 'Email or phone number is required'
            ];
        }
    
        // Find the user by email or phone number
        $userProfile = isset($userDetail['email']) 
        ? User::where('email', $userDetail['email'])->first()
        : User::where('phone_no', $userDetail['phone_no'])->first();

    
        // Check if the user exists
        if (!$userProfile) {
            return [
                'status'  => 422,
                'message' => 'User not found'
            ];
        }
    
        try {
            $userProfile->update([
                'firstname'      => $userDetail['firstname'],
                'lastname'       => $userDetail['lastname'],
                'email'          => $userDetail['email']?? null,
                'gender'         => $userDetail['gender'],
                'phone_no'       => $userDetail['phone_no']?? null,
                'password'       => $userDetail['password'],
                'dob'            => $userDetail['dob'],
                'profile_status' => GymUserAccountStatusEnum::PROFILE_DETAIL_COMPLETED,
            ]);
    
            if ($imagePath) {
                $userProfile->update([
                    'image' => $imagePath
                ]);
            }
    
            return [
                'status'  => 200,
                'message' => 'Profile updated successfully',
                'user'    => $userProfile
            ];
        } catch (Throwable $e) {
            Log::error('[User][completeUserProfile] Error while completing user detail: ' . $e->getMessage());
            return [
                'status'  => 500,
                'message' => 'An error occurred while updating the profile'
            ];
        }
    }

    public function profilePartFour(array $userDetail)
    {
        $userProfile = User::where('uuid', $userDetail['uuid'])->first();
    
        // Check if the user exists
        if (!$userProfile) {
            return [
                'status'  => 404,
                'message' => 'User not found'
            ];
        }
    
        try {
            // Update user profile details
            $userProfile->update([
                'height' => $userDetail['height'],
                'weight' => $userDetail['weight'],
                'days'   => $userDetail['days']
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
    
            // Retrieve goals and levels for the user
        $goals = $userProfile->goals()->get();
        $levels = $userProfile->levels()->get();
            return [
                'status'  => 200,
                'message' => 'Profile updated successfully',
                'user'    => $userProfile,
                'goals'   => $goals,
                'levels'  => $levels
            ];
        } catch (Throwable $e) {
            Log::error('[User][profilePartFour] Error while completing user detail: ' . $e->getMessage());
            return [
                'status'  => 500,
                'message' => 'An error occurred while updating the profile'
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
        return $this->belongsToMany(UserLebel::class, 'level_users','user_id', 'level_id');
    }

    public function gyms()
    {
        return $this->belongsToMany(Gym::class, 'gym_user_gyms', 'user_id', 'gym_id');
    }
    
}
 