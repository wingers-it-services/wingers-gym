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
        'user_id',
        'age',
        'height',
        'weight',
        'bmi'
    ];

    public function createBmi(array $createBmiArray, $userId)
    {
        try {
            // dd($createBmiArray);
            $this->create([
                'user_id' => $userId,
                'age' => $createBmiArray['age'],
                'height' => $createBmiArray['height'],
                'weight' => $createBmiArray['weight'],
                'bmi'=> $createBmiArray['bmi']
            ]);
        } catch (Throwable $th) {
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
