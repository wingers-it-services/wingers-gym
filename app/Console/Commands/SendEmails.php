<?php

namespace App\Console\Commands;

use App\Models\GymUserSubscriptionsHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily emails';

    /**ssss
     * Execute the console command.
     */
    public function handle()
    {
        $deletedRows = GymUserSubscriptionsHistory::create([
            'gym_id' => 1,
            'user_id' => 1, // Example user_id
            'subscription_id' => 2,
            'price' => 500
        ]);

        $this->info("insert {$deletedRows} old subscription history records successfully!");
    }
}
