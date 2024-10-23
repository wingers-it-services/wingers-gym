<?php

namespace App\Console\Commands;

use App\Enums\AttendenceStatusEnum;
use App\Models\Gym;
use App\Models\GymUserAttendence;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DailyAttendenceUpdateCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:daily-attendence-update-cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;
        $today = $now->day;
        $currentDate = $now->format('Y-m-d');

        try {
            // Fetch all gyms
            $gyms = Gym::all();

            foreach ($gyms as $gym) {
                // Fetch holidays for the gym
                $holidays = Holiday::where('gym_id', $gym->id)
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->get();

                // Fetch all users for the gym
                $users = $gym->users; // Adjust if your relation is different

                foreach ($users as $user) {
                    // Fetch the attendance record for the current month
                    $attendance = GymUserAttendence::firstOrNew([
                        'gym_id' => $gym->id,
                        'gym_user_id' => $user->id,
                        'month' => $month,
                        'year' => $year
                    ]);
                    $weekendDays = $gym->weekends->pluck('weekend_day')->toArray(); // Array of weekend days (e.g., ['Saturday', 'Sunday'])

                    // Check if today's attendance field is null
                    $todayField = 'day' . $today;

                    if ($attendance->{$todayField} == 0) {
                        // Check if today is a holiday
                        $isHoliday = $holidays->where('date', $currentDate)->isNotEmpty();
                        $dayName = $now->format('l'); // Get the name of the day

                        // If today is Sunday or a holiday, don't mark absent
                        if (in_array($dayName, $weekendDays)) {
                            $attendance->{$todayField} = AttendenceStatusEnum::WEEKEND;
                        } elseif ($isHoliday) {
                            $attendance->{$todayField} = AttendenceStatusEnum::HOLIDAY;
                        } else {
                            // Mark user as absent if no attendance was recorded
                            $attendance->{$todayField} = AttendenceStatusEnum::ABSENT;
                        }
                    }

                    // Save the updated attendance record
                    $attendance->save();
                }
            }

            Log::info('Daily attendance update executed successfully before day end.');
        } catch (\Exception $e) {
            Log::error('Error during daily attendance update: ' . $e->getMessage());
        }
    }
}
