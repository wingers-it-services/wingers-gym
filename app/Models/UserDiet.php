<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class UserDiet extends Model
{
    

    protected $fillable = ['user_id', 'meal_name', 'calories', 'protein', 'carbs','fats', 'notes'];

    public function addUserDiet(array $addDiet)
    {
        try {
            return $this->create([
                'user_id' => $addDiet['user_id'],
                'meal_name' => $addDiet['meal_name'],
                'calories' => $addDiet['calories'],
                'protein' => $addDiet['protein'],
                'carbs' => $addDiet['carbs'],
                'fats' => $addDiet['fats'],
                'notes' => $addDiet['notes'],
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
