<?php

namespace App\Http\Controllers;

use App\Models\GymGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GymGalleryController extends Controller
{
    protected $gymGallery;

    public function __construct(GymGallery $gymGallery)
    {
        $this->gymGallery = $gymGallery;
    }

    public function gymGalleryView()
    {
        $status = null;
        $message = null;
        $gymGalleryFiles=$this->gymGallery->get();
        return view('GymOwner.gym-gallery', compact('status', 'message','gymGalleryFiles'));
    }

    /**
     * The function `addGymGallery` in PHP validates and adds a gym gallery image uploaded by a gym
     * user, storing it in a specific directory and logging any errors that occur.
     * 
     * @param Request request The `addGymGallery` function in the code snippet is responsible for
     * adding an image to a gym's gallery. Let's break down the code and understand what each part
     * does:
     * 
     * @return The `addGymGallery` function is returning a redirect response back to the previous page
     * with a status of 'success' and a message of 'Image added successfully' if the image is added
     * successfully. If an error occurs during the process, it will return a redirect response back to
     * the previous page with a status of 'error' and the error message.
     */
    public function addGymGallery(Request $request)
    {
        try {
            $request->validate([
                "upload_file" => 'required'
            ]);

            $gym = Auth::guard('gym')->user();
            $galleryFile = $request->file('upload_file');
            $filename = time() . '_' . $galleryFile->getClientOriginalName();
            $imagePath = 'gymGallery_files/' . $filename;
            $galleryFile->move(public_path('gymGallery_files/'), $filename);

            $this->gymGallery->addGymGallery($gym->id, $imagePath);

            return redirect()->back()->with('status', 'success')->with('message', 'File added successfully.');
        } catch (\Throwable $th) {
            Log::error("[GymGalleryController][addGymGallery] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $th->getMessage());
        }
    }
}
