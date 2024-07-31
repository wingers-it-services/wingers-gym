<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GymUserControllerApi extends Controller
{
    public function sendMobileOtp(Request $request)
    {
        try {
            $request->validate([
                'phone_no' => ['required', 'digits:10']
            ]);
            $result = $this->otpService->generateOtp($request->phone_no);
            return response()->json($result, $result['status']);
        } catch (Exception $e) {
            Log::error("[CustomerControllerApi][sendCustomerOtp] Error sending otp: " . $e->getMessage());
            return $this->errorResponse('Error while sending otp', $e->getMessage(), 500);
        }
    }
}
