<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


class GymStaffAseet extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'gym_id',
        'staff_id',
        'name',
        'category',
        'asset_tag',
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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
