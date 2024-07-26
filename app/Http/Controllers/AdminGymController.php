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
        return view('admin.gym.listGym', compact('gymLists'));
    }

    public function addGymDetailsByAdmin(Request $request)
    {
        try {
            Validator::make($request->all(), []);
            $this->gymService->createGymAccount($request->all());

            return back()->with('status', 'success')->with('message', 'Gym Added Succesfully');
        } catch (Exception $e) {
            Log::error('[GymController][addGym]Error adding : ' . 'Request=' . $e->getMessage());
            return back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }

    public function viewEditGym(Request $request, $uuid)
    {
        $gymLists = $this->gym->where('uuid', $uuid)->first();

        return view('admin.gym.editGymInfo', compact('gymLists'));
    }

    public function updateAdminGym(Request $request)
    {
        try {
            $request->validate([
                "username" => 'required',
                "email" => 'required',
                "password" => 'required',
                "gym_name" => 'required',
                "address" => 'required',
                "city" => 'required',
                "state" => 'required',
                "country" => 'required',
                "web_link" => 'required',
                "gym_type" => 'required',
                "terms_and_conditions" => 'nullable',
                "facebook" => 'nullable',
                "instagram" => 'nullable'
            ]);


            $isProfileUpdated = $this->gymService->createGymAccount($request->all());
            if ($isProfileUpdated) {
                return redirect()->route('viewGymList')->with('status', 'success')->with('message', 'Gym profile updated succesfully.');
            }
            return redirect()->route('viewGymList')->with('status', 'error')->with('message', 'error while updating gym.');
        } catch (Exception $e) {
            Log::error('[AdminGymController][updateAdminGym] Error updating gym :' . $e->getMessage());
            return redirect()->route('viewGymList')->with('status', 'error')->with('message', 'error while updating gym.');
        }
    }

    public function deleteGym($uuid)
    {
        $gyms = $this->gym->where('uuid', $uuid)->firstOrFail();
        $gyms->delete();
        return redirect()->route('viewGymList')->with('success', 'Gym deleted successfully!');
    }


    // public function addTermsAndConditions(Request $request)
    // {
    //     try {
    //         Validator::make($request->all(), []);
    //         $data = $request->all();
    //         $this->gym->addTandC($data);
    //         return back()->with('status', 'success')->with('message', 'Gym terms and conditions added Succesfully');
    //     } catch (\Exception $e) {
    //         Log::error('[GymController][addTermsAndConditions]Error adding : ' . 'Request=' . $e->getMessage());
    //         return back()->with('status', 'error')->with('message', 'T&C Not Added ');
    //     }
    // }

    // public function addGymSocialLink(Request $request)
    // {
    //     try {
    //         Validator::make($request->all(), []);
    //         $data = $request->all();
    //         $this->gym->addSocialLink($data);
    //         return back()->with('status', 'success')->with('message', 'Gym terms and conditions added Succesfully');
    //     } catch (\Exception $e) {
    //         Log::error('[GymController][addGymSocialLink]Error adding : ' . 'Request=' . $e->getMessage());
    //         return back()->with('status', 'error')->with('message', 'T&C Not Added ');
    //     }
    // }
}
