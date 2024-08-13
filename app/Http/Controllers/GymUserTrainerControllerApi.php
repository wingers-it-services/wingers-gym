<?php

namespace App\Http\Controllers;

use App\Models\GymStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GymUserTrainerControllerApi extends Controller
{
    protected $gymStaff;

    public function __construct(
        GymStaff $gymStaff
    ) {
        $this->gymStaff = $gymStaff;
    }

    public function fetchUserTrainer(Request $request)
    {
        try {
            $user = auth()->user();

            $trainers = $user->trainer;

            if (!$trainers) {
                return response()->json([
                    'status'   => 200,
                    'trainers' => $trainers,
                    'message'  => 'There is no trainer.'
                ], 200);
            }

            return response()->json([
                'status'   => 200,
                'trainers' => $trainers,
                'message'  => 'Trainers Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[GymUserTrainerControllerApi][fetchUserTrainer]Error fetching trainer details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching trainer details: ' . $e->getMessage()
            ], 500);
        }
    }
}
