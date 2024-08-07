<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class Diet extends Model
{
    protected $fillable = [
        'gym_id',
        'image',
        'name',
        'diet',
        'gender',
        'alternative_diet',
        'min_age',
        'max_age',
        'goal'
    ];


    public function addDiet(array $workoutArray, $imagePath, $gymId) 
    {
        try {
            return $this->create([
                'gym_id' => $gymId,
                'name' => $workoutArray['name'],
                'diet' => $workoutArray['diet'],
                'gender' => $workoutArray['gender'],
                'image'   => $imagePath,
                'alternative_diet' => $workoutArray['alternative_diet'],
                'min_age' => $workoutArray['min_age'],
                'max_age' => $workoutArray['max_age'],
                'goal' => $workoutArray['goal']
            ]);
        } catch (\Throwable $e) {
            Log::error('[Workout][addWorkout] Error adding workout: ' . $e->getMessage());
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