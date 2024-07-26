<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Throwable;

class User extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'gym_users';
    protected $fillable = [
        'employee_id',
        'gym_id',
        'firstname',
        'lastname',
        'email',
        'gender',
        'member_number',
        'subscription_id',
        'blood_group',
        'image',
        'joining_date',
        'address',
        'country',
        'state',
        'zip_code'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function trainerDetails()
    {
        // $trainer = GymStaff::
    }

    public function addUser(array $addUser, $imagePath, $gymId,$subscriptionId,$employeeId)
    {
        try {
            return $this->create([
                'gym_id' => $gymId,
                'employee_id'=>$employeeId,
                'subscription_id'=>$subscriptionId,
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
                'zip_code' => $addUser['zip_code'],
                'image' => $imagePath,
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
}
