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

    protected $fillable = ['user_id', 'exercise_name', 'sets', 'reps', 'weight', 'notes'];

    public function addWorkout(array $addWorkout)
    {
        try {
            return $this->create([
                'user_id' => $addWorkout['user_id'],
                'exercise_name' => $addWorkout['exercise_name'],
                'sets' => $addWorkout['sets'],
                'reps' => $addWorkout['reps'],
                'weight' => $addWorkout['weight'],
                'notes' => $addWorkout['notes'],
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
