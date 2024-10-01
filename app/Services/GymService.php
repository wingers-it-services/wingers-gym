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
            'phone_no',
            'gym_document'
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

        // Upload Gym Document
        if (isset($gymData["gym_document"])) {
            $this->uploadGymDocument($gym, $enteredGymData["gym_document"]);
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

    public function uploadGymDocument(Gym $gym, UploadedFile $document): Gym
    {
        // Delete old document if it exists
        if ($gym->gym_document) {
            $existingDocPath = public_path($gym->gym_document);
            if (file_exists($existingDocPath)) {
                unlink($existingDocPath); // Delete old document
            }
        }

        // Prepend gym name to the original document name
        $gymName = str_replace(' ', '_', $gym->gym_name); // Replace spaces with underscores for the file name
        $originalFilename = $document->getClientOriginalName();
        $filename = time() . '_' . $gymName . '_' . $originalFilename;

        // Set document path
        $documentPath = 'gym_documents/' . $filename;

        // Move the uploaded document to the gym_documents folder
        $document->move(public_path('gym_documents/'), $filename);

        // Update the gym document path in the database
        $gym->gym_document = $documentPath;
        $gym->save();

        return $gym;
    }

}
