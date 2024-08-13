<?php

namespace App\Services;

use App\Models\Gym;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class GymService
{
    private $gym;
    private $gymService;

    public function __construct(
        Gym $gym
    ) {
        $this->gym = $gym;
    }

    /**
     * Register any application services.
     */
    public function createGymAccount(array $enteredGymData)
    {
        $fieldsToUpdate = [
            'gym_name',
            'email',
            'password',
            'image',
            'username',
            'address',
            'city',
            'state',
            'country',
            'web_link',
            'gym_type',
            'face_link',
            'insta_link'
        ];

        $gymData = [];
        foreach ($fieldsToUpdate as $field) {
            if (array_key_exists($field, $enteredGymData)) {
                // Hash the password before storing it
                if ($field === 'password') {
                    $gymData[$field] = Hash::make($enteredGymData[$field]);
                } else {
                    $gymData[$field] = $enteredGymData[$field];
                }
            }
        }
      

        $gym = $this->gym->updateOrCreate(
            ['email' => $enteredGymData['email']],
            $gymData
        );

        if (isset($gymData["image"])) {
            $this->uploadAdminProfilePicture($gym, $enteredGymData["image"]);
        }

        return true;
    }

    /**
     * Bootstrap any application services.
     */
    public function uploadAdminProfilePicture(Gym $gym, UploadedFile $image): Gym
    {
        if ($gym->image) {
            $oldImagePath = public_path($gym->image);
            if (File::exists($oldImagePath)) {
                // Delete the old image
                if (!File::delete($oldImagePath)) {
                    // Log an error message if the deletion fails
                    \Log::error("Failed to delete old image: $oldImagePath");
                }
            } else {
                // Log an error message if the file does not exist
                \Log::error("Old image does not exist: $oldImagePath");
            }
        }

        // Save the new image
        $filename = time() . '_' . $image->getClientOriginalName();
        $imagePath = 'gymProfile_images/' . $filename;
        $image->move(public_path('gymProfile_images/'), $filename);

        $gym->image = $imagePath;
        $gym->save();

        return $gym;
    }
}
