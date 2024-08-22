<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Cloth extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'category',
        'size',
        'brand_name',
        'quantity',
        'price',
        'material',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
