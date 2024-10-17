<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class GoalWiseDiet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'diet_id',
        'goal_id' ,
        'user_lebel_id',
        'calories',
        'protein',
        'carbs',
        'fats',
        'day'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function diet()
    {
        return $this->belongsTo(Diet::class, 'diet_id');
    }
    
    public function goal()
    {
        return $this->belongsTo(Goal::class, 'goal_id');
    }
    
    public function addGoalWiseDiet(array $goalWiseDiet)
    {
        try {
            return $this->create([
                'diet_id'        => $goalWiseDiet['diet_id'],
                'goal_id'        => $goalWiseDiet['goal_id'],
                'user_lebel_id'  => $goalWiseDiet['user_lebel_id'],
                'calories'       => $goalWiseDiet['calories'],
                'protein'        => $goalWiseDiet['protein'],
                'carbs'          => $goalWiseDiet['carbs'],
                'fats'           => $goalWiseDiet['fats'],
                'day'            => $goalWiseDiet['day']
            ]);
        } catch (\Throwable $e) {
            Log::error('[GoalWiseDiet][addGoalWiseDiet] Error adding diet: ' . $e->getMessage());
        }
    }
}
