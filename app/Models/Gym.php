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
        'city_id',
        'state_id',
        'country_id',
        'web_link',
        'gym_type',
        'face_link',
        'insta_link',
        'qrcode',
        'established_at',
        'master_pin',
        'gym_document',
        'owner_identity_document'
    ];

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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
            $model->master_pin = '123456789';
        });
    }

    public function updateGym(array $updateGym, $imagePath)
    {

        $uuid = $this->getGymSession()['uuid'];
        $gymUser = Gym::where('uuid', $uuid)->first();

        if (!$gymUser) {
            return redirect()->back()->with('error', 'User not found');
        }

        try {
            $gymUser->update([
                'username'             => $updateGym['username'],
                'gym_name'             => $updateGym['gym_name'],
                'email'                => $updateGym['email'],
                'phone_no'             => $updateGym['phone_no'],
                'password'             => Hash::make($updateGym['password']),
                'address'              => $updateGym['address'],
                'country'              => $updateGym['country'],
                'state'                => $updateGym['state'],
                'city'                 => $updateGym['city'],
                'web_link'             => $updateGym['web_link'],
                'image'                => $imagePath,
                'gym_type'             => $updateGym['gym_type'],
                'facebook'             => $updateGym['facebook'],
                'instagram'            => $updateGym['instagram'],
                'terms_and_conditions' => $updateGym['terms_and_conditions'],
                'subscription_id'      => AdminSubscriptionEnum::Trial
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

    public function staff()
    {
        return $this->hasMany(GymStaff::class, 'gym_id');
    }
}
