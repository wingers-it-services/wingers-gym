<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\GymGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GymGalleryController extends Controller
{
    protected $gymGallery;
    protected $gym;

    public function __construct(GymGallery $gymGallery, Gym $gym)
    {
        $this->gymGallery = $gymGallery;
        $this->gym = $gym;
    }

    public function gymGalleryView()
    {
        $status = null;
        $message = null;
        $gym = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;
        $gymGalleryFiles = $this->gymGallery->where('gym_id', $gymId)->get();
        return view('GymOwner.gym-gallery', compact('status', 'message', 'gymGalleryFiles'));
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
            // Validate the files
            $request->validate([
                'upload_file.*' => 'required|file|mimes:jpeg,jpg,png,gif,mp4,mov,avi,webp,avif|max:20480', // Adjust max size as needed
            ]);

            $gym = Auth::guard('gym')->user();
            $files = $request->file('upload_file'); // Get the array of files

            // Loop through each file and process
            foreach ($files as $file) {
                // Generate a unique filename and move the file
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = 'gymGallery_files/' . $filename;
                $file->move(public_path('gymGallery_files/'), $filename);

                // Save the file information to the database
                $this->gymGallery->addGymGallery($gym->id, $filePath);
            }

            return redirect()->back()->with('status', 'success')->with('message', 'Files added successfully.');
        } catch (\Throwable $th) {
            // Log error and return a response with error message
            Log::error("[GymGalleryController][addGymGallery] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error while adding files.');
        }
    }

    public function deleteGallery($itemId)
    {
        $galleryItem = $this->gymGallery->findOrFail($itemId);
        $galleryItem->delete();

        return redirect()->back()->with('status', 'success')->with('message', 'Gallery Item Is Succesfully Deleted!');
    }
}
