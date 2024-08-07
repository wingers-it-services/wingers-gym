<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Services\GymService;
use App\Traits\SessionTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GymDetailController extends Controller
{
    use SessionTrait;
    protected $gym;
    protected $gymService;

    public function __construct(
        Gym $gym,
        GymService $gymService
    ) {
        $this->gym = $gym;
        $this->gymService = $gymService;
    }

    public function showDashboard(Request $request)
    {
        $gymSession = $this->getGymSession();
        $uuid = $gymSession['uuid'];
        $gymDetail = $this->gym->where('uuid', $uuid)->first();
        Log::error('[GymDetailController][showDashboard] user image null : ' . empty($gymDetail->image));
        Log::error('[GymDetailController][showDashboard] user image src : ' . $gymDetail->image);
        return view('GymOwner.dashboard', compact('gymDetail'));
    }
    public function showGymProfile(Request $request)
    {
        $gymSession = $this->getGymSession();
        // dd($gymSession);
        $uuid = $gymSession['uuid'];
        $gymDetail = $this->gym->where('uuid', $uuid)->first();

        return view('GymOwner.gymProfile', compact('gymDetail'));
    }
    public function gymLogin(Request $request)
    {
        try {
            $credentials = $request->all();
            $gymAccount = $this->gym->where([
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ])->first();

            if (!$gymAccount) {
                session()->flush();
                return redirect()->back()->with('status', 'error')->with('message', 'Invalid credential');
            }
            $this->storeGymSession($gymAccount);
            return redirect('/dashboard')->with('status', 'success')->with('message', 'login successfully');
        } catch (Exception $e) {
            // dd($e);
            Log::error('[GymDetailController][gymLogin] Error Login Gym ' . 'Request=' . $request . ', Exception=' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Invalid credentials or account is not active');
        }
    }

    public function logouGymUser()
    {
        session()->flush();
        return redirect()->route('login');
    }

    public function registerGym(Request $request)
    {
        try {
            $request->validate([
                'gym_name' => 'required',
                'email'    => 'required|unique:gyms,email',
                'password' => 'required'
            ]);

            $gymUser = $this->gymService->createGymAccount($request->all());
            if ($gymUser) {
                return redirect()->route('login')->with('success', 'Gym Registered Succesfully.');
            }
            return redirect()->route('register')->with('status', 'error')->with('message', 'error in register gym.');
        } catch (Exception $e) {
            //  dd($e);
            Log::error('[GymDetailController][registerGym] Error register gym: ' . $e->getMessage());
            return redirect()->route('register')->with('status', 'error')->with('message', 'error in register gym : ' . $e->getMessage());
        }
    }

    public function updateGym(Request $request)
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
                return redirect()->route('showGymProfile')->with('status', 'success')->with('message', 'Gym profile updated succesfully.');
            }
            return redirect()->route('showGymProfile')->with('status', 'error')->with('message', 'error while updating gym.');
        } catch (Exception $e) {
            Log::error('[GymDetailController][updateGym] Error updating gym :' . $e->getMessage());
            return redirect()->route('showGymProfile')->with('status', 'error')->with('message', 'error while updating gym.');
        }
    }
}
