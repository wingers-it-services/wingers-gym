<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\GymEnquiry;
use App\Traits\SessionTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class GymEnquiryController extends Controller
{
    use SessionTrait;
    protected $enquiry;
    protected $gym;

    public function __construct(Gym $gym, GymEnquiry $enquiry)
    {
        $this->gym = $gym;
        $this->enquiry = $enquiry;
    }

    public function viewAddEnquiry()
    {
        $gym_uuid = $this->getGymSession()['uuid'];
        $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;
        $enquiries = $this->enquiry->where('gym_id', $gymId)->get();

        return view('GymOwner.addEnquiry', compact('enquiries'));
    }

    public function addGymEnquiry(Request $request)
    {
        // dd($request->all());
        $gym_uuid = $this->getGymSession()['uuid'];
        $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;

        try {
            $validatedData = $request->validate([
                "title" => 'required',
                "description" => 'required',
                "image" => 'nullable'
            ]);


            $imagePath = null;
            if ($request->hasFile('image')) {
                $subscriptionImage = $request->file('image');
                $filename = time() . '_' . $subscriptionImage->getClientOriginalName();
                $imagePath = 'gymEnquiry_images/' . $filename;
                $subscriptionImage->move(public_path('gymEnquiry_images/'), $filename);
            } else {
                log::error("[GymStaffController][addGymStaff] error imagefile is null");
            }

            $this->enquiry->addGymEnquiry($validatedData, $imagePath, $gymId);

            return redirect()->back()->with('success', 'Data saved successfully.');
        } catch (\Throwable $th) {
            Log::error("[GymEnquiryController][addGymEnquiry] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function viewEnquiry(Request $request, $uuid)
    {
        // $uuid = $request->input('uuid');
        $enquiryDetails = $this->enquiry->where('uuid', $uuid)->first();

        return view('GymOwner.viewEnquiry', compact('enquiryDetails'));
    }
    public function deleteEnquiry($uuid)
    {
        $enquiry = $this->enquiry->where('uuid', $uuid)->firstOrFail();
        $enquiry->delete();
        return redirect()->back()->with('success', 'Enquiry deleted successfully!');
    }
}
