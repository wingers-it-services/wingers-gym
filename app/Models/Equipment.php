<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class Equipment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'gym_id',
        'equipment_name',
        'brand_name',
        'rate',
        'comission',
        'discount',
        'gst',
        'amount',
        'company_name',
        'company_contact',
        'company_address',
        'company_website',
        'description',
        'warrenty',
        'warrenty_details',
        'item_weight',
        'colour',
        'tension_level',
        'material',
        'special_feautre',
        'size'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function addEquipmentsDetails(array $equipmentDetail, array $images)
    {
        try {
            $gym = Auth::guard('gym')->user();
            $equipment = $this->create([
                'gym_id'       => $gym->id,
                'name'         => $equipmentDetail['name'],
                'category'     => $equipmentDetail['category'],
                'size'         => $equipmentDetail['size'],
                'brand_name'   => $equipmentDetail['brand_name'],
                'quantity'     => $equipmentDetail['quantity'],
                'price'        => $equipmentDetail['price'],
                'material'     => $equipmentDetail['material'],
                'description'  => $equipmentDetail['description'],
            ]);

            foreach ($images as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $imagePath = 'equipment_images/' . $filename;
                $image->move(public_path('equipment_images/'), $filename);
    
                EquipmentImage::create([
                    'product_id' => $equipment->id,
                    'image'      => $imagePath, 
                ]);
            }
            return $equipment;
        } catch (\Throwable $e) {
            Log::error('[Equipment][addEquipmentsDetails] Error adding equipment details: ' . $e->getMessage());
        }
    }
}
