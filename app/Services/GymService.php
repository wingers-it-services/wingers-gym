<?php

namespace App\Services;

use App\Models\Gym;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            'image',
            'password',
            'image',
            'username',
            'address',
            'city_id',
            'state_id',
            'country_id',
            'web_link',
            'gym_type',
            'face_link',
            'insta_link',
            'qrcode',
            'phone_no'
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

        $qrCodeId = $gym->uuid; // Customize this URL as needed

        // Generate the QR code and save it as an SVG file
        $qrCode = QrCode::size(256)->generate($qrCodeId);
        $path = 'qrcodes/';
        $filename = 'qrcode_' . $qrCodeId . '.svg';
        $imagePath = public_path($path . $filename);

        // Save the QR code file
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true); // Ensure the directory exists
        }
        file_put_contents($imagePath, $qrCode);

        // Update the gym record with the QR code path
        $gym->update([
            'qrcode' => $path . $filename
        ]);


        return true;
    }

    /**
     * Bootstrap any application services.
     */
    public function uploadAdminProfilePicture(Gym $gym, UploadedFile $image): Gym
    {
        if ($gym->image) {
            $imagePath = $gym->image;
            
            if ($gym->image) {
                $existingImagePath = public_path($gym->image);
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath); // Delete old image
                }
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
