<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CurrentDayDiet extends Model
{
    protected $fillable = [
        'diet_id',
        'user_diet_id',
        'gym_id',
        'user_id',
        'details',
        'total_fats',
        'total_carbs',
        'total_protein',
        'total_calories'
    ];

    public function userDiet()
    {
        return $this->belongsTo(UserDiet::class, 'user_diet_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
