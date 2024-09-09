<?php

namespace App\Http\Controllers;

use App\Enums\GymUserAccountStatusEnum;
use App\Models\InjuryUser;
use App\Models\User;
use App\Services\OtpService;
use App\Services\UserService;
use App\Traits\errorResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class GymUserControllerApi extends Controller
{
    use errorResponseTrait;
    protected $otpService;
    protected $user;
    protected $userService;
    protected $injuryUser;

    public function __construct(
        OtpService $otpService,
        User $user,
        UserService $userService,
        InjuryUser $injuryUser
    ) {
        $this->otpService = $otpService;
        $this->user = $user;
        $this->userService = $userService;
        $this->injuryUser = $injuryUser;
    }

    /**
     * The function `sendMobileOtp` validates a phone number, generates a mobile OTP, and returns a JSON
     * response with the result.
     * 
     * @param Request request The `sendMobileOtp` function is used to send a one-time password (OTP) to
     * a mobile phone number for verification purposes. Here's a breakdown of the parameters used in the
     * function:
     * 
     * @return The `sendMobileOtp` function is returning a JSON response with the result of generating a
     * mobile OTP along with the corresponding status code. The result is returned in the JSON format
     * and the status code is included in the response. If an error occurs during the process, an error
     * response is returned with a message indicating the issue encountered.
     */
    public function sendMobileOtp(Request $request)
    {
        try {
            $request->validate([
                'phone_no' => 'required|unique:gym_users,phone_no'
            ]);
            $result = $this->otpService->generateMobileOtp($request->phone_no);
            return response()->json($result, $result['status']);
        } catch (Exception $e) {
            Log::error("[GymUserControllerApi][sendMobileOtp] Error sending otp: " . $e->getMessage());
            return $this->errorResponse('Error while sending otp', $e->getMessage(), 500);
        }
    }

    /**
     * The function `sendEmailOtp` validates the email input, sends an OTP to the provided email
     * address, and returns a JSON response with the result.
     * 
     * @param Request request The `sendEmailOtp` function is responsible for sending a One Time Password
     * (OTP) to a user's email address for verification. Here's a breakdown of the code snippet you
     * provided:
     * 
     * @return The `sendEmailOtp` function is returning a JSON response with the data returned from the
     * `sendOtptoEmail` method of the ``. The response status code is determined by the
     * `'status'` key in the result array. If an exception is caught during the process, an error
     * response is returned with a message indicating the error that occurred.
     */
    public function sendEmailOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|unique:gym_users,email',
            ]);
            $result = $this->otpService->sendOtptoEmail($request->email);
            return response()->json($result, $result['status']);
        } catch (Exception $e) {
            Log::error("[GymUserControllerApi][sendEmailOtp] Error sending otp: " . $e->getMessage());
            return $this->errorResponse('Error while sending otp', $e->getMessage(), 500);
        }
    }

    /**
     * This PHP function verifies a mobile OTP provided by the user and returns a JSON response based on
     * the verification result.
     * 
     * @param Request request The `verifyMobileOtp` function is used to verify a mobile OTP (One Time
     * Password) provided by the user. Here is a breakdown of the parameters used in this function:
     * 
     * @return The `verifyMobileOtp` function is returning a JSON response with the data stored in the
     * `` variable along with the HTTP status code specified in the `['status']` field. If
     * an exception is caught during the process, it will log an error message and return an error
     * response with a message indicating the failure to verify the OTP.
     */
    public function verifyMobileOtp(Request $request)
    {
        try {
            $request->validate([
                'phone_no' => 'required',
                'otp'      => 'required|digits:4',
            ]);
            $result = $this->otpService->verifyMobileOtp($request->phone_no, $request->otp);
            return response()->json($result, $result['status']);
        } catch (Exception $e) {
            Log::error("[GymUserControllerApi][verifyMobileOtp] Error verifying otp: " . $e->getMessage());
            return $this->errorResponse('Error while verifying otp', $e->getMessage(), 500);
        }
    }

    /**
     * The function `verifyEmailOtp` validates an email and OTP, then calls a service to verify the OTP
     * and returns the result as a JSON response.
     * 
     * @param Request request The `verifyEmailOtp` function is used to verify an OTP (One-Time Password)
     * sent to a user's email address. Here's a breakdown of the parameters used in the function:
     * 
     * @return The `verifyEmailOtp` function is returning a JSON response with the data stored in the
     * `` variable and the HTTP status code specified in the `['status']` value. If an
     * exception is caught during the process, it will log an error message and return an error response
     * with a message indicating the failure to verify the OTP.
     */
    public function verifyEmailOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'otp'   => 'required|digits:4',
            ]);
            $result = $this->otpService->verifyEmailOtp($request->email, $request->otp);
            return response()->json($result, $result['status']);
        } catch (Exception $e) {
            Log::error("[GymUserControllerApi][verifyEmailOtp] Error verifying otp: " . $e->getMessage());
            return $this->errorResponse('Error while verifying otp', $e->getMessage(), 500);
        }
    }

    /**
     * The function `registerGymUser` validates and registers a new gym user with optional profile image
     * upload.
     * 
     * @param Request request The `registerGymUser` function is a controller method that handles the
     * registration of a user for a gym. Here's a breakdown of the function:
     * 
     * @return The `registerGymUser` function returns a JSON response with the following structure:
     * - `status`: The status of the registration process (success or error)
     * - `message`: A message related to the status of the registration process
     * - `user`: The user data if the registration was successful, or `null` if there was an error
     */
    public function registerGymUser(Request $request)
    {
        try {
            $request->validate([
                'firstname' => 'required',
                'email'     => 'required|email|unique:gym_users,email',
                'phone_no'  => 'required|digits:10|unique:gym_users,phone_no',
                'lastname'  => 'required',
                'gender'    => 'required',
                'password'  => 'required',
                'image'     => 'nullable',
                'dob'       => 'required'
            ]);

            $userDetail = $request->all();
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $this->userService->uploadUserProfileImage($request->file('image'));
            }

            $response = $this->user->createUserProfile($userDetail, $imagePath);

            $user = $response['user'];
            $token = $user->createToken('MyAppToken')->accessToken;


            return response()->json([
                'status'       => $response['status'],
                'message'      => $response['message'],
                'user'         => $user ?? null,
                'access_token' => $token ?? null
            ], $response['status']);
        } catch (Throwable $e) {
            Log::error("[GymUserControllerApi][registerGymUser] Error in registration: " . $e->getMessage());
            return $this->errorResponse('Error while registering', $e->getMessage(), 500);
        }
    }

    /**
     * The function `verifyOtp` in PHP validates OTP, email, and phone number inputs, verifies the OTP
     * using a service, and returns a JSON response with the result.
     * 
     * @param Request request The `verifyOtp` function is used to verify a one-time password (OTP)
     * provided by the user. Here is an explanation of the parameters used in the function:
     * 
     * @return The `verifyOtp` function is returning a JSON response with the data stored in the
     * `` variable along with the HTTP status code specified in `['status']`. If an
     * exception occurs during the verification process, an error response is returned with a message
     * indicating the error that occurred.
     */
    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'uuid'     => 'required',
                'otp'      => 'required|digits:4',
                'email'    => 'required_without:phone_no|email|unique:gym_users,email',
                'phone_no' => 'required_without:email|digits:10|unique:gym_users,phone_no',
            ]);

            $result = $this->otpService->verifyOtp($request);
            return response()->json($result, $result['status']);
        } catch (Exception $e) {
            Log::error("[GymUserControllerApi][verifyOtp] Error verifying otp: " . $e->getMessage());
            return $this->errorResponse('Error while verifying otp', $e->getMessage(), 500);
        }
    }

    /**
     * The function `profilePartFour` in PHP validates and processes a request to update a user's profile
     * information, handling any exceptions that may occur.
     * 
     * @param Request request The `profilePartFour` function in the code snippet is a controller method
     * that handles a POST request to update a user's profile information. Here's a breakdown of the
     * parameters being validated in the request:
     * 
     * @return The function `profilePartFour` is returning a JSON response with the data stored in the
     * variable `` and the HTTP status code stored in `['status']`. If an exception occurs
     * during the process, an error response is returned with a message indicating the error that
     * occurred.
     */
    public function profilePartFour(Request $request)
    {
        try {
            $request->validate([
                'uuid'     => 'required',
                'height'   => 'required',
                'weight'   => 'required',
                'days'     => 'required',
                'goals'    => 'array',
                'goals.*'  => 'exists:goals,id',
                'levels'   => 'array',
                'levels.*' => 'exists:user_lebels,id'
            ]);

            $request = $request->all();

            $result = $this->user->profilePartFour($request);
            return response()->json($result, $result['status']);
        } catch (Exception $e) {
            Log::error("[GymUserControllerApi][profilePartFour] Error updating profile: " . $e->getMessage());
            return $this->errorResponse('Error while updating profile', $e->getMessage(), 500);
        }
    }

    /**
     * The function fetches gyms associated with the authenticated user and counts the number of users
     * in each gym, returning the results in a JSON response.
     * 
     * @return The `fetchUserGym` function returns a JSON response with the status code, gyms data, and
     * a message based on the outcome of the gym fetching process.
     */
    public function fetchUserGym()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'User not authenticated',
                ], 401);
            }

            // Fetch gyms associated with the user and count the users in each gym
            // $gyms = $user->gyms()->withCount('users')->get();

            $gyms = $user->gyms()->withCount('users')->get()->map(function ($gym) {
                return array_merge($gym->toArray(), [
                    'review'      => 0, // Assuming review is a method or attribute in the Gym model
                    'total_years' => 1, // Assuming total_years is a method or attribute in the Gym model
                ]);
            });
            if ($gyms->isEmpty()) {
                return response()->json([
                    'status'   => 422,
                    'gyms'     => $gyms,
                    'message'  => 'There are no gyms',
                ], 200);
            }

            return response()->json([
                'status'  => 200,
                'gyms'    => $gyms,
                'message' => 'User gyms fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('[GymUserControllerApi][fetchUserGym]Error fetching gyms details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching gyms details: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * The function `addUserInjuries` in PHP validates and associates injuries with a user, updating
     * the user's profile status accordingly.
     * 
     * @param Request request The `addUserInjuries` function is designed to handle the addition of
     * injuries for a user in a gym management system. Let me explain the key points of this function:
     * 
     * @return The function `addUserInjuries` returns a JSON response with status code, message, and
     * additional data.
     */
    public function addUserInjuries(Request $request)
    {
        try {
            $request->validate([
                'uuid'         => 'required|string',
                'injury_ids'   => 'array',
                'injury_ids.*' => 'exists:user_injuries,id',
            ]);

            // Fetch the user using UUID
            $user = $this->user->where('uuid', $request->uuid)->first();

            if (!$user) {
                return response()->json([
                    'status'  => 404,
                    'message' => 'User not found',
                ], 404);
            }

            // If no injury IDs are provided, mark the user's profile status as completed
            if (empty($request->injury_ids)) {
                $user->profile_status = GymUserAccountStatusEnum::USER_INJURY_DETAIL;
                $user->save();

                return response()->json([
                    'status'  => 200,
                    'message' => 'User has no injuries. Profile status updated to completed.',
                ], 200);
            }

            // Associate each injury with the user
            $injuryUsers = [];
            foreach ($request->injury_ids as $injuryId) {
                $injuryUser = $this->injuryUser->create([
                    'user_id'   => $user->id,
                    'injury_id' => $injuryId,
                ]);
                $injuryUsers[] = $injuryUser;
            }

            // Update profile status to USER_INJURY_DETAIL
            $user->profile_status = GymUserAccountStatusEnum::USER_INJURY_DETAIL;
            $user->save();

            return response()->json([
                'status'      => 200,
                'message'     => 'Injuries added successfully',
                'injuryUsers' => $injuryUsers,
            ], 200);
        } catch (\Exception $e) {
            Log::error("[GymUserControllerApi][addUserInjuries] Error adding injuries: " . $e->getMessage());
            return response()->json([
                'status'       => 500,
                'message'      => 'An error occurred while adding injuries',
                'errorMessage' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateGymUserProfile(Request $request)
    {
        try {
            // Validate the incoming request data
           $request->validate([
                'firstname'    => 'required|string',
                'lastname'     => 'required|string',
                'gender'       => 'required|string',
                'dob'          => 'required|date',
                'height'       => 'required|numeric',
                'weight'       => 'required|numeric',
                'days'         => 'required|string',
                'goals'        => 'array',
                'goals.*'      => 'exists:goals,id',
                'injury_ids'   => 'array',
                'injury_ids.*' => 'exists:user_injuries,id',
                'levels'       => 'array',
                'levels.*'     => 'exists:user_lebels,id',
                'image'        => 'nullable',
            ]);

            $result = $this->user->updateUserProfile($request->all());

            return response()->json($result, $result['status']);
        } catch (\Throwable $e) {
            Log::error('[UserControllerApi][updateGymUserProfile] Error while updating user profile: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'An error occurred while updating the profile' . $e->getMessage()
            ], 500);
        }
    }

    public function fetchUserDetails()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'User not authenticated',
                ], 401);
            }

            // Fetch related injuries, goals, and levels
            $injuries = $user->injuries()->get(['injury_id', 'injury_type', 'image']);  // Adjust fields as per your model
            $goals = $user->goals()->get(['goal_id', 'goal']);            // Adjust fields as per your model
            $levels = $user->levels()->get(['level_id', 'lebel']);             // Adjust fields as per your model
            

            return response()->json([
                'status'  => 200,
                'user'    => $user,
                'injuries' => $injuries,
                'goals'   => $goals,
                'levels'  => $levels,
                'message' => 'User detail fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('[GymUserControllerApi][fetchUserDetails] Error fetching users details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching users details: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateEmailOrPhoneNo(Request $request)
    {
        try {
            $user = auth()->user();

            $request->validate([
                'email'     => 'nullable|email|unique:gym_users,email,' . $user->id,
                'phone_no'  => 'nullable|digits:10|unique:gym_users,phone_no,' . $user->id,
            ]);

            // Update email if provided and different from current email
            if ($request->filled('email') && $request->email !== $user->email) {
                $user->email = $request->email;
            }

            // Update phone number if provided and different from current phone number
            if ($request->filled('phone_no') && $request->phone_no !== $user->phone_no) {
                $user->phone_no = $request->phone_no;
            }

            // Save the updated user information
            $user->save();

            return response()->json([
                'status'  => 200,
                'user'    => $user,
                'message' => 'Email or phone number updated successfully.',
            ], 200);
        } catch (\Exception $e) {
            // Handle exceptions such as validation or database errors
            return response()->json([
                'status'  => 500,
                'message' => 'An error occurred while updating email or phone number: ' . $e->getMessage(),
            ], 500);
        }
    }
}
