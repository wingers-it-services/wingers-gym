<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function newOrder(array $orderData)
    {
        return $this->create([
            "orderId"            => $orderData['orderId'],
            "user_id"            => $orderData['userId'],
            "name"               => $orderData['name'],
            "email"              => $orderData['email'],
            "mobile"             => $orderData['mobile'],
            "subscription_id"    => $orderData['subscription_id'],
            "total"              => $orderData['subtotal'],
            "amount"             => $orderData['amount']
        ]);
    }
}
