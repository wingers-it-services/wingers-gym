<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class AdminUser extends Model
{

    protected $fillable = [
        'gym_id',
        'user_type',
        'first_name',
        'last_name',
        'email',
        'gender',
        'phone_no',
        'username',
        'password',
        'image'
    ];

    public function addUser(array $addUser, $imagePath)
    {
        try {
            return $this->create([
                'gym_id' => $addUser['gym_id'],
                'user_type' => $addUser['user_type'],
                'first_name' => $addUser['first_name'],
                'last_name' => $addUser['last_name'],
                'email' => $addUser['email'],
                'gender' => $addUser['gender'],
                'phone_no' => $addUser['phone_no'],
                'username' => $addUser['username'],
                'password' => $addUser['password'],
                'image' => $imagePath,
            ]);
        } catch (\Throwable $e) {
            Log::error('[User][addUser] Error adding user detail: ' . $e->getMessage());
        }
    }

    public function updateUser(array $updateUser, $imagePath)
    {

        // dd($updateUser);
        $uuid = $updateUser['uuid'];
        $userProfile = AdminUser::where('uuid', $uuid)->first();

        // Check if the user exists
        if (!$userProfile) {
            return redirect()->back()->with('error', 'User not found');
        }
        try {
            $userProfile->update([
                'gym_id' => $updateUser['gym_id'],
                'user_type' => $updateUser['user_type'],
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
        } catch (\Throwable $e) {
            Log::error('[Gym][updateUser] Error while updating user detail: ' . $e->getMessage());
        }
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
