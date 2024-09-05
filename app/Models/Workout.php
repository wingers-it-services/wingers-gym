<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class Workout extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'image',
        'user_type',
        'vedio_link',
        'name',
        'gender',
        'category',
        'description',
        'added_by'
    ];

    public function currentDayWorkouts()
    {
        return $this->hasMany(CurrentDayWorkout::class, 'workout_id');
    }

    public function addWorkout(array $workoutArray, $imagePath, $addedBy)
    {
        try {
            return $this->create([
                'added_by'    => $addedBy,
                'name'        => $workoutArray['name'],
                'vedio_link'  => $workoutArray['vedio_link'],
                'gender'      => $workoutArray['gender'],
                'image'       => $imagePath,
                'description' => $workoutArray['description'],
                'category'    => $workoutArray['category'],
                'user_type'   => $workoutArray['user_type']
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
