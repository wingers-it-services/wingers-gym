<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\User;
use App\Models\UserLatitudeAndLongitude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AiDashboardController extends Controller
{
    protected $userLatitudeAndLongitude;
    protected $user;

    public function __construct(
        UserLatitudeAndLongitude $userLatitudeAndLongitude,
        User $user
    ) {
        $this->userLatitudeAndLongitude = $userLatitudeAndLongitude;
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
        // Validate the form inputs
        $validated = $request->validate([
            'advertisement_type' => 'required|string',
            'targeted_no' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required|string'
        ]);

        // Send the email
        Mail::to('anjalitiwari67269@gmail.com')->send(new SendEmail($validated));

        // Return success response or redirect
        return redirect()->back()->with('success', 'Email sent successfully!');
    }
}
