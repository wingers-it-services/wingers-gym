<?php

namespace App\Http\Controllers;

use App\Models\GymSubscription;
use App\Models\UserSubscriptionHistory;
use App\Traits\errorResponseTrait;
use Illuminate\Http\Request;
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

   /**
    * The function fetches gym subscriptions and returns a JSON response with the subscription details
    * or an error message if there is an issue.
    * 
    * @return The `fetchSubscription` function returns a JSON response with status, subscriptions data,
    * and a message.
    */
    public function fetchSubscription(Request $request)
    {
        try {
            $request->validate([
                'gym_id' => 'required',
            ]);
            $subscriptions = $this->gymSubscription->where('gym_id',$request->gym_id)->get();

            if ($subscriptions->isEmpty()) {
                return response()->json([
                    'status'        => 422,
                    'subscriptions' => $subscriptions,
                    'message'       => 'There is no subscriptions'
                ], 422);
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

   /**
    * The function fetches a user's subscription history and returns it in a JSON response, handling
    * authentication, empty subscriptions, and error cases.
    * 
    * @return The `fetchSubscriptionHistry` function returns a JSON response with the status,
    * subscriptions data, and a message based on the logic within the function.
    */
    public function fetchSubscriptionHistry(Request $request)
    {
        try {
            $request->validate([
                'gym_id' => 'required',
            ]);
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'User not authenticated',
                ], 401);
            }
            $subscriptions = $this->userSubscriptionHistory->with('subscription')
            ->where('user_id',$user->id)
            ->where('gym_id', $request->gym_id)->get();

            if ($subscriptions->isEmpty()) {
                return response()->json([
                    'status'        => 422,
                    'subscriptions' => $subscriptions,
                    'message'       => 'There is no subscriptions'
                ], 422);
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
