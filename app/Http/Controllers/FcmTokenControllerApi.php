<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFcmToken;
use App\Services\NotificationService;
use App\Traits\errorResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FcmTokenControllerApi extends Controller
{

    use errorResponseTrait;
    private $userFcmToken;
    private $notificationService;

    public function __construct(
        UserFcmToken $userFcmToken,
        NotificationService $notificationService
    ) {
        $this->userFcmToken = $userFcmToken;
        $this->notificationService = $notificationService;
    }

    public function addUserFcmToken(Request $request)
    {
        try {
            $request->validate([
                'fcm_token' => 'required|string',
            ]);

            $user = auth()->user();
            $userId = $user->id;

            // Attempt to update or create the FCM token record
            $token = $this->userFcmToken->create([
                'user_id'    => $userId,
                'fcm_token'  => $request->input('fcm_token')
            ]);

            return response()->json([
                'status'    => 200,
                'message'   => 'FCM token added successfully',
                'fcm_token' => $token,
            ], 200);
        } catch (Exception $e) {
            Log::error('[FcmTokenControllerApi][addUserFcmToken] Error adding token: ' . $e->getMessage());
            return $this->errorResponse('Error while adding fcm token', $e->getMessage(), 500);
        }
    }

    public function sendNotification()
    {
        $tokens = ['fy6Gp5bkT-e39UVJtBnQXR:APA91bHc_Q1oGVh_oVz3ST2x3VbKJr-5D-jhFrDk42uIefGlQsy_DH46hgevAWhi2pr9-wrLHU8F7zpj7dQDlyyGFQ7bahpvIFSezSJOn-Z_BGKLF_1Mrmwb613DN_m2_ND7DwoJOAvz'];
        $title = "Breaking News";
        $message = "Here is the Notification from server.";
        $this->notificationService->sendNotification($tokens, $title, $message, null);
    }
}
