<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class GymShedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'event_name',
        'week_day',
        'start_time',
        'end_time',
        'is_recurring',
        'description'
    ];

    public function addShedule(array $scheduleDetails)
    {
        try {
            $gym = Auth::guard('gym')->user();
            // Check if the schedule is recurring
            if (isset($scheduleDetails['is_recurring']) && $scheduleDetails['is_recurring'] == 1) {
                // Check if week days are selected
                if (isset($scheduleDetails['week_days']) && is_array($scheduleDetails['week_days'])) {
                    $entries = [];
                    // Iterate over each selected week day
                    foreach ($scheduleDetails['week_days'] as $weekDay) {


                        $entries[] = [
                            'uuid'         => (string) Str::uuid(),
                            'gym_id'       => $gym->id,
                            'event_name'   => $scheduleDetails['event_name'],
                            'week_day'     => $weekDay,
                            'start_time'   => $scheduleDetails['start_time'],
                            'end_time'     => $scheduleDetails['end_time'],
                            'is_recurring' => $scheduleDetails['is_recurring'],
                            'description'  => $scheduleDetails['description'],
                        ];
                    }

                    // Insert all entries at once
                    return $this->insert($entries);
                } else {
                    throw new \Exception('No week days selected for recurring schedule.');
                }
            } else {
                // Non-recurring schedule - single entry
                return $this->create([
                    'gym_id'       => $gym->id,
                    'event_name'   => $scheduleDetails['event_name'],
                    'week_day'     => $scheduleDetails['week_day'],
                    'start_time'   => $scheduleDetails['start_time'],
                    'end_time'     => $scheduleDetails['end_time'],
                    'is_recurring' => $scheduleDetails['is_recurring'],
                    'description'  => $scheduleDetails['description'],
                ]);
            }
        } catch (\Exception $e) {
            Log::error('[GymShedule][addShedule] Error adding schedule: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
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
