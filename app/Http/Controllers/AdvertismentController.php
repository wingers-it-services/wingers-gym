<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdvertismentController extends Controller
{
    protected $advertisment;

    public function __construct(Advertisement $advertisment)
    {
        $this->advertisment = $advertisment;
    }

    public function viewGymAdvertisment()
    {
        $status = null;
        $message = null;
        $advertisments = $this->advertisment->all(); 

        return view('GymOwner.add-gym-advertisment', compact('status', 'message', 'advertisments'));
    }

    public function addAdvertisment(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "banner" => 'required',
                "ad_title" => 'required',
                "ad_link" => ['nullable', 'regex:/^(https?:\/\/)?([\w-]+(\.[\w-]+)+)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-])?$/'],
                "type" => 'required'
            ]);

            $imagePath = null;
            if ($request->hasFile('banner')) {
                $subscriptionImage = $request->file('banner');
                $filename = time() . '_' . $subscriptionImage->getClientOriginalName();
                $imagePath = 'Advertisments/' . $filename;
                $subscriptionImage->move(public_path('Advertisments/'), $filename);
            } else {
                log::error("[AdvertismentController][addAdvertisment] error imagefile is null");
            }

            $this->advertisment->addAdvertisment($validatedData, $imagePath);

            return redirect()->back()->with('status', 'success')->with('message', 'Advertisment Added successfully.');
        } catch (\Throwable $th) {
            Log::error("[AdvertismentController][addAdvertisment] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error occur during adding Ad. '.$th->getMessage());
        }
    }

    public function deleteAdvertisment($uuid)
    {
        $advertisment = $this->advertisment->where('uuid', $uuid)->firstOrFail();
        $advertisment->delete();

        return redirect()->back()->with('status', 'success')->with('message', 'Advertisment deleted successfully!');
    }
}
