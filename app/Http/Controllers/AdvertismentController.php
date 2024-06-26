<?php

namespace App\Http\Controllers;

use App\Models\AdminAdvertisment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdvertismentController extends Controller
{
    protected $advertisment;

    public function __construct(AdminAdvertisment $advertisment)
    {
        $this->advertisment = $advertisment;
    }

    public function viewAdvertisment()
    {
        $status = null;
        $message = null;
        $advertisments = $this->advertisment->all(); 

        return view('admin.advertisment', compact('status', 'message', 'advertisments'));
    }

    public function addAdvertisment(Request $request)
    {
        // dd($request->all());

        try {
            $validatedData = $request->validate([
                "name" => 'required',
                "from" => 'required',
                "to" => 'required',
                "image" => 'required',
                "description" => 'required',
                "users" => 'required',
                "status" => 'required',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $subscriptionImage = $request->file('image');
                $filename = time() . '_' . $subscriptionImage->getClientOriginalName();
                $imagePath = 'adminAdversit_images/' . $filename;
                $subscriptionImage->move(public_path('adminAdversit_images/'), $filename);
            } else {
                log::error("[AdvertismentController][addAdvertisment] error imagefile is null");
            }
            $this->advertisment->addAdminAdvertisment($validatedData, $imagePath);

            return redirect()->back()->with('success', 'Advertisment Added successfully.');
        } catch (\Throwable $th) {
            Log::error("[AdvertismentController][addAdvertisment] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function viewAdminAdvertisment(Request $request, $uuid)
    {
        $status = null;
        $message = null;
        $advertisments = $this->advertisment->where('uuid', $uuid)->first();
        $status = $advertisments->status;

        return view('admin.viewAdvertisment', compact('status', 'message','advertisments'));
    }

    public function deleteAdvertisment($uuid)
    {
        $advertisment = $this->advertisment->where('uuid', $uuid)->firstOrFail();
        $advertisment->delete();
        return redirect()->route('viewAdvertisment')->with('success', 'Advertisment deleted successfully!');
    }
}
