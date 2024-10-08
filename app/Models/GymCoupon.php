<?php

namespace App\Models;

use App\Traits\SessionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Throwable;

class GymCoupon extends Model
{
    use SoftDeletes;
    use SessionTrait;

    protected $fillable = [
        'coupon_code',
        'description',
        'discount_type',
        'start_date',
        'end_date',
        'status',
        'gym_id'
    ];


    public function addCoupon(array $couponArray, int $gymId)
    {
        try {
            $this->create([
                'coupon_code' => $couponArray['coupon_code'],
                'description' => $couponArray['description'],
                'discount_type' => $couponArray['discount_type'],
                'start_date' => $couponArray['start_date'],
                'end_date' => $couponArray['end_date'],
                'status' => $couponArray['status'],
                'gym_id' => $gymId
            ]);
        } catch (Throwable $e) {
            dd($e);
            Log::error('[GymCoupon][addCoupon] Error while adding coupon detail: ' . $e->getMessage());
        }

    }

    public function updateCoupon(array $couponUpdateArray, $coupon_id)
    {
        $gymCoupon = GymCoupon::where('id', $coupon_id)->first();
        if (!$gymCoupon) {
            return redirect()->back()->with('error', 'coupon not found');
        }
        try {
            $gymCoupon->update([
                'coupon_code' => $couponUpdateArray['coupon_code'],
                'description' => $couponUpdateArray['description'],
                'discount_type' => $couponUpdateArray['discount_type'],
                'start_date' => $couponUpdateArray['start_date'],
                'end_date' => $couponUpdateArray['end_date'],
                'status' => $couponUpdateArray['status']
            ]);
            return $gymCoupon->save();
        } catch (Throwable $e) {
            Log::error('[GymCoupon][updateCoupon] Error while updating coupon detail: ' . $e->getMessage());
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
