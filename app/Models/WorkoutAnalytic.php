<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class WorkoutAnalytic extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'month',
        'year',
        'gym_id',
        'user_id',
        'workout_id',
        'user_workout_id',
        'total_sets',
        'total_sets_completed',
        'percentage',
        'targeted_body_part'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
