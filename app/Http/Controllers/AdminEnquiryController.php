<?php

namespace App\Http\Controllers;
use App\Models\Gym;
use App\Models\GymEnquiry;
use App\Traits\SessionTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Throwable;

class AdminEnquiryController extends Controller
{

    use SessionTrait;
    protected $enquiry;
    protected $gym;

    public function __construct(Gym $gym, GymEnquiry $enquiry)
    {
        $this->gym = $gym;
        $this->enquiry = $enquiry;
    }

    public function listEnquiry()
    {
        $gym_uuid = $this->getGymSession()['uuid'];
        $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;
        $enquiries = $this->enquiry->where('gym_id', $gymId)->get();
        $gyms = $this->gym->get();

        return view('admin.listEnquiry', compact('enquiries','gyms'));
    }

    public function viewAdminEnquiry(Request $request, $uuid)
    {
        // $uuid = $request->input('uuid');
        $enquiryDetails = $this->enquiry->where('uuid', $uuid)->first();
        return view('admin.viewEnquiry', compact('enquiryDetails'));
    }

    public function updateStatus(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "uuid" => 'required',
                "status" => 'required',
            ]);
            $uuid=$request->uuid;

            $this->enquiry->updateEnquiryStatus($validatedData, $uuid);
            return redirect()->route('listEnquiry')->with('status', 'success')->with('message', 'coupon Updated successfully.');
        } catch (Throwable $th) {
            Log::error("[AdminEnquiryController][updateStatus] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
   
    }


}
