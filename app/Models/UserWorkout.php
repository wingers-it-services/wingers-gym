<?php

namespace App\Models;
use App\Traits\SessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class UserWorkout extends Model
{
    use SoftDeletes;
    use SessionTrait;

    protected $fillable = [
        'user_id',
        'workout_id',
        'day',
        'exercise_name',
        'sets',
        'reps',
        'weight',
        'workout_des',
        'gym_id',
        'is_completed'
    ];

    public function workoutDetails()
    {
        return $this->belongsTo(Workout::class, 'workout_id');
    }

    public function addWorkout(array $addWorkout, $gym_id)
    {
        try {
            return $this->create([
                'gym_id'        => $gym_id,
                'user_id'       => $addWorkout['user_id'],
                'workout_id'    => $addWorkout['workout_id'],
                'day'           => $addWorkout['day'],
                'exercise_name' => $addWorkout['exercise_name'],
                'sets'          => $addWorkout['sets'],
                'reps'          => $addWorkout['reps'],
                'weight'        => $addWorkout['weight'],
                'workout_des'   => $addWorkout['workout_des'],
            ]);
        } catch (\Throwable $e) {
            Log::error('[UserWorkout][addWorkout] Error adding gym detail: ' . $e->getMessage());
        }
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

}
