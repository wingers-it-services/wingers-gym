<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class StaffDocument extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['staff_id', 'aadhaar_card'];

    public function gymStaff()
    {
        return $this->belongsTo(GymStaff::class, 'staff_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
