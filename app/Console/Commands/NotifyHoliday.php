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
            // Find users associated with the gym from gym_user_gym table and load their FCM tokens
            $gymUsers = GymUserGym::with('user.fcmTokens') // Load user and their FCM tokens
                ->where('gym_id', $holiday->gym_id)
                ->get();
    
            foreach ($gymUsers as $gymUser) {
                $user = $gymUser->user; // Access the related user
    
                if ($user) {
                    $title = 'Gym Holiday Notification';
                    $message = 'Dear ' . $user->firstname . ', tomorrow (' . $holiday->date . ') is a holiday at your gym (' . $holiday->holiday_name . '). Enjoy your day off!';
    
                    // Loop through each of the user's FCM tokens and send the notification
                    foreach ($user->fcmTokens as $fcmToken) {
                        if ($fcmToken->fcm_token) {
                            // Send notification with the token as the target, not as part of the message
                            $this->notificationService->sendNotification($title, $message, null, $fcmToken->fcm_token);
                            Log::info('Holiday notification sent to user ID ' . $user->id . ' with token ' . $fcmToken->fcm_token);
                        }
                    }
                } else {
                    Log::warning('User not found for user ID ' . $gymUser->user_id);
                }
            }
        }
    
        $this->info('Notifications for tomorrow\'s gym holidays have been sent.');
    }
    
    
    
    
}
