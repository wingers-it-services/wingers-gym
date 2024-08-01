<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GymUserLoginControllerApi extends Controller
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function userLogin(Request $request)
    {
        try {
            $request->validate([
                'email_or_phone' => 'required|string',
                'password' => 'required|string',
            ]);
    
            $credentials = $request->only('email_or_phone', 'password');
    
            // Determine if the input is an email or a phone number
            if (filter_var($credentials['email_or_phone'], FILTER_VALIDATE_EMAIL)) {
                // Input is an email
                $user = User::where('email', $credentials['email_or_phone'])->first();
                $inputType = 'email';
            } else {
                // Input is a phone number
                $user = User::where('phone_no', $credentials['email_or_phone'])->first();
                $inputType = 'phone number';
            }
    
            // Check if the user exists
            if (!$user) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'Invalid ' . $inputType . ', please try again.',
                ], 401);
            }
    
            // Check if the password is correct
            if ($credentials['password'] !== $user->password) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'Invalid password, please try again.',
                ], 401);
            }
    
            // Create token if authentication is successful
            $token = $user->createToken('MyAppToken')->accessToken;
    
            return response()->json([
                'status'       => 200,
                'user'         => $user,
                'access_token' => $token,
                'message'      => 'Login successfully',
            ], 200);
            return response()->json([
                'status'  => 401,
                'message' => 'Invalid email or password,please try again later.',
            ], 401);
        } catch (\Exception $e) {
            Log::error('[GymUserLoginControllerApi][userLogin] Error during login: ' . $e->getMessage());
            return response()->json([
                'status'       => 500,
                'message'      => 'Error during login',
                'errorMessage' => $e->getMessage(),
            ], 500);
        }
    }
    
}
