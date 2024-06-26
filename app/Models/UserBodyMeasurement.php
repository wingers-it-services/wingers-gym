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
        'user_id',
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

    public function createBodyMeasurement(array $bodyodyMeasurement, $userId)
    {
       try {
        // dd($bodyodyMeasurement  );
        $this->create([
            'user_id' => $userId,
            'chest' => $bodyodyMeasurement['chest'],
            'triceps' => $bodyodyMeasurement['triceps'],
            'biceps' => $bodyodyMeasurement['biceps'],
            'lats' => $bodyodyMeasurement['lats'],
            'shoulder' => $bodyodyMeasurement['shoulder'],
            'abs' => $bodyodyMeasurement['abs'],
            'forearms' => $bodyodyMeasurement['forearms'],
            'traps' => $bodyodyMeasurement['traps'],
            'glutes' => $bodyodyMeasurement['glutes'],
            'quads' => $bodyodyMeasurement['quads'],
            'hamstring' => $bodyodyMeasurement['hamstring'],
            'calves' => $bodyodyMeasurement['calves']
        ]);
       } catch (Throwable $th) {
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
