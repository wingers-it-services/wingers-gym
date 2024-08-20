<?php

namespace App\Http\Controllers;

use App\Enums\GymDesignationEnum;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\Gym;
use App\Models\Reel;
use App\Traits\SessionTrait;
use Illuminate\Support\Facades\Auth;

class GymDesignationController extends Controller
{
    use SessionTrait;
    private $designation;
    private $gym;

    public function __construct(
        Designation $designation,
        Gym $gym
    ) {
        $this->designation = $designation;
        $this->gym = $gym;
    }

    /**
     * The function retrieves and displays gym designations for a specific gym owner.
     *
     * @return view The `viewGymDesignation` function is returning a view called 'GymOwner.gymDesignation' with
     * the `designations` data passed to it as a compact variable.
     */
    public function viewGymDesignation()
    {
        $gym = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

        $designations = $this->designation->where('gym_id', $gymId)->get();
        return view('GymOwner.gymDesignation', compact('designations'));
    }

    /**
     * The function `addGymDesignation` adds a gym designation with validation and error handling.
     *
     * @param Request request The `addGymDesignation` function is a controller method that adds a gym
     * designation based on the data provided in the request. Here's a breakdown of the code:
     *
     * @return The function `addGymDesignation` is returning a redirect response to the route named
     * 'viewGymDesignation' with a success message 'Gym Designation added successfully!' if the
     * addition of the gym designation is successful. If an exception occurs during the process, it
     * will log the error and return back with a status of 'error' and a message 'Designation Not
     * Added'.
     */
    public function addGymDesignation(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'designation_name' => 'required',
                'is_commission_based' => 'required',
                'is_assigned_to_member' => 'required'
            ]);

            $gym = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

            $this->designation->addAdminDesignation($validatedData, $gymId);

            return redirect()->back()->with('status', 'success')->with('message', 'Gym Designation Added successfully!');
        } catch (\Exception $e) {
            Log::error('[GymDesignationController][addGymDesignation]Error adding : ' . 'Request=' . $e->getMessage());
            return back()->with('status', 'error')->with('message', 'Designation Not Added' . $e->getMessage());
        }
    }

    public function updateGymDesignation(Request $request)
    {
        try {
            // Validate incoming request
            $request->validate([
                'designation_id' => 'required',
                'designation_name' => 'required',
                'is_commission_based' => 'required',
                'is_assigned_to_member' => 'required',
            ]);

            // Find the designation by ID
            $designation = $this->designation->findOrFail($request->designation_id);

            if (!$designation) {
                return redirect()->back()->with('error', 'Designation not found.');
            }

            // Update the designation details
            $designation->designation_name = $request->input('designation_name');
            $designation->is_commission_based = $request->input('is_commission_based');
            $designation->is_assigned_to_member = $request->input('is_assigned_to_member');
            $designation->save();

            // Redirect back with success message
            return redirect()->back()->with('status', 'success')->with('message', 'Designation updated successfully.');
        } catch (\Exception $e) {
            Log::error('[GymDesignationController][addGymDesignation]Error adding : ' . 'Request=' . $e->getMessage());
            return back()->with('status', 'error')->with('message', 'Designation Not Updated' . $e->getMessage());
        }
    }

    public function deactivateDesignation(Request $request, $id)
    {
        try {
            // Find the designation by ID
            $designation = $this->designation->findOrFail($id);

            // Update the status to inactive
            $designation->status = GymDesignationEnum::InActive;
            $designation->save();

            // Return a JSON response
            return response()->json([
                'status' => 'success',
                'message' => 'Designation Deactivated Successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deactivating designation: ' . $e->getMessage());

            // Return a JSON error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to deactivate designation: ' . $e->getMessage()
            ]);
        }
    }

    public function activateDesignation(Request $request, $id)
    {
        try {
            // Find the designation by ID
            $designation = $this->designation->findOrFail($id);

            // Update the status to active
            $designation->status = GymDesignationEnum::Active;
            $designation->save();

            // Return a JSON response
            return response()->json([
                'status' => 'success',
                'message' => 'Designation Activated Successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error activating designation: ' . $e->getMessage());

            // Return a JSON error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to activate designation: ' . $e->getMessage()
            ]);
        }
    }




    public function deleteGymDesignation(string $uuid)
    {
        $designation = $this->designation->where('uuid', $uuid)->firstOrFail();
        $designation->delete();
        return redirect()->back()->with('status', 'success')->with('message', 'Designation deleted successfully!');
    }
}
