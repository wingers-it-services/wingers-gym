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
        'name',
        'from',
        'to',
        'amount',
        'discount',
        'max_amount',
        'type',
        'gym_id'
    ];


    public function addCoupon(array $couponArray)
    {
        $gym_uuid = $this->getGymSession()['uuid'];
        $gymId = Gym::where('uuid', $gym_uuid)->first();
        // dd('gym uuid : ' . $gym_uuid . ' Id : ' . $gymId->id);
        $this->create([
            'name' => $couponArray['name'],
            'from' => $couponArray['from'],
            'to' => $couponArray['to'],
            'amount' => $couponArray['amount'],
            'discount' => $couponArray['discount'],
            'max_amount' => $couponArray['max_amount'],
            'type' => $couponArray['type'],
            'gym_id' => $gymId->id
        ]);
    }

    public function updateCoupon(array $couponUpdateArray, $uuid)
    {
        $gymCoupon = GymCoupon::where('uuid', $uuid)->first();
        if (!$gymCoupon) {
            return redirect()->back()->with('error', 'coupon not found');
        }
        try {
            $gymCoupon->update([
                "name" =>  $couponUpdateArray['name'],
                "from" =>  $couponUpdateArray['from'],
                "to" =>  $couponUpdateArray['to'],
                "amount" => $couponUpdateArray['amount'] ,
                "discount" =>  $couponUpdateArray['discount'],
                "type" =>  $couponUpdateArray['type'],
                "max_amount" =>  $couponUpdateArray['max_amount']
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
