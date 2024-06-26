<?php

namespace App\Models;

use App\Enums\AdminSubscriptionStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Throwable;

class AdminSubscription extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'status',
        'subscription_name',
        'amount',
        'validity',
        'description',
        'plan_id',
        'image',
        'start_date'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function addAdminSubscription(array $addSubscription, $imagePath)
    {
        // dd($addSubscription);
        try {
            return $this->create([
                'status'             => AdminSubscriptionStatusEnum::InActive,
                'subscription_name'  => $addSubscription['subscription_name'],
                'amount'             => $addSubscription['amount'],
                'validity'           => $addSubscription['validity'],
                'description'        => $addSubscription['description'],
                'plan_id'            => $addSubscription['plan_id'],
                'image'              => $imagePath,
                'start_date'         => $addSubscription['start_date'],
            ]);
        } catch (\Throwable $e) {
            Log::error('[AdminSubscription][addAdminSubscription] Error adding admin subscription: ' . $e->getMessage());
        }
    }

    public function updateAdminSubscription(array $updateSubscriptionArray, $imagePath, $uuid)
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
            Log::error('[AdminSubscription] [updateAdminSubscription] Error updating Subscription: ' . $th->getMessage());
           return false;
        }

    }

}
