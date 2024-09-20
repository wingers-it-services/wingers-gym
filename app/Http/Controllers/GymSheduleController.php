<?php

namespace App\Http\Controllers;

use App\Enums\WeekDaysEnum;
use App\Models\GymShedule;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GymSheduleController extends Controller
{

    protected $gymShedule;

    public function __construct(GymShedule $gymShedule)
    {
        $this->gymShedule = $gymShedule;
    }

    public function addGymShedule(Request $request)
    {
        try {
            $validated = $request->validate([
                'event_name'   => 'required|string|max:255',
                'date'         => 'required_if:is_recurring,0', // For non-recurring
                'week_days'    => 'required_if:is_recurring,1|array', // For recurring
                'week_days.*'  => 'integer|between:1,7',
                'start_time'   => 'required|date_format:H:i',
                'end_time'     => 'required|date_format:H:i|after:start_time',
                'is_recurring' => 'required|boolean',
                'description'  => 'required|string',
            ]);

            $this->gymShedule->addShedule($request->all());

            return redirect()->back()->with('status', 'success')->with('message', 'Schedule added successfully.');
        } catch (Exception $e) {
            Log::error("[GymSheduleController][addGymShedule] error " . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error while adding schedule.');
        }
    }




    public function fetchSchedule(Request $request)
    {
        $schedules = GymShedule::all();  // Assuming GymSchedule model is used for schedule data

        $data = $schedules->flatMap(function ($schedule) {
            // Check if the schedule is recurring
            if ($schedule->is_recurring) {
                // Generate occurrences for the next 4 weeks
                return collect(range(0, 3))->map(function ($weekOffset) use ($schedule) {
                    // Get the next occurrence of the specified weekday
                    $nextDate = $this->getNextOccurrence($schedule->week_day, $weekOffset);
                    return [
                        'title' => $schedule->event_name,  // Recurring event is a "Meeting"
                        'start' => $nextDate . ' ' . $schedule->start_time,
                        'end' => $nextDate . ' ' . $schedule->end_time,
                        'className' => 'bg-info',
                        'is_recurring' => true
                    ];
                });
            } else {
                // Non-recurring event is a "Conference"
                return [
                    [
                        'title' => 'Conference',
                        'start' => $schedule->date . ' ' . $schedule->start_time,  // Combine date and time
                        'end' => $schedule->date . ' ' . $schedule->end_time, // Combine date and time
                        'className' => 'bg-danger',
                        'is_recurring' => false
                    ]
                ];
            }
        });

        return response()->json($data);
    }

    private function getNextOccurrence($weekDay, $weekOffset)
    {
        // Use the enum constants to map the weekdays
        $weekDayMap = [
            WeekDaysEnum::SUNDAY    => Carbon::SUNDAY,
            WeekDaysEnum::MONDAY    => Carbon::MONDAY,
            WeekDaysEnum::TUESDAY   => Carbon::TUESDAY,
            WeekDaysEnum::WEDNESDAY => Carbon::WEDNESDAY,
            WeekDaysEnum::THURSDAY  => Carbon::THURSDAY,
            WeekDaysEnum::FRIDAY    => Carbon::FRIDAY,
            WeekDaysEnum::SATURDAY  => Carbon::SATURDAY,
        ];
    
        // Get the next occurrence of the given weekday number, adjusted for week offset
        $date = Carbon::now()->addWeeks($weekOffset);
        return $date->next($weekDayMap[$weekDay])->toDateString();
    }
    
}
