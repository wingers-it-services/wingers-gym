<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class GymUserSubscriptionsHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gym_user_subscriptions_history';

    protected $fillable = [
        'user_id',
        'uuid',
        'subscription_id',
        'price',
        'buy_date',
        'expire_date',
        'isActive',
        'coupon_code',
        'original_transaction_id',
        'currency'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    // Define the relationships if needed
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscription()
    {
        return $this->belongsTo(GymSubscription::class, 'subscription_id');
    }

    /**
     * Deletes all subscription history records for the given user ID.
     *
     * @param int $userId The ID of the user to delete subscription history for.
     */
    public function deleteUserSubscriptionHistorys(int $userId): void
    {
        $this->where('user_id', $userId)->delete();
    }
}
