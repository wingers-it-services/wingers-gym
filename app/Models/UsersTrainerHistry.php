<?php

namespace App\Models;


use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use Throwable;

class UsersTrainerHistry extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'gym_id',
        'user_id',
        'trainer_id',
        'status'
    ];

    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function trainer()
    {
        return $this->belongsTo(GymStaff::class, 'trainer_id');
    }

    public function addTrainer(array $gymTrainer, $gymId)
    {
        try {
            return $this->create([
                'gym_id'          => $gymId,
                'user_id'     => $gymTrainer['user_id'],
                'trainer_id'       => $gymTrainer['trainer_id'],
                'status'        => $gymTrainer['status']
            ]);
        } catch (Throwable $e) {
            Log::error("[UserBmiController][createUserBmi] error " . $e->getMessage());
        }
    }
}
