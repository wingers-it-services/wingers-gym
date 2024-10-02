<?php

namespace App\Services;

use Exception;
use Google\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NotificationService
{
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

    public function sendNotification(array $tokens, string $title, string $message, string $image = null)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return false;
        }

        $url = "https://fcm.googleapis.com/v1/projects/gym-managment-429808/messages:send";

        try {
            foreach ($tokens as $token) {
                $messagePayload = $this->createPayload($token, $title, $message, $image);

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $messagePayload);

                if (!$response->successful()) {
                    Log::error('Error sending notification: ' . $response->body());
                    return false;
                }
            }

            Log::info('Notification sent successfully');
            return true;
        } catch (Exception $e) {
            Log::error('Exception during notification send: ' . $e->getMessage());
            return false;
        }
    }

    private function createPayload(string $token, string $title, string $message, ?string $image): array
    {
        $notification = [
            'title' => $title,
            'body' => $message,
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
