<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\errorResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeUserLoginControllerApi extends Controller
{
    use errorResponseTrait;
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function checkEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            $emailExists = $this->user->where('email', $request->email)->exists();

            if ($emailExists) {
                return response()->json([
                    'status'  => 409,
                    'message' => 'Email already exists.',
                ], 409);
            }

            return response()->json([
                'status'  => 200,
                'message' => 'Email is available.',
            ], 200);
        } catch (\Exception $e) {
            Log::error("[HomeUserLoginControllerApi][checkEmail] Error checking email: " . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
