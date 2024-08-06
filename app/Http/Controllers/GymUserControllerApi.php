<?php

namespace App\Http\Controllers;

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
        $this->userService=$userService;
    }

    public function sendMobileOtp(Request $request)
    {
        try {
            $request->validate([
                'phone_no' => ['required', 'digits:10']
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
            $validatedData = $request->validate([
                'firstname' => 'required',
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

            $response = $this->user->completeUserProfile($userDetail, $imagePath);

            return response()->json([
                'status'  => $response['status'],
                'message' => $response['message'],
                'user'    => $response['user'] ?? null
            ], $response['status']);
        } catch (Throwable $e) {
            Log::error("[GymUserControllerApi][registerGymUser] Error in registration otp: " . $e->getMessage());
            return $this->errorResponse('Error while registering', $e->getMessage(), 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'otp'      => 'required|digits:4',
                'email'    => 'required_without:phone_no|email|unique:users,email',
                'phone_no' => 'required_without:email|digits:10|unique:users,phone_no',
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
                'uuid'    =>'required',
                'height'  =>'required',
                'weight'  =>'required',
                'days'    =>'required',
                'goals'   => 'array',
                'goals.*' => 'exists:goals,id', // Ensure each goal ID exists in the goals table
               'levels'   => 'array',
               'levels.*' => 'exists:user_levels,id'
            ]);

            $request=$request->all();
            
            $result = $this->user->profilePartFour($request);
            return response()->json($result, $result['status']);
        } catch (Exception $e) {
            Log::error("[GymUserControllerApi][profilePartFour] Error updating profile: " . $e->getMessage());
            return $this->errorResponse('Error while updating profile', $e->getMessage(), 500);
        }
    }
}