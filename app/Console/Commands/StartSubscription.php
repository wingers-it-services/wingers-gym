<?php

namespace App\Console\Commands;

use App\Enums\GymSubscriptionStatusEnum;
use App\Models\UserSubscriptionHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StartSubscription extends Command
{

    protected $signature = 'subscriptions:update-status';

    protected $description = 'Start new subscriptions and expire old ones for each user and gym at 12:01 AM';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = Carbon::now()->startOfDay();

        // Fetch all subscriptions that are scheduled to start today
        $subscriptions = UserSubscriptionHistory::where('subscription_start_date', $currentDate)->get();

        foreach ($subscriptions as $subscription) {
            // Set the new subscription as active
            $subscription->status = GymSubscriptionStatusEnum::ACTIVE;
            $subscription->save();

            // Expire all other subscriptions for the same user and gym
            UserSubscriptionHistory::where('user_id', $subscription->user_id)
                ->where('gym_id', $subscription->gym_id)
                ->where('id', '!=', $subscription->id) // Exclude the current active subscription
                ->update(['status' => GymSubscriptionStatusEnum::EXPIRE]);
        }

        $this->info('Subscriptions updated successfully!');
    }
}
