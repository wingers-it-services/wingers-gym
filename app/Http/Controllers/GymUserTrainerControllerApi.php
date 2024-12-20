<?php

namespace App\Http\Controllers;

use App\Models\GymStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GymUserTrainerControllerApi extends Controller
{
    protected $gymStaff;

    public function __construct(
        GymStaff $gymStaff
    ) {
        $this->gymStaff = $gymStaff;
    }

    public function fetchUserTrainer(Request $request)
    {
        try {
            $request->validate([
                'gym_id' => 'required',
            ]);
            $user = auth()->user();

            $trainers = $user->trainer()
            ->where('users_trainer_histries.gym_id', $request->gym_id)
            ->where('users_trainer_histries.user_id', $user->id)
            ->where('users_trainer_histries.status', 1)
            ->first();

            if (!$trainers) {
                return response()->json([
                    'status'   => 422,
                    'trainers' => $trainers,
                    'message'  => 'There is no trainer.'
                ], 422);
            }

            return response()->json([
                'status'   => 200,
                'trainers' => $trainers,
                'message'  => 'Trainers Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[GymUserTrainerControllerApi][fetchUserTrainer]Error fetching trainer details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching trainer details: ' . $e->getMessage()
            ], 500);
        }
    }
}
