<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\AdminCoupon;
use Exception;
use Throwable;

class AdminCouponController extends Controller
{
    protected $adminCoupon;

    public function __construct(AdminCoupon $adminCoupon)
    {
        $this->adminCoupon = $adminCoupon;
    }
    public function viewAdminCoupons()
    {
        $status = null;
        $message = null;
        $adminCoupons = $this->adminCoupon->all();
        return view('admin.adminCoupon.createListAdminCoupon', compact('status', 'message', 'adminCoupons'));
    }

    public function addAdminCoupon(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'from' => 'required|date',
                'to' => 'required|date',
                'image' => 'required|image',
                'description' => 'required',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $userImage = $request->file('image');
                $filename = time() . '_' . $userImage->getClientOriginalName();
                $imagePath = 'admin_coupon_images/' . $filename;
                $userImage->move(public_path('admin_coupon_images/'), $filename);
            }

            // Assuming you have a method addCoupon in your GymCoupon model
            $this->adminCoupon->addAdminCoupon($validatedData, $imagePath);

            return redirect()->back()->with('success', 'Coupon added successfully.');
        } catch (\Throwable $th) {
            Log::error("[AdminCouponController][addAdminCoupon] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function editViewCoupon(Request $request)
    {
        $uuid = $request->uuid;
        $adminCoupon = $this->adminCoupon->where('uuid', $uuid)->first();

        return view('admin.adminCoupon.editAdminCoupon', compact('adminCoupon'));
    }

    public function updateAdminCoupon(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'uuid' => 'required',
                'name' => 'required',
                'from' => 'required|date',
                'to' => 'required|date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example image validation rules
                'description' => 'required',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $gymImage = $request->file('image');
                if ($gymImage->isValid()) {
                    $filename = time() . '_' . $gymImage->getClientOriginalName();
                    $imagePath = 'admin_coupon_images/' . $filename;
                    $gymImage->move(public_path('admin_coupon_images/'), $filename);
                } else {
                    return redirect()->back()->with('status', 'error')->with('message', 'Error uploading image.');
                }
            }

            $couponUpdated = $this->adminCoupon->updateAdminCoupon($validatedData, $imagePath);
            
            if (!$couponUpdated) {
                return redirect()->back()->with('status', 'error')->with('message', 'Error while updating coupon.');
            }
            return redirect()->route('viewAdminCoupons')->with('status', 'success')->with('message', 'Coupon updated successfully.');
        } catch (\Exception $e) {
            Log::error('[AdminCouponController][updateAdminCoupon] Error updating coupon: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error while updating coupon.');
        }
    }

    public function deleteCoupon($uuid)
    {
        $adminCoupon = $this->adminCoupon->where('uuid', $uuid)->firstOrFail();
        $adminCoupon->delete();
        return redirect()->route('viewAdminCoupons')->with('success', 'Coupon deleted successfully!');
    }
}
