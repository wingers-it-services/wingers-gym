<?php
namespace App\Console\Commands;

use App\Enums\AttendenceStatusEnum;
use App\Enums\GymSubscriptionStatusEnum;
use App\Models\Gym;
use App\Models\GymUserAttendence;
use App\Models\Holiday;
use App\Models\UserSubscriptionHistory;
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
    protected $description = 'Update daily attendance for active subscribers';

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
                    // Check if the user has an active subscription for the current gym
                    $hasActiveSubscription = UserSubscriptionHistory::where('user_id', $user->id)
                        ->where('gym_id', $gym->id)
                        ->where('status',GymSubscriptionStatusEnum::ACTIVE) // Adjust the status value if needed
                        ->whereDate('subscription_end_date', '>=', $currentDate)
                        ->exists();

                    if (!$hasActiveSubscription) {
                        // Skip marking attendance for users without an active subscription
                        continue;
                    }

                    // Fetch the attendance record for the current month
                    $attendance = GymUserAttendence::firstOrNew([
                        'gym_id' => $gym->id,
                        'gym_user_id' => $user->id,
                        'month' => $month,
                        'year' => $year
                    ]);

                    $weekendDays = $gym->weekends->pluck('weekend_day')->toArray(); // Array of weekend days (e.g., ['Saturday', 'Sunday'])

                    // Check if today's attendance field is not already marked
                    $todayField = 'day' . $today;

                    if ($attendance->{$todayField} == 0) {
                        // Check if today is a holiday
                        $isHoliday = $holidays->where('date', $currentDate)->isNotEmpty();
                        $dayName = $now->format('l'); // Get the name of the day

                        // If today is a weekend or a holiday, mark accordingly
                        if (in_array($dayName, $weekendDays)) {
                            $attendance->{$todayField} = AttendenceStatusEnum::WEEKEND;
                        } elseif ($isHoliday) {
                            $attendance->{$todayField} = AttendenceStatusEnum::HOLIDAY;
                        } else {
                            // Mark user as absent if no attendance was recorded
                            $attendance->{$todayField} = AttendenceStatusEnum::ABSENT;
                        }
                    }

                    $attendance->save();
                }
            }

            Log::info('Daily attendance update executed successfully.');
        } catch (\Exception $e) {
            Log::error('Error during daily attendance update: ' . $e->getMessage());
        }
    }
}
