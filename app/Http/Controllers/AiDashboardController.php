<?php

namespace App\Http\Controllers;

use App\Models\UserLatitudeAndLongitude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AiDashboardController extends Controller
{
    public function getUserLocations()
    {
        // Fetch users with their names and locations
        $locations = UserLatitudeAndLongitude::select('gym_users.firstname', 'user_latitude_and_longitudes.latitude', 'user_latitude_and_longitudes.longitude')
            ->join('gym_users', 'user_latitude_and_longitudes.user_id', '=', 'gym_users.id') // Join with users table
            ->whereNotNull('user_latitude_and_longitudes.latitude')
            ->whereNotNull('user_latitude_and_longitudes.longitude')
            ->get();

            Log::info($locations);

        return response()->json($locations);
    }
}
