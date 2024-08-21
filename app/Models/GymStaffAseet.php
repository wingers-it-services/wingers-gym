<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymStaffAseet extends Model
{
    protected $fillable = [
        'gym_id',
        'staff_id',
        'name',
        'category',
        'tag',
        'allocation_date',
        'price',
        'status',
        'image'
    ];

    public function addGymStaffAsset(array $staffAssetArray, int $gymId, string $imagePath)
    {
        try {
            $this->create([
                'staff_id' => $staffAssetArray['staff_id'],
                'name' => $staffAssetArray['name'],
                'category' => $staffAssetArray['category'],
                'asset_tag' => $staffAssetArray['asset_tag'],
                'allocation_date' => $staffAssetArray['allocation_date'],
                'price' => $staffAssetArray['price'],
                'status' => $staffAssetArray['status'],
                'image' => $imagePath,
                'gym_id' => $gymId
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
