<?php

namespace App\Services;

use App\Enums\GymSubscriptionStatusEnum;
use App\Enums\GymUserAccountStatusEnum;
use App\Enums\UserTypeEnum;
use App\Models\GymUserGym;
use App\Models\User;
use Illuminate\Http\UploadedFile;

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

        $userData['subscription_status'] = GymSubscriptionStatusEnum::ACTIVE;
        $userData['profile_status'] = GymUserAccountStatusEnum::PROFILE_DETAIL_COMPLETED;
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
}
