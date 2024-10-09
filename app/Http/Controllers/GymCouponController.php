<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\GymCoupon;
use App\Traits\SessionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class GymCouponController extends Controller
{
    use SessionTrait;
    protected $gymCoupon;
    protected $gym;
    
    public function __construct(GymCoupon $gymCoupon, Gym $gym)
    {
        $this->gymCoupon = $gymCoupon;
        $this->gym = $gym;
    }

    public function listGymCoupons()
    {

        $coupons = $this->gymCoupon->all();
        return view('GymOwner.gym-coupon', compact('coupons'));
    }

    public function addGymCoupon(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "coupon_code" => 'required',
                "description" => 'required',
                "discount_type" => 'required',
                "start_date" => 'required',
                "end_date" => 'required',
                "status" => 'required'
            ]);

            $this->gymCoupon->addCoupon($validatedData);

            return redirect()->route('listGymCoupons')->with('status', 'success')->with('message', 'Data saved successfully.');
        } catch (\Throwable $th) {
            Log::error("[GymCouponController][addGymCoupon] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function viewGymCoupon(Request $request)
    {
        $uuid = $request->uuid;
        $gymCoupon = $this->gymCoupon->where('uuid', $uuid)->first();
        return view('GymOwner.GymCoupon.editGymCoupon', compact('gymCoupon'));
    }

    public function updateGymCoupon(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "coupon_id" => 'required',
                "coupon_code" => 'required',
                "description" => 'required',
                "discount_type" => 'required',
                "start_date" => 'required',
                "end_date" => 'required|after:start_date',
                "status" => 'required'
            ]);
            $coupon_id = $request->coupon_id;

            $isCouponUpdated = $this->gymCoupon->updateCoupon($validatedData, $coupon_id);
            if (!$isCouponUpdated) {
                return redirect()->back()->with('status', 'error')->with('message', 'error while updating coupon.');
            }
            return redirect()->back()->with('status', 'success')->with('message', 'coupon Updated successfully.');
        } catch (Throwable $th) {
            Log::error("[GymCouponController][updateGymCoupon] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function deleteGymCoupon($uuid)
    {
        $coupon = $this->gymCoupon->where('uuid', $uuid)->firstOrFail();
        $coupon->delete();

        return redirect()->back()->with('status', 'success')->with('message', 'Coupon Succesfully Deleted!');
    }
}

