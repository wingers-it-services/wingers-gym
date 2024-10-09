<?php

namespace App\Services;

use App\Enums\GymSubscriptionStatusEnum;
use App\Enums\GymUserAccountStatusEnum;
use App\Enums\UserTypeEnum;
use App\Models\GymUserGym;
use App\Models\User;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class UserService
{
    private $user;

    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    public function createUserAccount(array $enteredUserData, $gymId)
    {
        $fieldsToUpdate = [
            'firstname',
            'lastname',
            'email',
            'gender',
            'subscription_id',
            'blood_group',
            'joining_date',
            'address',
            'country',
            'state',
            'city',
            'zip_code',
            'image',
            'end_date',
            'coupon_id',
            'subscription_status',
            'profile_status',
            'staff_assign_id',
            'gym_id',
            'password',
            'user_type',
            'phone_no',
            'subscription_start_date',
            'subscription_end_date',
            'dob'
        ];

        $userData = [];
        foreach ($fieldsToUpdate as $field) {
            if ($field === 'gym_id') {
                $userData[$field] = $gymId;
            } elseif (array_key_exists($field, $enteredUserData)) {
                $userData[$field] = $enteredUserData[$field];
            }
        }
        if (isset($enteredUserData['profile_status'])) {
            $userData['profile_status'] = GymUserAccountStatusEnum::PROFILE_DETAIL_COMPLETED;
        }
        $userData['subscription_status'] = GymSubscriptionStatusEnum::ACTIVE;
        // $userData['profile_status'] = GymUserAccountStatusEnum::PROFILE_DETAIL_COMPLETED;
        $userData['user_type'] = UserTypeEnum::GYMUSER;

        $user = $this->user->updateOrCreate(
            ['email' => $enteredUserData['email']],
            $userData
        );

        if (isset($userData["image"])) {
            $this->uploadAdminProfilePicture($user, $enteredUserData["image"]);
        }

        $existingAssociation = GymUserGym::where('user_id', $user->id)
            ->where('gym_id', $gymId)
            ->first();

        if (!$existingAssociation) {
            GymUserGym::create([
                'user_id' => $user->id,
                'gym_id'  => $gymId,
            ]);
        }

        return true;
    }


    public function uploadAdminProfilePicture(User $user, UploadedFile $image): User
    {
        if ($image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'user_images/' . $filename;
            $image->move(public_path('user_images/'), $filename);

            $user->image = $imagePath;
            $user->save();
        }
        return $user;
    }


    //Admin user profile upload
    public function uploadUserProfileImage(UploadedFile $file)
    {
        if ($file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $imagePath = 'admin_user_images/' . $filename;
            $file->move(public_path('admin_user_images/'), $filename);
            return $imagePath;
        }
    }

    public function resetPassword($newPassword, $user = null, $email = null)
    {
        try {
            // Determine the user to update
            $userToUpdate = $user ?? User::where('email', $email)->first();

            // If a user is found, update their password
            if ($userToUpdate) {
                return $this->setPassword($userToUpdate, $newPassword);
            }

            // Customize message if neither user nor email is provided
            if (!$user && !$email) {
                return [
                    'status'  => 400,
                    'message' => 'Email is required to update the password.'
                ];
            }

            return [
                'status'  => 404,
                'message' => 'User not found with the provided email'
            ];
        } catch (Exception $e) {
            Log::error('[UserService][updatePassword] Error while updating password: ' . $e->getMessage());
            return [
                'status'       => 500,
                'message'      => 'An error occurred while updating the password',
                'errorMessage' => $e->getMessage()
            ];
        }
    }

    public function changePassword(User $user, $oldPassword, $newPassword)
    {
        try {
            if (!$user) {
                return [
                    'status'  => 404,
                    'message' => 'User not found',
                ];
            }

            if ($user->password != $oldPassword) {
                return [
                    'status'  => 400,
                    'message' => 'Incorrect old password',
                ];
            }

            return $this->setPassword($user, $newPassword);
        } catch (Exception $e) {
            Log::error('[UserService][changePassword] Error while changing password: ' . $e->getMessage());
            return [
                'status'       => 500,
                'message'      => 'Internal server error while changing password',
                'errorMessage' => $e->getMessage(),
            ];
        }
    }


    private function setPassword(User $user, $password)
    {
        $user->password = $password;
        $user->save();
        return [
            'status'  => 200,
            'message' => 'password updated successfully.'
        ];
    }
}
