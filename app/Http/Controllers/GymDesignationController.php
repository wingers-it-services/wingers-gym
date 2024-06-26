<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\Gym;
use App\Traits\SessionTrait;

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
        $gym_uuid = $this->getGymSession()['uuid'];
        $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;

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
                'designation_name' => 'required'
            ]);

            $gym_uuid = $this->getGymSession()['uuid'];
            $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;

            $this->designation->addAdminDesignation($validatedData, $gymId);

            return redirect()->route('viewGymDesignation')->with('success', 'Gym Designation added successfully!');
        } catch (\Exception $e) {
            Log::error('[GymDesignationController][addGymDesignation]Error adding : ' . 'Request=' . $e->getMessage());
            return back()->with('status', 'error')->with('message', 'Designation Not Added ');
        }
    }

    public function deleteGymDesignation(string $uuid)
    {
        $designation = $this->designation->where('uuid', $uuid)->firstOrFail();
        $designation->delete();
        return redirect()->route('viewGymDesignation')->with('success', 'Designation deleted successfully!');
    }
}
