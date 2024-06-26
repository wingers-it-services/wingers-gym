<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class GymNotification extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function addGymNotification(array $addNotification)
    {
        try {
            return $this->create([
                'name'      => $addNotification['name'],
                'description'      => $addNotification['description'],
                
            ]);
        } catch (\Throwable $e) {
            Log::error('[GymNotification][addGymNotification] Error creating gym notification detail: ' . $e->getMessage());
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
