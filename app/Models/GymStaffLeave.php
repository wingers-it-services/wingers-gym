<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;


class GymStaffLeave extends Model
{
    protected $fillable = [
        'gym_id',
        'staff_id',
        'leave_type',
        'start_date',
        'end_date',
        'reason'
    ];

    public function addGymStaffLeave(array $staffLeaveArray, int $gymId)
    {
        try {
            $this->create([
                'staff_id' => $staffLeaveArray['staff_id'],
                'leave_type' => $staffLeaveArray['leave_type'],
                'start_date' => $staffLeaveArray['start_date'],
                'end_date' => $staffLeaveArray['end_date'],
                'reason' => $staffLeaveArray['reason'],
                'gym_id' => $gymId
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
