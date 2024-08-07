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

    public function __construct(
        OtpService $otpService,
        User $user,
        UserService $userService
    ) {
        $this->otpService = $otpService;
        $this->user = $user;
        $this->userService = $userService;
    }

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

    public function verifyMobileOtp(Request $request)
    {
        try {
            $request->validate([
                'phone_no' => 'required',
                'otp' => 'required|digits:4',
            ]);
            $result = $this->otpService->verifyMobileOtp($request->phone_no, $request->otp);
            return response()->json($result, $result['status']);
        } catch (Exception $e) {
            Log::error("[GymUserControllerApi][verifyMobileOtp] Error verifying otp: " . $e->getMessage());
            return $this->errorResponse('Error while verifying otp', $e->getMessage(), 500);
        }
    }

    public function verifyEmailOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'otp' => 'required|digits:4',
            ]);
            $result = $this->otpService->verifyEmailOtp($request->email, $request->otp);
            return response()->json($result, $result['status']);
        } catch (Exception $e) {
            Log::error("[GymUserControllerApi][verifyEmailOtp] Error verifying otp: " . $e->getMessage());
            return $this->errorResponse('Error while verifying otp', $e->getMessage(), 500);
        }
    }

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

            return response()->json([
                'status'  => $response['status'],
                'message' => $response['message'],
                'user'    => $response['user'] ?? null
            ], $response['status']);
        } catch (Throwable $e) {
            Log::error("[GymUserControllerApi][registerGymUser] Error in registration: " . $e->getMessage());
            return $this->errorResponse('Error while registering', $e->getMessage(), 500);
        }
    }

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
            $gyms = $user->gyms;

            if ($gyms->isEmpty()) {
                return response()->json([
                    'status'   => 422,
                    'gyms' => $gyms,
                    'message'  => 'There is no gyms'
                ], 200);
            }

            return response()->json([
                'status'  => 200,
                'gyms'    => $gyms,
                'message' => 'User gyms Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[GymUserControllerApi][fetchUserGym]Error fetching gyms details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching gyms details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function addUserInjuries(Request $request)
    {
        try {
            $request->validate([
                'uuid'         => 'required',
                'injury_ids'   => 'array|required',
                'injury_ids.*' => 'exists:user_injuries,id'
            ]);

            // Fetch the user using UUID
            $user = User::where('uuid', $request->uuid)->first();

            if (!$user) {
                return response()->json([
                    'status' => 404,
                    'message' => 'User not found',
                ], 404);
            }

            // Associate each injury with the user
            $injuryUsers = [];
            foreach ($request->injury_ids as $injuryId) {
                $injuryUser = InjuryUser::create([
                    'user_id' => $user->id,
                    'injury_id' => $injuryId,
                ]);
                $injuryUsers[] = $injuryUser;
            }


        $user->profile_status = GymUserAccountStatusEnum::INJURY_DETAIL_COMPLETED;
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
}
