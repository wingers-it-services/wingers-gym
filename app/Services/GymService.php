<?php

namespace App\Services;

use App\Models\Gym;
use Illuminate\Http\UploadedFile;

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
            'address',
            'country',
            'image',
            'state',
            'city',
            'web_link',
            'gym_type',
            'subscription_id',
            'terms_and_conditions',
            'facebook',
            'instagram'
        ];

        $gymData = [];
        foreach ($fieldsToUpdate as $field) {
            if (array_key_exists($field, $enteredGymData)) {
                $gymData[$field] = $enteredGymData[$field];
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
        if ($image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'gymProfile_images/' . $filename;
            $image->move(public_path('gymProfile_images/'), $filename);

            $gym->image = $$imagePath;
            $gym->save();
        }
        return $gym;
    }
}
