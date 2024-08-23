<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class Cloth extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'gym_id',
        'name',
        'category',
        'size',
        'brand_name',
        'quantity',
        'price',
        'material',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function addClothsDetails(array $clothDetail, array $images)
    {
        try {
            $gym = Auth::guard('gym')->user();
            $cloth = $this->create([
                'gym_id'       => $gym->id,
                'name'         => $clothDetail['name'],
                'category'     => $clothDetail['category'],
                'size'         => $clothDetail['size'],
                'brand_name'   => $clothDetail['brand_name'],
                'quantity'     => $clothDetail['quantity'],
                'price'        => $clothDetail['price'],
                'material'     => $clothDetail['material'],
                'description'  => $clothDetail['description'],
            ]);

            foreach ($images as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $imagePath = 'cloth_images/' . $filename;
                $image->move(public_path('cloth_images/'), $filename);
    
                ClothImage::create([
                    'product_id' => $cloth->id,
                    'image'      => $imagePath, 
                ]);
            }
            return $cloth;
        } catch (\Throwable $e) {
            Log::error('[Cloth][addClothsDetails] Error adding cloths details: ' . $e->getMessage());
        }
    }
}
