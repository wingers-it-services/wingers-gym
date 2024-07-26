<?php

namespace App\Http\Controllers;

use App\Models\AdminSubscriptionPlan;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AdminSubscriptionController extends Controller
{

    private $adminSubscription;
    public function __construct(
        AdminSubscriptionPlan $adminSubscription
    ) {
        $this->adminSubscription = $adminSubscription;
    }

    public function viewAddAdminSubscription()
    {
        $adminSubscriptions = $this->adminSubscription->all();
        return view('admin.admin-subscription', compact('adminSubscriptions'));
    }

    public function addAdminSubscription(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required',
                'price' => 'required',
                'validity' => 'required',
                'description' => 'required',
                'start_date' => 'required'
            ]);

            $this->adminSubscription->createSubscription($validatedData);

            return redirect()->back()->with('status', 'success')->with('message', 'Data saved successfully.');
        } catch (Throwable $th) {
            // dd($th);
            Log::error("[AdminSubscriptionController][addAdminSubscription] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function updateAdminSubscription(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "uuid"  => 'required',
                'name' => 'required',
                'price' => 'required',
                'validity' => 'required',
                'description' => 'required',
                'start_date' => 'required'
            ]);

            $uuid = $request->uuid;
            $updateSub = $this->adminSubscription->updateAdminSubscription($validatedData, $uuid);

            if ($updateSub) {
                return redirect()->back()->with("status", "success")->with("message", "User UpDated Succesfully");
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
        $plan = $this->adminSubscription->where('uuid', $uuid)->firstOrFail();
        $plan->delete();
        // return redirect()->back()->with('success', 'User deleted successfully!');
        return redirect()->back()->with("status", "success")->with("message", "Subscription deleted successfully!");
    }

}
