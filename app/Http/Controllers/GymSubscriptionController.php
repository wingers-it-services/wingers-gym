<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\GymSubscription;
use App\Traits\SessionTrait;
use Illuminate\Http\Request;
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

        $gym_uuid = $this->getGymSession()['uuid'];
        $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;

        $subscriptions = $this->gymSubscription->where('gym_id', $gymId)->get();
        return view('GymOwner.subscription-list', compact('subscriptions'));
    }

    public function viewGymSubscription(Request $request)
    {
        $subscription = $this->gymSubscription->where('uuid', $request->uuid)->first();
        return view('GymOwner.GymSubscription.editSubscription', compact('subscription'));
    }


    public function updateGymSubscriptionPlan(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "uuid" => 'required',
                "subscription_name" => 'required',
                "validity" => 'required',
                "start_date" => 'required',
                "amount" => 'required',
                "description" => 'required'
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $subscriptionImage = $request->file('image');
                $filename = time() . '_' . $subscriptionImage->getClientOriginalName();
                $imagePath = 'gymSubscription_images/' . $filename;
                $subscriptionImage->move(public_path('gymSubscription_images/'), $filename);
            } else {
                Log::error("[GymSubscriptionController][updateGymSubscriptionPlan] error imagefile is null");
            }
            $updatedSubscription = $this->gymSubscription->updateSubscription($validatedData, $imagePath, $request->uuid);
            if ($updatedSubscription) {
                return redirect()->route('listSubscriptionPlan')->with("status", "success")->with("message", "Subscription upated succesfully");
            } else {
                return redirect()->back()->with('error', 'error while updating profi');
            }
        } catch (Throwable $th) {
            Log::error("[GymSubscriptionController][updateGymSubscriptionPlan] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function createGymSubscriptionPlan(Request $request)
    {
        try {
            $gym_uuid = $this->getGymSession()['uuid'];
            $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;

            $validatedData = $request->validate([
                'subscription_name' => '',
                'amount' => 'required',
                'validity' => 'required',
                'description' => 'required',
                'start_date' => 'required'
            ]);

            $this->gymSubscription->createSubscription($validatedData, $gymId);

            return redirect()->route('listSubscriptionPlan')->with('status', 'success')->with('message', 'Data saved successfully.');
        } catch (Throwable $th) {
            dd($th);
            Log::error("[GymSubscriptionController][createGymSubscriptionPlan] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
