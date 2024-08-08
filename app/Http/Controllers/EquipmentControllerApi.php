<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EquipmentControllerApi extends Controller
{
    protected $equipment;

    public function __construct(Equipment $equipment)
    {
        $this->equipment = $equipment;
    }

    public function fetchEquipments()
    {
        try {
            $equipments = $this->equipment->get();

            if ($equipments->isEmpty()) {
                return response()->json([
                    'status'     => 200,
                    'equipments' => $equipments,
                    'message'    => 'There is no equipment.'
                ], 200);
            }

            return response()->json([
                'status'     => 200,
                'equipments' => $equipments,
                'message'    => 'Equipment Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[EquipmentControllerApi][fetchEquipments]Error fetching equipment details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching equipment details: ' . $e->getMessage()
            ], 500);
        }
    }
}
