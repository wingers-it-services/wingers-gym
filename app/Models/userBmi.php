<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Throwable;

class userBmi extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'gym_id',
        'user_id',
        'age',
        'height',
        'weight',
        'bmi'
    ];

    public function createBmi(array $createBmiArray, $userId, $gymId)
    {
        try {
            // dd($createBmiArray);
            $this->create([
                'gym_id' => $gymId,
                'user_id' => $userId,
                'height' => $createBmiArray['height'],
                'weight' => $createBmiArray['weight'],
                'bmi'=> $createBmiArray['bmi']
            ]);
        } catch (Throwable $th) {
            dd($th);
            Log::error("[Bmi][createBmi] error " . $th->getMessage());
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
