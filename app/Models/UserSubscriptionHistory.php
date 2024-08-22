<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

}
