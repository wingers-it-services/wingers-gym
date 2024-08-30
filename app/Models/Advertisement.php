<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner'
    ];

    public function getBannerAttribute()
    {
        $imagePath = $this->attributes['banner'];
        $defaultImagePath = 'images/profile/17.jpg';
        $fullImagePath = $imagePath;

        // Check if the file exists in the public directory
        if ($imagePath && file_exists(public_path($fullImagePath))) {
            return asset($fullImagePath);
        }

        return asset($defaultImagePath);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
