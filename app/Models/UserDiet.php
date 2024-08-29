<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class UserDiet extends Model
{


    protected $fillable = ['user_id', 'day', 'meal_name', 'calories', 'protein', 'carbs', 'fats', 'gym_id', 'diet_id', 'goal', 'meal_type', 'diet_description', 'alternative_diet_description', 'is_completed'];

    public function addUserDiet(array $addDiet, $gym_id)
    {
        try {
            return $this->create([
                'gym_id'    => $gym_id,
                'user_id'   => $addDiet['user_id'],
                'meal_name' => $addDiet['meal_name'],
                'calories'  => $addDiet['calories'],
                'protein'   => $addDiet['protein'],
                'carbs'     => $addDiet['carbs'],
                'fats'      => $addDiet['fats'],
                'diet_id'   => $addDiet['diet_id'],
                'goal'      => $addDiet['goal'],
                'meal_type' => $addDiet['meal_type'],
                'diet_description' => $addDiet['diet_description'],
                'alternative_diet_description'  => $addDiet['alternative_diet_description'],
                'day'       =>  $addDiet['day']
            ]);
        } catch (\Throwable $e) {
            Log::error('[UserDiet][addUserDiet] Error adding gym detail: ' . $e->getMessage());
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
