<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class Workout extends Model
{
    protected $fillable = [
        'gym_id',
        'image',
        'vedio_link',
        'name',
        'gender',
        'category',
        'description'
    ];

    public function addWorkout(array $workoutArray, $imagePath, $gymId)
    {
        try {
            return $this->create([
                'gym_id' => $gymId,
                'name' => $workoutArray['name'],
                'vedio_link' => $workoutArray['vedio_link'],
                'gender' => $workoutArray['gender'],
                'image'   => $imagePath,
                'description' => $workoutArray['description'],
                'category' => $workoutArray['category']
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
