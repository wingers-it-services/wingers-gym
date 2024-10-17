<?php

namespace App\Services;

use App\Models\UserFcmToken;
use Exception;
use Google\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    protected $userFcmToken;

    public function __construct(UserFcmToken $userFcmToken)
    {
        $this->userFcmToken = $userFcmToken;
    }
    public function getAccessToken()
    {
        $keyFilePath = storage_path('app/gym-managment-429808-firebase-adminsdk-29htv-fc3f135641.json'); // Path to your service account JSON

        $client = new Client();
        $client->setAuthConfig($keyFilePath);
        $client->setScopes(['https://www.googleapis.com/auth/cloud-platform']); // Set the scopes here

        try {
            $accessToken = $client->fetchAccessTokenWithAssertion();
            return $accessToken['access_token'];
        } catch (Exception $e) {
            Log::error('Error fetching access token: ' . $e->getMessage());
            return null;
        }
    }

    public function sendNotification(string $title, string $message, string $image = null)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return [
                'code'    => 500,
                'status'  => false,
                'message' => 'cannot retrive fcm auth token'
            ];
        }

        $tokens = $this->userFcmToken->pluck('fcm_token');
        $url = "https://fcm.googleapis.com/v1/projects/gym-managment-429808/messages:send";
        Log::info('tokens' . $tokens);
        try {
            foreach ($tokens as $token) {
                $messagePayload = $this->createPayload($token, $title, $message, $image);

                Log::info($messagePayload);
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $messagePayload);

                if (!$response->successful()) {
                    return [
                        'code'    => 500,
                        'status'  => false,
                        'message' => $response->body()
                    ];
                }
            }
            return [
                'code'    => 200,
                'status'  => true,
                'message' => 'Notification sent successfully'
            ];
        } catch (Exception $e) {
            return [
                'code'    => 500,
                'status'  => false,
                'message' => 'Exception during notification send: ' . $e->getMessage()
            ];
        }
    }

    private function createPayload(string $token, string $title, string $message, ?string $image): array
    {
        $notification = [
            'title' => $title,
            'body'  => $message,
        ];

        if ($image) {
            $notification['image'] = $image;
        }

        return [
            'message' => [
                'token' => $token,
                'notification' => $notification
            ],
        ];
    }
}
