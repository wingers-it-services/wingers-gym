<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\GymUserGym;
use Carbon\Carbon;
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
    
            // Fetch the gym details along with the user count and staff details
            $gymDetails = $this->gym
                ->where('uuid', $request->uuid)
                ->withCount('users') // Add users count
                ->with(['staff' => function ($query) {
                    // Include designation name with staff details
                    $query->with('designation:id,designation_name');
                }])
                ->first();
    
            if (!$gymDetails) {
                return response()->json([
                    'status'     => 422,
                    'gymDetails' => null,
                    'message'    => 'No gym found with the provided UUID.',
                ], 422);
            }
    
            // Check if the user is associated with the gym
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
            $totalYears = 0;
            $remainingMonths=0;
            if (!empty($gymDetails->established_at)) {
                $establishedDate = Carbon::parse($gymDetails->established_at);
                $now = Carbon::now();
            
                // Calculate the total difference in months
                $totalMonths = $establishedDate->diffInMonths($now);
                
                // Calculate years and remaining months
                $totalYears = floor($totalMonths / 12); // Complete years
                $remainingMonths = $totalMonths % 12; 
            
            }
            
            
            // Calculate total years and review (dummy logic for now)
            // Replace with actual logic if available
            $review = 0;     // Replace with actual logic if available
    
            // Convert gymDetails to array and add custom fields
            $gymDetailsArray = array_merge($gymDetails->toArray(), [
                'review'      => $review, 
                'total_years' => $totalYears,    
                'months' => $remainingMonths, 
            ]);
    
            // Update staff data to include designation name instead of ID
            $gymDetailsArray['staff'] = collect($gymDetailsArray['staff'])->map(function ($staff) {
                $staff['designation_name'] = $staff['designation']['designation_name'] ?? null;
                unset($staff['designation']); // Remove the 'designation' array
                return $staff;
            });
    
            return response()->json([
                'status'     => 200,
                'gymDetails' => $gymDetailsArray,
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
