<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class UserSubscriptionPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'orderId',
        'name',
        'user_id',
        'gym_id',
        'email',
        'mobile',
        'response_code',
        'merchantId',
        'transectionId',
        'amount',
        'subscription_id',
        'total',
        'coupon_id',
        'providerReferenceId',
        'responseData',
        'invoice',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(GymSubscription::class, 'subscription_id');
    }

    public function newOrder(array $orderData)
    {
        $lastOrderId = $this->latest('id')->value('id');
        // $orderId = $orderData['gym_id'] . 'WITSGYM' . ($lastOrderId + 1);
        return $this->create([
            "total"              => $orderData['subtotal'] ?? 0,
            "amount"             => $orderData['amount'],
            "responseData"       => $orderData['response'],
            "response_code"      => $orderData['response_code'],
            "merchantId"         => $orderData['merchantId'],
        ]);
    }
}
