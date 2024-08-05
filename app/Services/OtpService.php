<?php

namespace App\Services;

use App\Enums\GymUserAccountStatusEnum;
use App\Mail\OtpMail;
use App\Models\MobileAndEmailOtp;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    protected $mobileAndEmailOtp;

    public function __construct(MobileAndEmailOtp $mobileAndEmailOtp)
    {
        $this->mobileAndEmailOtp = $mobileAndEmailOtp;
    }

    public function generateMobileOtp($phone_no)
    {
        try {
            $sendMessageOtp = false;
            $otp = "1234";

            if ($sendMessageOtp) {
                $four_digit_random_number = random_int(1000, 9999);
                // Convert the random number to a string
                $otp = strval($four_digit_random_number);
                // $response = $this->fast2sms->sendOTP($request->input('phone_no'), $otp);
            }

            $this->mobileAndEmailOtp->updateOrCreate([
                'phone_no' => $phone_no
            ], [
                'otp' => $otp
            ]);

            return [
                'status'   => 200,
                'message'  => 'OTP sent successfully',
                'phone_no' => $phone_no,
            ];
        } catch (Exception $e) {
            Log::error("[OtpService][generateOtp] Error sending otp: " . $e->getMessage());
            return [
                'status'       => 500,
                'message'      => 'Error while sending otp',
                'errorMessage' => $e->getMessage(),
            ];
        }
    }

    public function sendOtptoEmail($email)
    {
        try {

            // $otp = strval(random_int(1000, 9999));
            
            $otp = 1234;

            // Mail::to($email)->send(new OtpMail($otp));


            // $data = ['otp' => $otp];
            // Mail::send([], [], function ($message) use ($email, $otp) {
            //     $message->to($email)
            //             ->subject('Your OTP Code')
            //             ->html('<html><body><p>Your OTP code is: ' . $otp . '</p></body></html>');
            //       $message->from('anjali.wingersitservices@gmail.com', 'Your App Name');
            // });

            $this->mobileAndEmailOtp->updateOrCreate([
                'email' => $email
            ], [
                'otp'   => $otp
            ]);

            return [
                'status'  => 200,
                'message' => 'OTP sent successfully',
                'otp'     => $otp,
                'email'   => $email
            ];
        } catch (\Throwable $e) {
            Log::error("[OtpControllerApi][sendOtptoEmail]Error sending email verification otp:" . $e->getMessage());
            return [
                'status'       => 500,
                'message'      => 'Error sending OTP',
                'errorMessage' => $e->getMessage()
            ];
        }
    }

    public function verifyMobileOtp($phone_no, $otp)
    {
        try {
            $otpDetail = $this->mobileAndEmailOtp->where('phone_no', $phone_no)->first();
            if (!$otpDetail) {
                return [
                    'status'       => 404,
                    'message'      => 'Error while verifying OTP',
                    'errorMessage' => 'Please provide correct phone number.'
                ];
            }

            if ($otpDetail->otp == $otp) {
                // OTP is correct, check if user exists
                $user = User::where('phone_no', $phone_no)->first();
                if ($user) {
                    $user->is_phone_no_verified = true;
                    $user->save();
                } else {
                    $user = User::create([
                        'phone_no'             => $phone_no,
                        'is_phone_no_verified' => true,
                        'profile_status'       => GymUserAccountStatusEnum::MOBILE_NUMBER_VERIFIED
                    ]);
                }

                return [
                    'status'       => 200,
                    'message'      => 'OTP verified successfully',
                    'phone_no'     => $phone_no
                ];
            } else {
                return [
                    'status'       => 422,
                    'message'      => 'Please enter correct OTP',
                    'errorMessage' => "Provided OTP {$otp} is incorrect."
                ];
            }
        } catch (\Exception $e) {
            Log::error("[OtpService][verifyMobileOtp] Error verifying otp: " . $e->getMessage());
            return [
                'status'       => 500,
                'message'      => 'Error while verifying otp',
                'errorMessage' => $e->getMessage(),
            ];
        }
    }

    public function verifyEmailOtp($email, $otp)
    {
        try {
            $otpDetail = $this->mobileAndEmailOtp->where('email', $email)->first();
            if (!$otpDetail) {
                return [
                    'status'       => 404,
                    'message'      => 'Error while verifying OTP',
                    'errorMessage' => 'Please provide correct email.'
                ];
            }

            if ($otpDetail->otp == $otp) {
                $user = User::where('email', $email)->first();
                if ($user) {
                    $user->is_email_verified = true;
                    $user->save();
                }
                return [
                    'status'  => 200,
                    'message' => 'OTP verified succesfully',
                    'email'   => $email
                ];
            } else {
                return [
                    'status'       => 422,
                    'message'      => 'Please enter correct OTP',
                    'errorMessage' => "Provided OTP {$otp} is incorrect."
                ];
            }
        } catch (Exception $e) {
            Log::error("[OtpService][verifyEmailOtp] Error verifying otp: " . $e->getMessage());
            return [
                'status'       => 500,
                'message'      => 'Error while verifying otp',
                'errorMessage' => $e->getMessage(),
            ];
        }
    }
}
