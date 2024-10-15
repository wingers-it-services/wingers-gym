<?php

namespace App\Http\Controllers;

use App\Enums\WeekDaysEnum;
use App\Models\Gym;
use App\Models\GymShedule;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class GymSheduleController extends Controller
{

    protected $gym;
    protected $gymShedule;

    public function __construct(Gym $gym, GymShedule $gymShedule)
    {
        $this->gymShedule = $gymShedule;
        $this->gym = $gym;
    }

    public function viewGymSchedule()
    {
        $gym = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;
        $gymShedule = $this->gymShedule->where('gym_id', $gymId)->get();
        return view('GymOwner.gym-calender', compact('gymShedule'));
    }

    public function addGymShedule(Request $request)
    {
        try {
            $validated = $request->validate([
                'event_name' => 'required|string|max:255',
                'date' => 'required_if:is_recurring,0', // For non-recurring
                'week_days' => 'required_if:is_recurring,1|array', // For recurring
                'week_days.*' => 'integer|between:1,7',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'is_recurring' => 'required|boolean',
                'description' => 'required|string',
            ]);

            $this->gymShedule->addShedule($request->all());

            return redirect()->back()->with('status', 'success')->with('message', 'Schedule added successfully.');
        } catch (Exception $e) {
            Log::error("[GymSheduleController][addGymShedule] error " . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error while adding schedule.' . $e->getMessage());
        }
    }




    public function fetchSchedule(Request $request)
    {
        $gym = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;
        $schedules = GymShedule::where('gym_id', $gymId)->get();  // Assuming GymSchedule model is used for schedule data

        // Get the total number of weeks remaining in the current year dynamically
        $currentDate = Carbon::now();
        $endOfYear = Carbon::now()->endOfYear();
        $remainingWeeks = $currentDate->diffInWeeks($endOfYear); // Weeks remaining until the end of the year

        $data = $schedules->flatMap(function ($schedule) use ($remainingWeeks) {
            // Check if the schedule is recurring
            if ($schedule->is_recurring) {
                // Generate occurrences for the next 4 weeks
                return collect(range(0, $remainingWeeks))->map(function ($weekOffset) use ($schedule) {
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
                return [
                    [
                        'title' => $schedule->event_name,
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
            WeekDaysEnum::SUNDAY => Carbon::SUNDAY,
            WeekDaysEnum::MONDAY => Carbon::MONDAY,
            WeekDaysEnum::TUESDAY => Carbon::TUESDAY,
            WeekDaysEnum::WEDNESDAY => Carbon::WEDNESDAY,
            WeekDaysEnum::THURSDAY => Carbon::THURSDAY,
            WeekDaysEnum::FRIDAY => Carbon::FRIDAY,
            WeekDaysEnum::SATURDAY => Carbon::SATURDAY,
        ];

        // Get the next occurrence of the given weekday number, adjusted for week offset
        $date = Carbon::now()->addWeeks($weekOffset);

        return $date->next($weekDayMap[$weekDay])->toDateString();
    }

    public function getEvent($id)
    {
        $event = $this->gymShedule->find($id);

        if ($event) {
            // Optionally include week_days if recurring is true
            $weekDays = $event->is_recurring ? explode(',', $event->week_days) : [];

            return response()->json([
                'id' => $event->id,
                'event_name' => $event->event_name,
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'date' => $event->date,
                'description' => $event->description,
                'is_recurring' => $event->is_recurring,
                'week_days' => $weekDays,
            ]);
        }

        return response()->json(['message' => 'Event not found'], 404);
    }

    public function updateGymShedule(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'event_id' => 'required', // Ensure the event exists
                'event_name' => 'required|string|max:255',
                'date' => 'required_if:is_recurring,0', // For non-recurring
                'week_days' => 'required_if:is_recurring,1|array', // For recurring
                'week_days.*' => 'integer|between:1,7',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'is_recurring' => 'required|boolean',
                'description' => 'required|string',
            ]);
            $event_id = $request->event_id;

            $isSheduleUpdated = $this->gymShedule->updateGymSchedule($validatedData, $event_id);
            if (!$isSheduleUpdated) {
                return redirect()->back()->with('status', 'error')->with('message', 'error while updating schedule.');
            }
            return redirect()->back()->with('status', 'success')->with('message', 'schedule Updated successfully.');
        } catch (Exception $e) {
            Log::error("[GymSheduleController][updateGymShedule] error " . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }


    public function deleteSchedule($id)
    {
        // Fetch the specific schedule by its ID
        $schedule = GymShedule::find($id);

        if ($schedule) {
            $schedule->delete(); // Call delete() on a single model instance
            return response()->json(['success' => true, 'message' => 'Event deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Event not found.'], 404);
        }
    }
}
