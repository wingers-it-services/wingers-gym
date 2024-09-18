<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class DietAnalytic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'month',
        'year',
        'gym_id',
        'user_id',
        'diet_id',
        'user_diet_id',
        'total_fats',
        'total_fats_consumed',
        'total_carbs',
        'total_carbs_consumed',
        'total_protein',
        'total_protein_consumed',
        'total_calories',
        'total_calories_consumed',
        'fat_percentage',
        'carb_percentage',
        'protein_percentage',
        'calories_percentage'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
