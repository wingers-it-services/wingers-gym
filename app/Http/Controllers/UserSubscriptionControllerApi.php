<?php

namespace App\Http\Controllers;

use App\Models\UserSubscriptionHistory;
use App\Traits\errorResponseTrait;
use Illuminate\Support\Facades\Log;

class UserSubscriptionControllerApi extends Controller
{
    use errorResponseTrait;
    protected $userSubscriptionHistory;

    public function __construct(
        UserSubscriptionHistory $userSubscriptionHistory,
    ) {
        $this->userSubscriptionHistory = $userSubscriptionHistory;
    }

    public function fetchSubscription()
    {
        try {
            $user = auth()->user();
            $subscriptions = $this->userSubscriptionHistory->where('user_id',$user->id)->get();

            if ($subscriptions->isEmpty()) {
                return response()->json([
                    'status'        => 422,
                    'subscriptions' => $subscriptions,
                    'message'       => 'There is no subscriptions'
                ], 200);
            }

            return response()->json([
                'status'         => 200,
                'subscriptions'  => $subscriptions,
                'message'        => 'User subscriptions Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserSubscriptionControllerApi][fetchSubscription]Error fetching subscriptions details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching subscriptions details: ' . $e->getMessage()
            ], 500);
        }
    }
}
