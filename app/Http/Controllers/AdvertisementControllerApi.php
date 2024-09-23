<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdvertisementControllerApi extends Controller
{

    protected $advertisment;

    public function __construct(
        Advertisement $advertisment
    ) {
        $this->advertisment = $advertisment;
    }

    public function fetchAdvertisement()
    {
        try {

            $advertisement = $this->advertisment->where('type', 'ads')->get();

            if (!$advertisement) {
                return response()->json([
                    'status'        => 422,
                    'advertisement' => null,
                    'message'       => 'No advertisement found.',
                ], 422);
            }

            return response()->json([
                'status'        => 200,
                'advertisement' => $advertisement,
                'message'       => 'advertisement fetched successfully.',
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('[AdvertisementControllerApi][fetchAdvertisement] Error fetching advertisement details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching advertisement details: ' . $e->getMessage(),
            ], 500);
        }
    }
}
