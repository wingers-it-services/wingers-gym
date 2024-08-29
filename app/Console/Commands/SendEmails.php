<?php

namespace App\Console\Commands;

use App\Models\GymUserSubscriptionsHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendEmails extends Command
{
    protected $signature = 'emails:send';
    protected $description = 'Insert data every 2 minutes';

    public function handle()
    {
        $insertedRow = GymUserSubscriptionsHistory::create([
            'gym_id' => 1,
            'user_id' => 1, 
            'subscription_id' => 2,
            'price' => 500
        ]);

        $this->info('Inserted a new subscription history record successfully!');
    }
}
