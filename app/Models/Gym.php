<?php

namespace App\Models;

use App\Enums\AdminSubscriptionEnum;
use App\Traits\SessionTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class Gym extends Authenticatable
{
    use SoftDeletes;
    use SessionTrait;

     protected $guard = 'gym';

    protected $fillable = [

        'gym_name',
        'email',
        'phone_no',
        'password',
        'image',
        'username',
        'address',
        'city',
        'state',
        'country',
        'web_link',
        'gym_type',
        'face_link',
        'insta_link'

    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }



    public function updateGym(array $updateGym, $imagePath)
    {

        $uuid = $this->getGymSession()['uuid'];
        $gymUser = Gym::where('uuid', $uuid)->first();

        // Check if the user exists
        if (!$gymUser) {
            return redirect()->back()->with('error', 'User not found');
        }

        try {
            $gymUser->update([
                'username' => $updateGym['username'],
                'gym_name' => $updateGym['gym_name'],
                'email' => $updateGym['email'],
                'phone_no' => $updateGym['phone_no'],
                'password' =>Hash::make($updateGym['password']),
                'address' => $updateGym['address'],
                'country' => $updateGym['country'],
                'state' => $updateGym['state'],
                'city' => $updateGym['city'],
                'web_link' => $updateGym['web_link'],
                'image' => $imagePath,
                'gym_type' => $updateGym['gym_type'],
                'facebook' => $updateGym['facebook'],
                'instagram' => $updateGym['instagram'],
                'terms_and_conditions' => $updateGym['terms_and_conditions'],
                'subscription_id' => AdminSubscriptionEnum::Trial
            ]);

            return $gymUser->save();
        } catch (\Throwable $e) {
            Log::error('[Gym][updateGym] Error while updating gym detail: ' . $e->getMessage());
        }

    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'gym_user_gyms', 'gym_id', 'user_id');
    }

}
