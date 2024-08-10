<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\GymSubscription;
use App\Traits\SessionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class GymSubscriptionController extends Controller
{
    use SessionTrait;
    protected $gymSubscription;
    protected $gym;

    public function __construct(GymSubscription $gymSubscription, Gym $gym)
    {
        $this->gymSubscription = $gymSubscription;
        $this->gym = $gym;
    }

    public function listSubscriptionPlan()
    {

        $gym = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

        $subscriptions = $this->gymSubscription->where('gym_id', $gymId)->get();
        return view('GymOwner.subscription-list', compact('subscriptions'));
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
