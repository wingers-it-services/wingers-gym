<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class CurrentDayWorkout extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'workout_id',
        'user_workout_id',
        'gym_id',
        'user_id',
        'details'
    ];

    public function workoutDetails()
    {
        return $this->belongsTo(Workout::class, 'workout_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function updateCurrentWorkout(array $updateCurrentDayDetails)
    {
        $currentDayWorkout = $this->where('id', $updateCurrentDayDetails['current_day_workout_id'])->first();

        // Check if the user exists
        if (!$currentDayWorkout) {
            return redirect()->back()->with('error', 'Workout Details not found');
        }

        try {
            $currentDayWorkout->update([
                'details' => $updateCurrentDayDetails['details'],
            ]);

            return $currentDayWorkout->save();
        } catch (\Throwable $e) {
            Log::error('[Gym][updateGym] Error while updating gym detail: ' . $e->getMessage());
        }

    }
}
