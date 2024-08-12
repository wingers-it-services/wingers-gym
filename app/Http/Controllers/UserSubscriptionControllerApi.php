<?php

namespace App\Http\Controllers;

use App\Models\GymSubscription;
use App\Models\UserSubscriptionHistory;
use App\Traits\errorResponseTrait;
use Illuminate\Support\Facades\Log;

class UserSubscriptionControllerApi extends Controller
{
    use errorResponseTrait;
    protected $userSubscriptionHistory;
    protected $gymSubscription;

    public function __construct(
        UserSubscriptionHistory $userSubscriptionHistory,
        GymSubscription $gymSubscription
    ) {
        $this->userSubscriptionHistory = $userSubscriptionHistory;
        $this->gymSubscription = $gymSubscription;
    }

    public function fetchSubscription()
    {
        try {
            
            $subscriptions = $this->gymSubscription->get();

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
                'message'        => 'Subscriptions Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserSubscriptionControllerApi][fetchSubscription]Error fetching subscriptions details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching subscriptions details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function fetchSubscriptionHistry()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'User not authenticated',
                ], 401);
            }
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
            Log::error('[UserSubscriptionControllerApi][fetchSubscriptionHistry]Error fetching subscriptions details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching subscriptions details: ' . $e->getMessage()
            ], 500);
        }
    }
}
