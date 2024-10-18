<?php

namespace App\Http\Controllers;

use App\Models\UserLatitudeAndLongitude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AiDashboardController extends Controller
{
    protected $userLatitudeAndLongitude;

    public function __construct(
        UserLatitudeAndLongitude $userLatitudeAndLongitude
    ) {
        $this->userLatitudeAndLongitude = $userLatitudeAndLongitude;
    }

    public function getUserLocations()
    {
        $gym = Auth::guard('gym')->user();
        if ($gym->gym_type == 'admin') {
            $locations = $this->userLatitudeAndLongitude->select('gym_users.firstname', 'user_latitude_and_longitudes.latitude', 'user_latitude_and_longitudes.longitude')
                ->join('gym_users', 'user_latitude_and_longitudes.user_id', '=', 'gym_users.id')
                ->whereNotNull('user_latitude_and_longitudes.latitude')
                ->whereNotNull('user_latitude_and_longitudes.longitude')
                ->get();
        } else {
            $locations = $this->userLatitudeAndLongitude->select('gym_users.firstname', 'user_latitude_and_longitudes.latitude', 'user_latitude_and_longitudes.longitude')
                ->join('gym_users', 'user_latitude_and_longitudes.user_id', '=', 'gym_users.id')
                ->join('gym_user_gyms', 'gym_users.id', '=', 'gym_user_gyms.user_id')
                ->where('gym_user_gyms.gym_id', $gym->id)
                ->whereNotNull('user_latitude_and_longitudes.latitude')
                ->whereNotNull('user_latitude_and_longitudes.longitude')
                ->get();
        }

        return response()->json($locations);
    }
}
