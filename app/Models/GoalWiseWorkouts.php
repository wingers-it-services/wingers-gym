<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class GoalWiseWorkouts extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'workout_id',
        'goal_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class, 'workout_id');
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class, 'goal_id');
    }

    public function addGoalWiseWorkout(array $goalWiseWorkout)
    {
        try {
            return $this->create([
                'workout_id'  => $goalWiseWorkout['workout_id'],
                'goal_id'     => $goalWiseWorkout['goal_id']
            ]);
        } catch (\Throwable $e) {
            Log::error('[GoalWiseWorkouts][addGoalWiseWorkout] Error adding goal: ' . $e->getMessage());
        }
    }
}
