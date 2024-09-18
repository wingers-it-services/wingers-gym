<?php

namespace App\Models;

use App\Enums\GymSubscriptionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class UserSubscriptionHistory extends Model
{
    protected $fillable = [
        'gym_id',
        'user_id',
        'subscription_id',
        'original_transaction_id',
        'subscription_start_date',
        'subscription_end_date',
        'status',
        'amount',
        'coupon_id',
    ];

    public function subscription()
    {
        return $this->belongsTo(GymSubscription::class, 'subscription_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function buySubscription(array $subscription)
    {
        try {
            $user = auth()->user();
    
            // Fetch the subscription details from the subscriptions table
            $subscriptionDetails = GymSubscription::find($subscription['subscription_id']);
    
            if (!$subscriptionDetails) {
                throw new \Exception('Invalid subscription ID');
            }
    
            $startDate = now(); // Default to the current date
    
            // Check if `is_current` is 0, and fetch the user's last active subscription for this gym
            if (isset($subscription['is_current']) && $subscription['is_current'] == 0) {
                $lastActiveSubscription = $this
                    ->where('user_id', $user->id)
                    ->where('gym_id', $subscription['gym_id'])
                    ->where('status', GymSubscriptionStatusEnum::ACTIVE) // Assuming 'active' is the status for active subscriptions
                    ->orderBy('subscription_end_date', 'desc') // Get the latest active subscription
                    ->first();
    
                // If an active subscription exists, set its end date as the start date for the new subscription
                if ($lastActiveSubscription) {
                    $startDate = $lastActiveSubscription->subscription_end_date;
                }
            }
    
            // Calculate the end date based on the validity of the new subscription
            $endDate = $startDate->copy()->addMonths($subscriptionDetails->validity);
    
            // Create the subscription record
            $userSubscription = $this->create([
                'user_id'                 => $user->id,
                'gym_id'                  => $subscription['gym_id'],
                'subscription_id'         => $subscription['subscription_id'],
                'original_transaction_id' => $subscription['original_transaction_id'],
                'subscription_start_date' => $startDate,
                'subscription_end_date'   => $endDate,
                'status'                  => $subscription['status'],
                'amount'                  => $subscription['amount'] ?? 0,
                'coupon_id'               => $subscription['coupon_id'] ?? 0,
            ]);
    
            return $userSubscription;
    
        } catch (\Throwable $e) {
            Log::error('[UserSubscriptionHistory][buySubscription] Error buying subscription: ' . $e->getMessage());
            return false;
        }
    }
    
}
