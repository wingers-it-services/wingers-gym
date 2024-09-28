<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\GymSubscription;
use App\Models\MaintenanceVendor;
use App\Models\User;
use App\Models\UserSubscriptionHistory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MaintenanceVendorController extends Controller
{

    protected $maintenanceVendor;

    public function __construct(
        MaintenanceVendor $maintenanceVendor
    ) {
        $this->maintenanceVendor = $maintenanceVendor;
    }

    public function listVendor()
    {
        $gym = Auth::guard('gym')->user();
        $gymId = Gym::where('uuid', $gym->uuid)->first()->id;

        $vendors = $this->maintenanceVendor->get();

        return view('GymOwner.maintenance-vendor', compact('vendors'));
    }


    public function addMaintenanceVendor(Request $request)
    {
        try {
            $request->validate([
                'name'       => 'required',
                'phone_no'   => 'required',
                'occupation' => 'required',
                'image'      => 'nullable',
                'address'    => 'required',
            ]);

            $this->maintenanceVendor->vendorMaintenance($request->all());

            return back()->with('status', 'success')->with('message', 'Vendor Added Succesfully');
        } catch (Exception $e) {
            Log::error('[MaintenanceVendorController][addMaintenanceVendor]Error adding : ' . 'Request=' . $e->getMessage());
            return back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }

    public function updateMaintenanceVendor(Request $request)
    {
        try {
            $request->validate([
                'name'       => 'required',
                'phone_no'   => 'required',
                'occupation' => 'required',
                'image'      => 'nullable',
                'address'    => 'required',
            ]);

            $vendor = $this->maintenanceVendor->where('uuid', $request->uuid)->first();
            $imagePath = $vendor->image;

            if ($request->hasFile('image')) {
                if ($vendor->image) {
                    $existingImagePath = public_path($vendor->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }
                $imagefile = $request->file('image');
                $filename = time() . '_' . $imagefile->getClientOriginalName();
                $imagePath = 'vendor_maintenance_images/' . $filename;
                $imagefile->move(public_path('vendor_maintenance_images/'), $filename);
            }

            $data = $request->all();

            $isVendorUpdate = $this->maintenanceVendor->updateVendor($data, $imagePath);

            if (!$isVendorUpdate) {
                return redirect()->back()->with('status', 'error')->with('message', 'error while updating vendor.');
            }
            return redirect()->back()->with('status', 'success')->with('message', 'Vendor Updated successfully.');
        } catch (Exception $e) {
            Log::error('[MaintenanceVendorController][updateMaintenanceVendor] Error updating vendor ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'error while updating vendor.');
        }
    }

    public function deleteMaintenanceVendor($uuid)
    {
        $vendor = $this->maintenanceVendor->where('uuid', $uuid)->firstOrFail();

        $vendor->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'Vendor deleted successfully!');
    }
}
