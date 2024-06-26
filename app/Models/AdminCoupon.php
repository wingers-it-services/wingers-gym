<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class AdminCoupon extends Model
{
    protected $fillable = [
        'name',
        'from',
        'to',
        'image',
        'description'
    ];

    public function addAdminCoupon(array $couponArray, $imagePath)
    {
        try {
            return $this->create([
                'name' => $couponArray['name'],
                'from' => $couponArray['from'],
                'to' => $couponArray['to'],
                'image'   => $imagePath,
                'description' => $couponArray['description'],
            ]);
        } catch (\Throwable $e) {
            Log::error('[AdminSubscription][addAdminSubscription] Error adding admin subscription: ' . $e->getMessage());
        }
    }

    public function updateAdminCoupon(array $validatedData, $imagePath)
    {
        try {
            $uuid = $validatedData['uuid'];
            $couponDetail = AdminCoupon::where('uuid', $uuid)->first();
    
            // Check if the coupon exists
            if (!$couponDetail) {
                return false; // Return false or throw an exception if the coupon is not found
            }
    
            // Update the coupon details
            $couponDetail->update([
                'name' => $validatedData['name'],
                'from' => $validatedData['from'],
                'to' => $validatedData['to'],
                'description' => $validatedData['description'],
            ]);
    
            // Update the image path if provided
            if ($imagePath) {
                $couponDetail->image = $imagePath;
            }
    
            // Save the changes
            return $couponDetail->save();
        } catch (\Throwable $e) {
            Log::error('[AdminCoupon][updateAdminCoupon] Error while updating coupon detail: ' . $e->getMessage());
            return false; // Return false if an error occurs
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
