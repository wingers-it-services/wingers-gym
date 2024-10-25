<?php

namespace App\Console\Commands;

use App\Enums\GymSubscriptionStatusEnum;
use App\Models\UserSubscriptionHistory;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class NotifyExpiringSubscriptions extends Command
{
    protected $signature = 'notify:expiring-subscriptions';

    protected $description = 'Send notification to users when their subscription is 3 days away from expiring.';

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function handle()
    {
        $expiringDate = Carbon::now()->addDays(3)->format('Y-m-d');
    
        // Find subscriptions expiring in 3 days
        $expiringSubscriptions = UserSubscriptionHistory::where('subscription_end_date', $expiringDate)
            ->where('status', GymSubscriptionStatusEnum::ACTIVE) // Only active subscriptions
            ->get();
    
        foreach ($expiringSubscriptions as $subscription) {
            $user = $subscription->users; // Assuming you have a `user` relationship on the subscription model
    
            if ($user) {
                $title = 'Subscription Expiring Soon';
                $message = 'Dear ' . $user->firstname . ', your subscription will expire in 3 days on ' . $subscription->subscription_end_date . '. Please renew it to avoid service disruption.';
    
                // Loop through the user's FCM tokens and send a notification
                foreach ($user->fcmTokens as $fcmToken) {
                    if ($fcmToken->fcm_token) {
                        // Send notification passing the token
                        $this->notificationService->sendNotification($title, $message, null, $fcmToken->fcm_token);
                    }
                }
            }
        }
    
        $this->info('Notifications sent to users with expiring subscriptions.');
    }
    
}
