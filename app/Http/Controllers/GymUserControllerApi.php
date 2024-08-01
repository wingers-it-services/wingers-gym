<?php

namespace App\Http\Controllers;

use App\Services\OtpService;
use App\Traits\errorResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GymUserControllerApi extends Controller
{
    use errorResponseTrait;
    protected $otpService;

    public function __construct(
        OtpService $otpService
    ) {
        $this->otpService = $otpService;
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
                'email' => 'required|email|unique:users,email',
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
            ]);
            $result = $this->otpService->verifyEmailOtp($request->email, $request->otp);
            return response()->json($result, $result['status']);
        } catch (Exception $e) {
            Log::error("[GymUserControllerApi][verifyEmailOtp] Error verifying otp: " . $e->getMessage());
            return $this->errorResponse('Error while verifying otp', $e->getMessage(), 500);
        }
    }
}
