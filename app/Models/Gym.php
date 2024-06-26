<?php

namespace App\Models;

use App\Enums\AdminSubscriptionEnum;
use App\Traits\SessionTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class Gym extends Authenticatable
{
    use SoftDeletes;
    use SessionTrait;

    protected $fillable = [
        'username',
        'gym_name',
        'email',
        'password',
        'address',
        'country',
        'image',
        'state',
        'city',
        'web_link',
        'gym_type',
        'subscription_id',
        'terms_and_conditions',
        'facebook',
        'instagram'
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
                'password' => $updateGym['password'],
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
    // public function addTandC(array $tAndC)
    // {
    //     try {
    //         return $this->create([
    //             'terms_and_conditions'   => $tAndC['terms_and_conditions'],
    //         ]);
    //     } catch (\Throwable $e) {
    //         Log::error('[Gym][addTandC] Error adding gym terms and conditions: ' . $e->getMessage());
    //     }
    // }

    // public function addSocialLink(array $social)
    // {
    //     try {
    //         return $this->create([
    //             'facebook'   => $social['facebook'],
    //             'instagram'  => $social['instagram'],
    //         ]);
    //     } catch (\Throwable $e) {
    //         Log::error('[Gym][addSocialLink] Error adding social links: ' . $e->getMessage());
    //     }
    // }




}
