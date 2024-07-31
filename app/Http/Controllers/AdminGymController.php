<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Services\GymService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminGymController extends Controller
{

    private $gym;
    private $gymService;

    public function __construct(
        Gym $gym,
        GymService $gymService
    ) {
        $this->gym = $gym;
        $this->gymService = $gymService;
    }

    public function viewGymInfo()
    {
        return view('admin.add-gym');
    }

    public function viewGymList()
    {
        $gymLists = $this->gym->all();
        return view('admin.admin-gym-list', compact('gymLists'));
    }

    public function addGymDetailsByAdmin(Request $request)
    {
        try {
            $request->validate([
                'gym_name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'image' => 'nullable',
                'username' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'web_link' => 'nullable',
                'gym_type' => 'required',
                'face_link' => 'nullable',
                'insta_link' => 'nullable',
            ]);
            $this->gymService->createGymAccount($request->all());

            return back()->with('status', 'success')->with('message', 'Gym Added Succesfully');
        } catch (Exception $e) {
            Log::error('[GymController][addGymDetailsByAdmin]Error adding : ' . 'Request=' . $e->getMessage());
            return back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }

    public function viewEditGym(Request $request, $uuid)
    {
        $gymLists = $this->gym->where('uuid', $uuid)->first();

        return view('admin.update-gym', compact('gymLists'));
    }

    public function updateAdminGym(Request $request)
    {
        try {
            $request->validate([
                'gym_name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'image' => 'nullable',
                'username' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'web_link' => 'nullable',
                'gym_type' => 'required',
                'face_link' => 'nullable',
                'insta_link' => 'nullable',
            ]);


            $isProfileUpdated = $this->gymService->createGymAccount($request->all());
            if ($isProfileUpdated) {
                return redirect()->route('admin-gym-list')->with('status', 'success')->with('message', 'Gym profile updated succesfully.');
            }
            return redirect()->route('admin-gym-list')->with('status', 'error')->with('message', 'error while updating gym.');
        } catch (Exception $e) {
            Log::error('[AdminGymController][updateAdminGym] Error updating gym :' . $e->getMessage());
            return redirect()->route('admin-gym-list')->with('status', 'error')->with('message', 'error while updating gym.');
        }
    }

    public function deleteGym($uuid)
    {
        $gyms = $this->gym->where('uuid', $uuid)->firstOrFail();
        $gyms->delete();
        return redirect()->back()->with('success', 'Gym deleted successfully!');
    }
}
