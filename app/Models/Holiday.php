<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'holiday_name',
        'date'
    ];

    public function addHoliday(array $holidays, int $gymId)
    {
        $this->create([
            'gym_id' => $gymId,
            'holiday_name' =>  $holidays['holiday_name'],
            'date' => $holidays['date']
        ]);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
