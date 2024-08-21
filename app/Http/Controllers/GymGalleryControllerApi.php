<?php

namespace App\Http\Controllers;

use App\Models\GymGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GymGalleryControllerApi extends Controller
{
    protected $gymGallery;

    public function __construct(GymGallery $gymGallery)
    {
        $this->gymGallery = $gymGallery;
    }

    public function fetchGallery(Request $request)
    {
        try {
            $request->validate([
                'gym_id' => 'required',
            ]);
            
            $gymGallery = $this->gymGallery->where('gym_id',$request->gym_id)->get();

            if ($gymGallery->isEmpty()) {
                return response()->json([
                    'status'      => 422,
                    'gymGallery'  => $gymGallery,
                    'message'     => 'There is no data'
                ], 422);
            }

            return response()->json([
                'status'     => 200,
                'gymGallery' => $gymGallery,
                'message'    => 'Gym gallery Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[GymGalleryControllerApi][fetchGallery]Error fetching gallery: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching gallery: ' . $e->getMessage()
            ], 500);
        }
    }
}
