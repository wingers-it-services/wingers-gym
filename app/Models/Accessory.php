<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Accessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'category',
        'brand_name',
        'model_number',
        'description',
        'quantity',
        'price',
        'condition',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
