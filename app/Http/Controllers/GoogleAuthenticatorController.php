<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GoogleAuthenticatorController extends Controller
{

    public function setupGoogleAuthenticator(Request $request)
    {
        $gym = Auth::guard('gym')->user();

        $google2fa = new Google2FA();

        if (!$gym->google2fa_secret) {
            $secretKey = $google2fa->generateSecretKey();
            $gym->google2fa_secret = $secretKey;
            $gym->save();
        } else {
            $secretKey = $gym->google2fa_secret;
        }

        $qrCodeImage = $google2fa->getQRCodeUrl(
            'Wingers Gym',
            $gym->email,
            $secretKey
        );

        $QRImageUrl = QrCode::size(200)->generate($qrCodeImage);

        return view('GymGoogleAuthenticator.setup-google-authenticator', compact('QRImageUrl', 'secretKey'));
    }

    public function showForgotPasswordForm()
    {
        $status = null;
        $message = null;
        return view('GymGoogleAuthenticator.forgot-password', compact('status', 'message'));
    }

    public function verifyGoogleAuthenticatorForPasswordReset(Request $request)
    {
        $request->validate([
            'email'                     => 'required|email',
            'google_authenticator_code' => 'required|numeric',
        ]);

        $gym = Gym::where('email', $request->email)->first();

        if (!$gym) {
            return back()->with('status', 'error')->with('message', 'No user found with this email.');
        }

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($gym->google2fa_secret, $request->google_authenticator_code);

        if ($valid) {
            return redirect()->route('gym.show-reset-password-form')->with('email', $gym->email);
        } else {
            return back()->with('atatus', 'error')->with('message', 'Invalid code.' . $request->google_authenticator_code);
        }
    }

    public function showResetPasswordForm(Request $request)
    {
        $status = null;
        $message = null;
        $gym = Auth::guard('gym')->user();
        $email = $gym->email;
        return view('GymGoogleAuthenticator.reset-password', compact('email','status','message'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $gym = Gym::where('email', $request->email)->first();

        if (!$gym) {
            return back()->withErrors(['email' => 'No user found with this email.']);
        }

        $gym->password = bcrypt($request->password);
        $gym->save();

        return redirect('/')->with('status', 'Password reset successfully!');
    }
}
