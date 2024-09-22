<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class UserInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gym_id',
        'reason',
        'description',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }


    public function sendInquiry(array $inquiry)
    {
        $user = auth()->user();
        
        try {
            return $this->create([
                'user_id'     => $user->id,
                'gym_id'      => $inquiry['gym_id'],
                'reason'      => $inquiry['reason'],
                'description' => $inquiry['description'],
                'status'      => $inquiry['status'],
            ]);
        } catch (\Throwable $e) {
            Log::error('[UserInquiry][sendInquiry] Error adding inquiry detail: ' . $e->getMessage());
        }
    }
}
