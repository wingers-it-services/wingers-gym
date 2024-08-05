<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Log;

class SiteSettingControllerApi extends Controller
{
    protected $siteSetting;

    public function __construct(SiteSetting $siteSetting)
    {
        $this->siteSetting = $siteSetting;
    }

    public function fetchMeasurement()
    {
        try {
            $measurements = $this->siteSetting
            ->whereIn('key', ['max_height', 'max_weight'])->get()->pluck('value', 'key');

            if ($measurements->isEmpty()) {
                return response()->json([
                    'status'         => 422,
                    'measurements'   => $measurements,
                    'message'        => 'There is no measurements'
                ], 200);
            }

            return response()->json([
                'status'        => 200,
                'measurements'  => $measurements,
                'message'       => 'Measurements Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[SiteSettingControllerApi][fetchMeasurement]Error fetching measurements details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching measurements: ' . $e->getMessage()
            ], 500);
        }
    }
}
