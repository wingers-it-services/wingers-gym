<?php

namespace App\Models;

use App\Enums\EnquiryStatusEnum;
use App\Enums\InquiryStatusEnum;
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

    public function user()
    {
        return $this->belongsTo(User::class);
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
                'status'      => InquiryStatusEnum::SEND,
            ]);
        } catch (\Throwable $e) {
            Log::error('[UserInquiry][sendInquiry] Error adding inquiry detail: ' . $e->getMessage());
        }
    }
}
