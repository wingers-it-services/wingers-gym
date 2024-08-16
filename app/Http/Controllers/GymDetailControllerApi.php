<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\GymUserGym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GymDetailControllerApi extends Controller
{
    protected $gym;
    protected $gymUserGym;

    public function __construct(
        Gym $gym,
        GymUserGym $gymUserGym
    ) {
        $this->gym = $gym;
        $this->gymUserGym = $gymUserGym;
    }

    public function fetchGymDetails(Request $request)
    {
        try {
            $request->validate([
                'uuid' => 'required|string'
            ]);

            // Get the authenticated user
            $user = auth()->user();

            // Find the gym by UUID
            $gymDetails = $this->gym
                ->where('uuid', $request->uuid)
                ->first();

            if (!$gymDetails) {
                return response()->json([
                    'status'     => 422,
                    'gymDetails' => null,
                    'message'    => 'No gym found with the provided UUID.',
                ], 422);
            }

            // Check if the authenticated user is associated with this gym
            $isAssociated = $this->gymUserGym
                ->where('gym_id', $gymDetails->id)
                ->where('user_id', $user->id)
                ->exists();

            if (!$isAssociated) {
                return response()->json([
                    'status'     => 403,
                    'gymDetails' => null,
                    'message'    => 'You are not authorized to access this gym.',
                ], 403);
            }

            return response()->json([
                'status'     => 200,
                'gymDetails' => $gymDetails,
                'message'    => 'Gym details fetched successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('[GymDetailControllerApi][fetchGymDetails] Error fetching gym details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching gym details: ' . $e->getMessage(),
            ], 500);
        }
    }
}
