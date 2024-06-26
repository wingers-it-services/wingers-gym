<?php

namespace App\Http\Controllers;

use App\Models\AdminSubscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AdminSubscriptionController extends Controller
{

    private $adminSubscription;
    public function __construct(
        AdminSubscription $adminSubscription
    ) {
        $this->adminSubscription = $adminSubscription;
    }

    public function viewAddAdminSubscription()
    {
        $adminSubscriptions = $this->adminSubscription->all();
        return view('admin.subscription.addSubscription', compact('adminSubscriptions'));
    }

    public function addAdminSubscription(Request $request)
    {
        try {
            Validator::make($request->all(), []);
            $data = $request->all();
            $imagePath = null;
            if ($request->hasFile('image')) {
                $subscriptionImage = $request->file('image');
                $filename = time() . '_' . $subscriptionImage->getClientOriginalName();
                $imagePath = 'adminSubscription_images/' . $filename;
                $subscriptionImage->move(public_path('adminSubscription_images/'), $filename);
            }
            $this->adminSubscription->addAdminSubscription($data, $imagePath);
            return back()->with('status', 'success')->with('message', 'Subscription Added Succesfully');
        } catch (\Exception $e) {
            Log::error('[AdminSubscriptionController][addAdminSubscription]Error adding : ' . 'Request=' . $e->getMessage());
            return back()->with('status', 'error')->with('message', 'Subscription Not Added ');
        }
    }

    public function viewEditAdminSubscription(Request $request, $uuid)
    {
        $adminSubscription = $this->adminSubscription->where('uuid', $uuid)->first();

        return view('admin.subscription.editSubcription', compact('adminSubscription'));
    }

    public function updateAdminSubscription(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "uuid" => 'required',
                "subscription_name" => 'required',
                "validity" => 'required',
                "start_date" => 'required',
                "amount" => 'required',
                "plan_id" => 'required',
                "description" => 'required'
            ]);

            $uuid=$request->uuid;
            $imagePath = null;
            if ($request->hasFile('image')) {
                $subscriptionImage = $request->file('image');
                $filename = time() . '_' . $subscriptionImage->getClientOriginalName();
                $imagePath = 'adminSubscription_images/' . $filename;
                $subscriptionImage->move(public_path('adminSubscription_images/'), $filename);
            } 
            $updatedSubscription = $this->adminSubscription->updateAdminSubscription($validatedData, $imagePath, $uuid);
            if ($updatedSubscription) {
                return redirect()->route('viewAddAdminSubscription')->with("status", "success")->with("message", "Subscription Upated Succesfully");
            } else {
                return redirect()->back()->with('error', 'error while updating profile');
            }
        } catch (Throwable $th) {

            Log::error("[AdminSubscriptionController][updateAdminSubscription] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
