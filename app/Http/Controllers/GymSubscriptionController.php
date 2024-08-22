<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\GymSubscription;
use App\Models\User;
use App\Models\UserSubscriptionHistory;
use App\Traits\SessionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class GymSubscriptionController extends Controller
{
    use SessionTrait;
    protected $gymSubscription;
    protected $gym;
    protected $user;

    public function __construct(
        GymSubscription $gymSubscription,
        Gym $gym,
        User $user
    ) {
        $this->gymSubscription = $gymSubscription;
        $this->gym = $gym;
        $this->user = $user;
    }

    public function listSubscriptionPlan()
    {
        $gym = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

        // Get the total number of users in the gym
        $totalUsers = $this->user->where('gym_id', $gymId)->count();

        // Get the total number of users in the gym with active subscriptions
        $activeSubscriptionUsers = UserSubscriptionHistory::where('gym_id', $gymId)
            ->where('status', 1)  // Only consider active user subscriptions
            ->distinct('user_id')
            ->count('user_id');

        // Get user counts grouped by subscription_id with active user subscriptions
        $usersBySubscription = UserSubscriptionHistory::select('subscription_id', DB::raw('count(distinct user_id) as user_count'))
            ->where('gym_id', $gymId)
            ->where('status', 1)  // Only consider active user subscriptions
            ->groupBy('subscription_id')
            ->get();

        // Fetch all subscriptions ordered by their ID
        $subscriptions = $this->gymSubscription->where('gym_id', $gymId)
            ->orderBy('id') // Order by subscription ID
            ->get();

        $subscriptionDetails = [];

        foreach ($subscriptions as $subscription) {
            $subscriptionId = $subscription->id;

            // Get user count for the current subscription_id from active user subscriptions
            $userCount = $usersBySubscription->where('subscription_id', $subscriptionId)->first()->user_count ?? 0;

            // Calculate the percentage of users with this subscription_id relative to total users
            $percentage = $totalUsers > 0 ? ($userCount / $totalUsers) * 100 : 0;

            // Add the subscription details to the array
            $subscriptionDetails[] = [
                'subscription' => $subscription,
                'user_count' => $userCount,
                'percentage' => number_format($percentage, 2), // Format percentage to 2 decimal places
            ];
        }

        Log::info('Total Users: ' . $totalUsers);
        Log::info('Active Subscription Users: ' . $activeSubscriptionUsers);
        Log::info('Subscription Details: ' . json_encode($subscriptionDetails));

        return view('GymOwner.subscription-list', compact('subscriptionDetails', 'totalUsers'));
    }

    public function viewGymSubscription(Request $request)
    {
        $subscription = $this->gymSubscription->where('uuid', $request->uuid)->first();
        return view('GymOwner.GymSubscription.editSubscription', compact('subscription'));
    }

    public function createGymSubscriptionPlan(Request $request)
    {
        try {
            $gym = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

            $validatedData = $request->validate([
                'subscription_name' => 'required',
                'amount' => 'required',
                'validity' => 'required',
                'description' => 'required',
                'start_date' => 'required'
            ]);

            $this->gymSubscription->createSubscription($validatedData, $gymId);

            return redirect()->route('listSubscriptionPlan')->with('status', 'success')->with('message', 'Subscription added Successfully');
        } catch (Throwable $th) {
            Log::error("[GymSubscriptionController][createGymSubscriptionPlan] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function updateGymSubscription(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "uuid"  => 'required',
                'subscription_name' => 'required',
                'amount' => 'required',
                'validity' => 'required',
                'description' => 'required',
                'start_date' => 'required'
            ]);

            $uuid = $request->uuid;
            $updateSub = $this->gymSubscription->updateGymSubscription($validatedData, $uuid);

            if ($updateSub) {
                return redirect()->back()->with("status", "success")->with("message", "User Updated Succesfully");
            } else {

                return redirect()->back()->with('error', 'error while updating profile');
            }
        } catch (\Exception $th) {
            Log::error("[AdminUserController][updateUser] error " . $th->getMessage());
            // return redirect()->back()->with('error', $th->getMessage());
            return redirect()->back()->with('error', 'error while updating profile');
        }
    }

    public function deleteSubscription($uuid)
    {
        $plan = $this->gymSubscription->where('uuid', $uuid)->firstOrFail();

        $plan->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'Suscription deleted successfully!');
    }
}
