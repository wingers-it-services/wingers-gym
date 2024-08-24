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
        'special_feautres',
        'size',
        'category'
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
                'equipment_name'         => $equipmentDetail['name'],
                'brand_name'   => $equipmentDetail['brand_name'],
                'rate'        => $equipmentDetail['price'],
                'comission'        => $equipmentDetail['equipment_comission'],
                'discount'        => $equipmentDetail['equipment_discount'],
                'gst'        => $equipmentDetail['equipment_gst'],
                'amount'        => $equipmentDetail['amount']??00,
                'company_name'        => $equipmentDetail['equipment_company_name'],
                'company_contact'        => $equipmentDetail['equipment_company_contact'],
                'company_address'        => $equipmentDetail['equipment_company_address'],
                'company_website'        => $equipmentDetail['equipment_company_website'],
                'description'  => $equipmentDetail['description'],
                'warrenty'  => $equipmentDetail['equipment_warrenty'],
                'warrenty_details'  => $equipmentDetail['equipment_warrenty_details'],
                'item_weight'  => $equipmentDetail['item_weight'],
                'colour'  => $equipmentDetail['colour'],
                'tension_level'  => $equipmentDetail['tension_level'],
                'special_feautres'  => $equipmentDetail['special_feautre'],
                'size'  => $equipmentDetail['equipment_size'],
                'material'  => $equipmentDetail['equipment_material'],
                'category'     => $equipmentDetail['category'],
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
