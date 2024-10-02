<?php

namespace App\Http\Controllers;

use App\Models\UserInjury;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InjuryController extends Controller
{

    protected $userInjury;

    public function __construct(
        UserInjury $userInjury
    ) {
        $this->userInjury = $userInjury;
    }

    public function viewAddInjury()
    {
        $status = null;
        $message = null;
        $injuries = $this->userInjury->get();
        return view('GymOwner.add-injury', compact('status', 'message', 'injuries'));
    }

    public function addInjury(Request $request)
    {
        try {
            $request->validate([
                'image'        => 'required',
                'injury_type'  => 'required',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $userImage = $request->file('image');
                $filename = time() . '_' . $userImage->getClientOriginalName();
                $imagePath = 'injury_images/' . $filename;
                $userImage->move(public_path('injury_images/'), $filename);
            }

            $this->userInjury->addInjury($request->all(), $imagePath);

            return redirect()->back()->with('status', 'success')->with('message', 'Injury added successfully.');
        } catch (\Throwable $th) {
            Log::error("[InjuryController][addInjury] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error adding injury. ' . $th->getMessage());
        }
    }

    public function updateInjury(Request $request)
    {
        try {
            $request->validate([
                'injury_type' => 'required',
                'image'       => 'nullable',
            ]);

            $injury = $this->userInjury->where('uuid', $request->uuid)->first();
            $imagePath = $injury->image;

            if ($request->hasFile('image')) {
                if ($injury->image) {
                    $existingImagePath = public_path($injury->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }
                $imagefile = $request->file('image');
                $filename = time() . '_' . $imagefile->getClientOriginalName();
                $imagePath = 'injury_images/' . $filename;
                $imagefile->move(public_path('injury_images/'), $filename);
            }

            $data = $request->all();

            $isVendorUpdate = $this->userInjury->updateInjury($data, $imagePath);

            if (!$isVendorUpdate) {
                return redirect()->back()->with('status', 'error')->with('message', 'error while updating injury.');
            }
            return redirect()->back()->with('status', 'success')->with('message', 'Injury Updated successfully.');
        } catch (Exception $e) {
            Log::error('[InjuryController][updateInjury] Error updating injury ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'error while updating injury.');
        }
    }

    public function deleteInjury($uuid)
    {
        $vendor = $this->userInjury->where('uuid', $uuid)->firstOrFail();

        $vendor->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'Injury deleted successfully!');
    }
}
