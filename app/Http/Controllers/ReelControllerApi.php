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
