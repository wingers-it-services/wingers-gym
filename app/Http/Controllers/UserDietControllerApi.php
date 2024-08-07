<?php

namespace App\Http\Controllers;

use App\Models\UserDiet;
use App\Traits\errorResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserDietControllerApi extends Controller
{
    use errorResponseTrait;
    protected $userDiet;

    public function __construct(
        UserDiet $userDiet,
    ) {
        $this->userDiet = $userDiet;
    }

    public function fetchUserDiet()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'User not authenticated',
                ], 401);
            }
            
            $diets = $this->userDiet->where('user_id',$user->id)->get();

            if ($diets->isEmpty()) {
                return response()->json([
                    'status'   => 422,
                    'diets'    => $diets,
                    'message'  => 'There is no diets'
                ], 200);
            }

            return response()->json([
                'status'  => 200,
                'diets'   => $diets,
                'message' => 'User diets Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserDietControllerApi][fetchUserDiet]Error fetching diets details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching diets details: ' . $e->getMessage()
            ], 500);
        }
    }
}
