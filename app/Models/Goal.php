<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class Goal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'goal'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function goalWiseWorkouts()
    {
        return $this->hasMany(GoalWiseWorkouts::class, 'goal_id');
    }

    public function addGoal(array $goal)
    {
        try {
            return $this->create([
                'goal'  => $goal['goal']
            ]);
        } catch (\Throwable $e) {
            Log::error('[Goal][addGoal] Error adding goal: ' . $e->getMessage());
        }
    }

    public function updateGoal(array $updateGoal)
    {

        $goalDetails = $this->where('uuid', $updateGoal['uuid'])->first();

        if (!$goalDetails) {
            return redirect()->back()->with('error', 'Goal not found');
        }
        try {
            $goalDetails->update([
                'goal' => $updateGoal['goal'],
            ]);
            return $goalDetails->save();
        } catch (\Throwable $e) {
            Log::error('[Goal][updateGoal] Error while updating goal detail: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the goal details.');
        }
    }
}
