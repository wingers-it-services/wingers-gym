<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\MarketingAdvertisement;
use App\Models\User;
use App\Models\UserLatitudeAndLongitude;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AiDashboardController extends Controller
{
    protected $userLatitudeAndLongitude;
    protected $marketingAdvertisement;
    protected $user;

    public function __construct(
        UserLatitudeAndLongitude $userLatitudeAndLongitude,
        MarketingAdvertisement $marketingAdvertisement,
        User $user
    ) {
        $this->userLatitudeAndLongitude = $userLatitudeAndLongitude;
        $this->marketingAdvertisement=$marketingAdvertisement;
        $this->user = $user;
    }

    public function getUserLocations()
    {
        $gym = Auth::guard('gym')->user();

        // if ($gym->gym_type == 'admin') {
        //     $locations = $this->userLatitudeAndLongitude->select('gym_users.firstname', 'user_latitude_and_longitudes.latitude', 'user_latitude_and_longitudes.longitude')
        //         ->join('gym_users', 'user_latitude_and_longitudes.user_id', '=', 'gym_users.id')
        //         ->whereNotNull('user_latitude_and_longitudes.latitude')
        //         ->whereNotNull('user_latitude_and_longitudes.longitude')
        //         ->get();
        // } else {
        //     $locations = $this->userLatitudeAndLongitude->select('gym_users.firstname', 'user_latitude_and_longitudes.latitude', 'user_latitude_and_longitudes.longitude')
        //         ->join('gym_users', 'user_latitude_and_longitudes.user_id', '=', 'gym_users.id')
        //         ->join('gym_user_gyms', 'gym_users.id', '=', 'gym_user_gyms.user_id')
        //         ->where('gym_user_gyms.gym_id', $gym->id)
        //         ->whereNotNull('user_latitude_and_longitudes.latitude')
        //         ->whereNotNull('user_latitude_and_longitudes.longitude')
        //         ->get();
        // }

        $locations = $this->userLatitudeAndLongitude->select('gym_users.firstname', 'user_latitude_and_longitudes.latitude', 'user_latitude_and_longitudes.longitude')
            ->join('gym_users', 'user_latitude_and_longitudes.user_id', '=', 'gym_users.id')
            ->whereNotNull('user_latitude_and_longitudes.latitude')
            ->whereNotNull('user_latitude_and_longitudes.longitude')
            ->get();

        return response()->json($locations);
    }

    public function sendContactForm(Request $request)
    {
        try {
            $validated = $request->validate([
                'advertisement_type' => 'required|string',
                'targetted_no'       => 'required|integer',
                'city'               => 'required',
                'state'              => 'required',
                'country'            => 'required',
                'address'            => 'required',
                'email'              => 'required|email',
                'phone_no'           => 'required|string'
            ]);

            $this->marketingAdvertisement->addMarketingAdvertisement($request->all());

            Mail::to('wingersitservices@gmail.com')->send(new SendEmail($validated));

            return redirect()->back()->with('status','success')->with('message', 'Email sent successfully!');
        } catch (Exception $e) {
            Log::error('[AiDashboardController][sendContactForm]Error sending email'.$e->getMessage());
            return redirect()->back()->with('status','error')->with('message', 'Email not sent successfully!');
        }
    }
}
