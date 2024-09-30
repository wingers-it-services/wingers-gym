<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class UserLatitudeAndLongitude extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function addLatLongDetails(array $addLatLong, $userId)
    {
        try {
            return $this->updateOrCreate(
                ['user_id' => $userId],
                [
                    'latitude'  => $addLatLong['latitude'],
                    'longitude' => $addLatLong['longitude'],
                ]
            );
        } catch (\Throwable $e) {
            Log::error('[UserLatitudeAndLongitude][addLatLongDetails] Error adding or updating latitude and longitude: ' . $e->getMessage());
            return false;
        }
    }
}
