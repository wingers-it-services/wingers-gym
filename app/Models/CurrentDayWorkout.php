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
        'details',
        'is_completed'
    ];

    public function workoutDetails()
    {
        return $this->belongsTo(Workout::class, 'workout_id');
    }

    public function userWorkout()
    {
        return $this->belongsTo(UserWorkout::class, 'user_workout_id');
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

        if (!$currentDayWorkout) {
            return false;
        }

        try {
            // Decode the existing 'details' JSON field
            $details = json_decode($currentDayWorkout->details, true);

            // Update the specified set with new time and status
            if (!isset($details[$updateCurrentDayDetails['set']])) {
                return false; // or handle the error if the set does not exist
            }

            $details[$updateCurrentDayDetails['set']][0]['time'] = $updateCurrentDayDetails['time'];
            $details[$updateCurrentDayDetails['set']][0]['status'] = $updateCurrentDayDetails['status'];

            // Check if all sets are completed
            $allCompleted = true;
            foreach ($details as $set) {
                if ($set[0]['status'] !== 'completed') {
                    $allCompleted = false;
                    break;
                }
            }

            // Update the 'details' field in the current workout
            $currentDayWorkout->details = json_encode($details);

            // Save the updated workout
            $result = $currentDayWorkout->save();

            // If all sets are completed, update the is_complete field in the user_workout table
            if ($allCompleted) {
                $this->where('id', $updateCurrentDayDetails['current_day_workout_id'])
                    ->update(['is_completed' => 1]);
            }

            return $result;
        } catch (\Throwable $e) {
            Log::error('[CurrentDayWorkout][updateCurrentWorkout] Error while updating workout detail: ' . $e->getMessage());
            return false;
        }
    }
}
