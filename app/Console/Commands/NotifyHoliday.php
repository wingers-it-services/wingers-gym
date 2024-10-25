<?php

namespace App\Console\Commands;

use App\Models\GymUserGym;
use App\Models\Holiday;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class NotifyHoliday extends Command
{
    protected $signature = 'notify:holiday';
    protected $description = 'Notify users about gym holidays happening tomorrow';

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = Carbon::now()->addDay()->format('Y-m-d');
    
        // Fetch all holidays for tomorrow
        $holidays = Holiday::where('date', $tomorrow)->get();
    
        foreach ($holidays as $holiday) {
            // Get all users associated with the gym
            $gymUserIds = GymUserGym::where('gym_id', $holiday->gym_id)
                ->pluck('user_id')
                ->toArray();
    
            if (!empty($gymUserIds)) {
                $title = 'Gym Holiday Notification';
                $image = 'https://witsfitness.in/user_images/1723465377_splashscreen.png';
                $sound = 'https://commondatastorage.googleapis.com/codeskulptor-assets/Evillaugh.ogg';
    
                // Fetch users' names and send personalized notifications
                $users = User::whereIn('id', $gymUserIds)->get();
    
                foreach ($users as $user) {
                    $message = 'Dear ' . $user->firstname . ', tomorrow (' . $holiday->date . ') is a holiday at your gym (' . $holiday->holiday_name . '). Enjoy your day off!';
    
                    // Send notification to each user by their ID
                    $response = $this->notificationService->sendNotification($title, $message, [$user->id], $image, $sound);
    
                    if ($response['status']) {
                        Log::info('Holiday notification sent to ' . $user->firstname . ' (User ID ' . $user->id . ') for gym ID ' . $holiday->gym_id);
                    } else {
                        Log::error('Failed to send notification to ' . $user->firstname . ' (User ID ' . $user->id . ') - ' . $response['message']);
                    }
                }
            } else {
                Log::warning('No users found for gym ID ' . $holiday->gym_id);
            }
        }
    
        $this->info("Notifications for tomorrow's gym holidays have been sent.");
    }
    

}
