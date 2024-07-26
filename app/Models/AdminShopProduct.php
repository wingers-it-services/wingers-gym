<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class AdminShopProduct extends Model
{
    protected $fillable = [
        'image',
        'product_name',
        'product_code',
        'product_brand',
        'address',
        'availability',
        'description'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function addAdminProduct(array $validateData, $imagePath)
    {
        try {
            return $this->create([
                'product_name' => $validateData['product_name'],
                'product_code' => $validateData['product_code'],
                'product_brand' => $validateData['product_brand'],
                'address' => $validateData['address'],
                'availability' => $validateData['availability'],
                'image'   => $imagePath,
                'description' => $validateData['description'],
            ]);
        } catch (\Throwable $e) {
            Log::error('[AdminShopProduct][addAdminProduct] Error adding admin subscription: ' . $e->getMessage());
        }
    }

}
