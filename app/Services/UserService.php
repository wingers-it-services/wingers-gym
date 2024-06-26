<?php

namespace App\Services;

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
            'gym_id',
            'first_name',
            'last_name',
            'email',
            'gender',
            'phone_no',
            'username',
            'password',
            'image',
        ];

        $userData = [];
        foreach ($fieldsToUpdate as $field) {
            if ($field === 'gym_id') {
                $userData[$field] = $gymId;
            } elseif (array_key_exists($field, $enteredUserData)) {
                $userData[$field] = $enteredUserData[$field];
            }
        }

        $user = $this->user->updateOrCreate(
            ['username' => $enteredUserData['username']],
            $userData
        );

        if ($userData["image"]) {
            $this->uploadAdminProfilePicture($user, $enteredUserData["image"]);
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
