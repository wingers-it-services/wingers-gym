<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class Accessory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'gym_id',
        'name',
        'category',
        'brand_name',
        'model_number',
        'description',
        'quantity',
        'price',
        'condition',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function addAccessoryDetails(array $accessoryDetail,array $images)
    {
        try {
            $gym = Auth::guard('gym')->user();
            $accessory= $this->create([
                'gym_id'       => $gym->id,
                'name'         => $accessoryDetail['name'],
                'category'     => $accessoryDetail['category'],
                'brand_name'   => $accessoryDetail['brand_name'],
                'model_number' => $accessoryDetail['model_number'],
                'description'  => $accessoryDetail['description'],
                'quantity'     => $accessoryDetail['quantity'],
                'price'        => $accessoryDetail['price'],
                'condition'    => $accessoryDetail['condition'],
            ]);
            foreach ($images as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $imagePath = 'accessory_images/' . $filename;
                $image->move(public_path('accessory_images/'), $filename);
    
                ClothImage::create([
                    'product_id' => $accessory->id,
                    'image'      => $imagePath, 
                ]);
            }
            return $accessory;
        } catch (\Throwable $e) {
            Log::error('[Accessory][addAccessoryDetails] Error adding accessory details: ' . $e->getMessage());
        }
    }
}
