<?php

namespace App\Http\Controllers;

use App\Models\GymShedule;
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
                'week_day'     => 'required_if:is_recurring,0|integer|between:1,7', // For non-recurring
                'week_days'    => 'required_if:is_recurring,1|array', // For recurring
                'week_days.*'  => 'integer|between:1,7', 'start_time'   => 'required|date_format:H:i',
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


public function getSchedules()
{
    try {
        $schedules = GymShedule::all();
        
        $events = $schedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'title' => $schedule->event_name,
                'start' => $schedule->start_time,
                'end' => $schedule->end_time,
                'allDay' => false,
                'description' => $schedule->description,
                // Add other fields as needed
            ];
        });

        return response()->json($events);
    } catch (\Exception $e) {
        Log::error('[GymScheduleController][getSchedules] Error fetching schedules: ' . $e->getMessage());
        return response()->json(['error' => 'Unable to fetch schedules'], 500);
    }
}

}
