<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class UserNotification extends Model
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
            Log::error('[UserNotification][addNotification] Error creating user notification detail: ' . $e->getMessage());
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
