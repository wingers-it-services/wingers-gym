<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner',
        'ad_title',
        'ad_link',
        'type'
    ];

    public function getBannerAttribute()
    {
        $imagePath = $this->attributes['banner'];
        $defaultImagePath = 'advertisement/nobanner.jpg';
        $fullImagePath = $imagePath;

        // Check if the file exists in the public directory
        if ($imagePath && file_exists(public_path($fullImagePath))) {
            return asset($fullImagePath);
        }

        return asset($defaultImagePath);
    }

    public function addAdvertisment(array $advertismentArray, $imagePath)
    {
        try {
            return $this->create([
                'ad_title'         => $advertismentArray['ad_title'],
                'ad_link'          => $advertismentArray['ad_link'],
                'type'             => $advertismentArray['type'],
                'banner'           => $imagePath
            ]);
        } catch (\Throwable $e) {
            Log::error('[Advertisement][addAdvertisment] Error adding Advertisement: ' . $e->getMessage());
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
