<?php

namespace App\Models;

use App\Enums\AdminSubscriptionStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Throwable;

class AdminSubscriptionPlan extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'validity',
        'description',
        'start_date'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function createSubscription(array $addSubscription)
    {
        try {
            return $this->create([
                'name'  => $addSubscription['name'],
                'price'             => $addSubscription['price'],
                'validity'           => $addSubscription['validity'],
                'description'            => $addSubscription['description'],
                'start_date'         => $addSubscription['start_date'],
            ]);
        } catch (\Throwable $e) {
            Log::error('[AdminSubscriptionPlan][createSubscription] Error adding admin subscription: ' . $e->getMessage());
        }
    }

    public function updateAdminSubscription(array $validatedData, $uuid)
    {
        $subcriptionDetail = AdminSubscriptionPlan::where('uuid', $uuid)->first();
        if (!$subcriptionDetail) {
            return redirect()->back()->with('error', 'suscription not found');
        }
        try {
            $updateData = [
                "name"           => $validatedData['name'],
                "price"          => $validatedData['price'],
                "validity"          => $validatedData['validity'],
                "description"         => $validatedData['description'],
                "start_date"        => $validatedData['start_date']
            ];


            $subcriptionDetail->update($updateData);

            return $subcriptionDetail->save();
        } catch (Throwable $e) {
            Log::error('[User][updateUser] Error while updating user detail: ' . $e->getMessage());
        }
    }

}
