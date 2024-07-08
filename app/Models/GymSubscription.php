<?php

namespace App\Models;

use App\Enums\GymSubscriptionStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Throwable;

class GymSubscription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'subscription_name',
        'amount',
        'validity',
        'description',
        'gym_id',
        'status',
        'image',
        'start_date'
    ];


    public function createSubscription(array $subscriptionArray,int $gymId)
    {
        $this->create([
            'subscription_name' => $subscriptionArray['subscription_name'],
            'amount' => $subscriptionArray['amount'],
            'validity' => $subscriptionArray['validity'],
            'description' => $subscriptionArray['description'],
            'gym_id' => $gymId,
            'status' => GymSubscriptionStatusEnum::Active,
            'start_date' => $subscriptionArray['start_date']
        ]);
    }

    public function updateSubscription(array $updateSubscriptionArray, $imagePath, $uuid)
    {
        try {
            $subscription = $this->where('uuid', $uuid)->first();
            $subscription->update($updateSubscriptionArray);
            if (isset($imagePath)) {
                $subscription->update([
                    'image' => $imagePath
                ]);
            }
            return true;
        } catch (Throwable $th) {
            Log::error('[GymSubscription] [updateSubscription] Error updating Subscription: ' . $th->getMessage());
           return false;
        }

    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }


}
