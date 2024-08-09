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


    public function createSubscription(array $subscriptionArray, int $gymId)
    {
        $this->create([
            'subscription_name' => $subscriptionArray['subscription_name'],
            'amount' => $subscriptionArray['amount'],
            'validity' => $subscriptionArray['validity'],
            'description' => $subscriptionArray['description'],
            'gym_id' => $gymId,
            'status' => GymSubscriptionStatusEnum::ACTIVE,
            'start_date' => $subscriptionArray['start_date']
        ]);
    }

    public function updateGymSubscription(array $validatedData, $uuid)
    {
        $subcriptionDetail = GymSubscription::where('uuid', $uuid)->first();
        if (!$subcriptionDetail) {
            return redirect()->back()->with('error', 'suscription not found');
        }
        try {
            $updateData = [
                "subscription_name"           => $validatedData['subscription_name'],
                "amount"          => $validatedData['amount'],
                "validity"          => $validatedData['validity'],
                "description"         => $validatedData['description'],
                "start_date"        => $validatedData['start_date']
            ];


            $subcriptionDetail->update($updateData);

            return $subcriptionDetail->save();
        } catch (Throwable $e) {
            Log::error('[GymSubscription][updateGymSubscription] Error while updating user detail: ' . $e->getMessage());
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
