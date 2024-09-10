<?php

namespace App\Console\Commands;

use App\Enums\AttendenceStatusEnum;
use App\Models\Gym;
use App\Models\GymUserAttendence;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UserAttendence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:attendence';

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
                    // Fetch or create an attendance record for the user
                    $attendance = GymUserAttendence::firstOrNew([
                        'gym_id' => $gym->id,
                        'gym_user_id' => $user->id,
                        'month' => $month,
                        'year' => $year
                    ]);

                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                    // Initialize the attendance record for the month
                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        $date = Carbon::create($year, $month, $day);
                        $dayName = $date->format('l'); // Get the name of the day

                        // Check if it's a holiday
                        $isHoliday = $holidays->where('date', $date->format('Y-m-d'))->isNotEmpty();
                        
                        if ($dayName == 'Sunday') {
                            $attendance->{'day' . $day} = AttendenceStatusEnum::WEEKEND;
                        } elseif ($isHoliday) {
                            $attendance->{'day' . $day} = AttendenceStatusEnum::HOLIDAY;
                        } else {
                            $attendance->{'day' . $day} = 0;
                        }
                    }

                    // Save the updated attendance record
                    $attendance->save();
                }
            }

            Log::info('Monthly attendance update executed successfully.');
        } catch (\Exception $e) {
            Log::error('Error during monthly attendance update: ' . $e->getMessage());
        }
    
    }
}
