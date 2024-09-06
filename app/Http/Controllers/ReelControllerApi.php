<?php

namespace App\Http\Controllers;

use App\Models\Reel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReelControllerApi extends Controller
{
    protected $reel;

    public function __construct(Reel $reel)
    {
        $this->reel = $reel;
    }

   /**
    * The function fetches reels data and returns a JSON response with the status, reels data, and a
    * message indicating success or failure.
    * 
    * @return The `fetchReels` function returns a JSON response. If the fetched reels are empty, it
    * returns a JSON response indicating that there are no reels. If reels are fetched successfully, it
    * returns a JSON response with the fetched reels and a success message. If an exception occurs
    * during the process, it logs the error and returns a JSON response indicating the error message.
    */
    public function fetchReels()
    {
        try {
            $reels = $this->reel->get();

            if ($reels->isEmpty()) {
                return response()->json([
                    'status'  => 200,
                    'reels'   => $reels,
                    'message' => 'There is no reel.'
                ], 200);
            }

            return response()->json([
                'status'  => 200,
                'reels'   => $reels,
                'message' => 'Reels Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[ReelControllerApi][fetchReels]Error fetching reels details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching reels details: ' . $e->getMessage()
            ], 500);
        }
    }
}
