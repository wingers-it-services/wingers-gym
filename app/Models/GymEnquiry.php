<?php

namespace App\Models;

use App\Enums\EnquiryStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Throwable;

class GymEnquiry extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'status',
        'image',
        'gym_id'
    ];

    public function addGymEnquiry(array $gymEnquiryArray, $imagePath, $gymId)
    {
        try {
            $this->create([
                'title' => $gymEnquiryArray['title'],
                'description' => $gymEnquiryArray['description'],
                'image' => $imagePath,
                'status' => EnquiryStatusEnum::PENDING,
                'gym_id' => $gymId
            ]);
        } catch (Throwable $e) {
            Log::error('[GymEnquiry][addGymEnquiry] Error while updating coupon detail: ' . $e->getMessage());
        }
    }

    public function updateEnquiryStatus(array $validatedData, $uuid)
    {
        $gymEnquiry = GymEnquiry::where('uuid', $uuid)->first();
        try {
            $gymEnquiry->update([
                "status" =>  $validatedData['status']
            ]);
            return $gymEnquiry->save();
        } catch (Throwable $e) {
            Log::error('[GymCoupon][updateCoupon] Error while updating coupon detail: ' . $e->getMessage());
        }
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
