<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class Diet extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'gym_id',
        'image',
        'name',
        'diet',
        'gender',
        'alternative_diet',
        'min_age',
        'max_age',
        'added_by',
        'goal',
        'calories',
        'protein',
        'carbs',
        'fats'
    ];


    public function addDiet(array $dietArray, $imagePath, $gymId) 
    {
        try {
            return $this->create([
                'gym_id'           => $gymId,
                'name'             => $dietArray['name'],
                'diet'             => $dietArray['diet'],
                'gender'           => $dietArray['gender'],
                'image'            => $imagePath,
                'alternative_diet' => $dietArray['alternative_diet'],
                'min_age'          => $dietArray['min_age'],
                'max_age'          => $dietArray['max_age'],
                'goal'             => $dietArray['goal'],
                'calories'         => $dietArray['calories'],
                'protein'          => $dietArray['protein'],
                'carbs'            => $dietArray['carbs'],
                'fats'             => $dietArray['fats'],
                'added_by'      =>    1
            ]);
        } catch (\Throwable $e) {
            Log::error('[Diet][addDiet] Error adding diet: ' . $e->getMessage());
        }
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}