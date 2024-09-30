<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Throwable;

class UserBodyMeasurement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'gym_id',
        'user_id',
        'bmi_id',
        'chest',
        'triceps',
        'biceps',
        'lats',
        'shoulder',
        'abs',
        'forearms',
        'traps',
        'glutes',
        'quads',
        'hamstring',
        'calves'
    ];

    public function createBodyMeasurement(array $bodyMeasurement, $userId, $gymId, $bmiId)
    {
        try {
            // Create the body measurement record with the bmi_id
            return  $this->create([
                'gym_id' => $gymId,
                'user_id' => $userId,
                'bmi_id' => $bmiId, // Add the bmi_id here
                'chest' => $bodyMeasurement['chest'],
                'triceps' => $bodyMeasurement['triceps'],
                'biceps' => $bodyMeasurement['biceps'],
                'lats' => $bodyMeasurement['lats'],
                'shoulder' => $bodyMeasurement['shoulder'],
                'abs' => $bodyMeasurement['abs'],
                'forearms' => $bodyMeasurement['forearms'],
                'traps' => $bodyMeasurement['traps'],
                'glutes' => $bodyMeasurement['glutes'],
                'quads' => $bodyMeasurement['quads'],
                'hamstring' => $bodyMeasurement['hamstring'],
                'calves' => $bodyMeasurement['calves']
            ]);
        } catch (\Throwable $th) {
            Log::error("[UserBodyMeasurement][createBodyMeasurement] error " . $th->getMessage());
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
