<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\AdminAdvertismentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class AdminAdvertisment extends Model
{
    protected $fillable = [
        'name',
        'from',
        'to',
        'image',
        'description',
        'users',
        'status'
    ];

    public function addAdminAdvertisment(array $validatedData, $imagePath)
    {
        try {
            return $this->create([
                'name' => $validatedData['name'],
                'from' => $validatedData['from'],
                'to' => $validatedData['to'],
                'image'   => $imagePath,
                'description' => $validatedData['description'],
                'users' => $validatedData['users'],
                'status' => $validatedData['status'],
            ]);
        } catch (\Throwable $e) {
            Log::error('[AdminSubscription][addAdminSubscription] Error adding admin advertisment: ' . $e->getMessage());
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
