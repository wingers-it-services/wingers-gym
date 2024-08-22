<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class GymGallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'gym_id',
        'upload_file',
        'file_type'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    // public function getUploadFileAttribute()
    // {
    //     $imagePath = $this->attributes['upload_file'];
    //     $defaultImagePath = 'images/profile/17.jpg';
    //     $fullImagePath = $imagePath; 

    //     // Check if the file exists in the public directory
    //     if ($imagePath && file_exists(public_path($fullImagePath))) {
    //         return asset($fullImagePath);
    //     }

    //     return asset($defaultImagePath);
    // }

    public function addGymGallery(int $gymId, string $filePath)
    {
        try {
            $mimeType = mime_content_type(public_path($filePath));
            $fileType = $this->determineFileType($mimeType);
            $this->create([
                'gym_id'      => $gymId,
                'upload_file' => $filePath,
                'file_type'   => $fileType,
            ]);
        } catch (Exception $e) {
            throw new Exception("Error adding gym gallery: " . $e->getMessage());
        }
    }

    /**
     * Determine the file type based on MIME type.
     *
     * @param string $mimeType
     * @return string
     */
    private function determineFileType(string $mimeType): string
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } else {
            return 'other';
        }
    }
}
