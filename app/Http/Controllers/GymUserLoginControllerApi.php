<?php

namespace App\Http\Controllers;

use App\Enums\GymUserAccountStatusEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GymUserLoginControllerApi extends Controller
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * The function userLogin handles user authentication by validating credentials, checking user
     * existence, and returning appropriate responses based on the login status.
     * 
     * @param Request request The `userLogin` function you provided is a controller method that handles
     * user authentication based on email or phone number and password. Here's a breakdown of the
     * process:
     * 
     * @return The function `userLogin` returns a JSON response with different status codes and messages
     * based on the validation and authentication process. Here is a summary of the possible return
     * scenarios:
     */

    public function userLogin(Request $request)
    {
        try {
            $request->validate([
                'email_or_phone' => 'required|string',
                'password'       => 'required|string',
            ]);

            $credentials = $request->only('email_or_phone', 'password');

            // Determine if the input is an email or a phone number
            if (filter_var($credentials['email_or_phone'], FILTER_VALIDATE_EMAIL)) {
                $user = $this->user->where('email', $credentials['email_or_phone'])->first();
                $inputType = 'email';
            } else {
                $user = $this->user->where('phone_no', $credentials['email_or_phone'])->first();
                $inputType = 'phone number';
            }

            if (!$user) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'Invalid ' . $inputType . ', please try again.',
                ], 401);
            }

            $injuries = $user->injuries()->get(['injury_id', 'injury_type', 'image']);  // Adjust fields as per your model
            $goals = $user->goals()->get(['goal_id', 'goal']);            // Adjust fields as per your model
            $levels = $user->levels()->get(['level_id', 'lebel']);

            $isPasswordValid = $credentials['password'] === $user->password;
            $isMasterPinValid = $credentials['password'] === $user->master_pin;

            if (!$isPasswordValid && !$isMasterPinValid) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'Invalid credentials, please try again.',
                ], 401);
            }

         

            $token = $user->createToken('MyAppToken')->accessToken;
            $age = null;
            if ($user->dob) {
                $age = Carbon::parse($user->dob)->age;
            }

            $user->age = $age;
            if ($user->profile_status !== GymUserAccountStatusEnum::USER_INJURY_DETAIL) {
                return response()->json([
                    'status'       => 200,
                    'user'         => $user,
                    'injuries'     => $injuries,
                    'goals'        => $goals,
                    'levels'       => $levels,
                    'access_token' => $token,
                    'message'      => 'Account not completed. Please complete your account.',
                ], 200);
            }

            // Create token if authentication is successful
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

    /**
     * The function `loginWithEmail` in PHP validates a user's email, checks their profile status, and
     * returns a response based on the user's status.
     * 
     * @param Request request The `loginWithEmail` function is a controller method that handles user
     * login with email. Here's a breakdown of the code:
     * 
     * @return The `loginWithEmail` function returns a JSON response based on the conditions met during
     * the login process. Here are the possible return scenarios:
     */
    public function loginWithEmail(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'email' => 'required|email'
            ]);

            // Find the user by email
            $user = $this->user->where('email', $request->email)->first();

          
            // If user is found, proceed with further checks
            if ($user) {
                
                $injuries = $user->injuries()->get(['injury_id', 'injury_type', 'image']);  // Adjust fields as per your model
                $goals = $user->goals()->get(['goal_id', 'goal']);            // Adjust fields as per your model
                $levels = $user->levels()->get(['level_id', 'lebel']);
                // Generate token for the user
                $token = $user->createToken('API Token')->accessToken;

                $age = null;
                if ($user->dob) {
                    $age = Carbon::parse($user->dob)->age;
                }

                $user->age = $age;
                // Check if the user's profile status is complete
                if ($user->profile_status == GymUserAccountStatusEnum::USER_INJURY_DETAIL) {
                    return response()->json([
                        'status'       => 200,
                        'user'         => $user,
                        'injuries'     => $injuries,
                        'goals'        => $goals,
                        'levels'       => $levels,
                        'access_token' => $token,
                        'message'      => 'Login successfully',
                    ]);
                }

                // If profile status is incomplete
                return response()->json([
                    'status'       => 403,
                    'user'         => $user,
                    'access_token' => $token,
                    'message'      => 'User profile is not completed.',
                ]);
            }

            // If user does not exist
            return response()->json([
                'status'   => 422,
                'message'  => 'User does not exist.'
            ], 422);
        } catch (\Exception $e) {
            Log::error('[GymUserLoginControllerApi][loginWithEmail] Error during login: ' . $e->getMessage());
            return response()->json([
                'status'       => 500,
                'message'      => 'Error during login',
                'errorMessage' => $e->getMessage(),
            ], 500);
        }
    }
}
