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

   /**
    * This PHP function fetches gym details based on a provided UUID, checks authorization, and returns
    * a JSON response with the results or error message.
    * 
    * @param Request request The `fetchGymDetails` function is responsible for fetching details of a
    * gym based on the provided UUID. Here is a breakdown of the function:
    * 
    * @return The `fetchGymDetails` function returns a JSON response with the following structure:
    */
    public function fetchGymDetails(Request $request)
    {
        try {
            $request->validate([
                'uuid' => 'required|string'
            ]);

            $user = auth()->user();

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
