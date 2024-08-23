<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class Suppliment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'gym_id',
        'suppliments_name',
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
        'item_form',
        'manufacturer',
        'flavour',
        'age_range',
        'size',
        'net_quantity',
        'diet_type',
        'product_benefits',
        'item_dimensions',
        'special_ingredients'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function addSupplimentDetails(array $supplimentDetail, array $images)
    {
        try {
            $gym = Auth::guard('gym')->user();
            $suppliment = $this->create([
                'gym_id'       => $gym->id,
                'name'         => $supplimentDetail['name'],
                'category'     => $supplimentDetail['category'],
                'size'         => $supplimentDetail['size'],
                'brand_name'   => $supplimentDetail['brand_name'],
                'quantity'     => $supplimentDetail['quantity'],
                'price'        => $supplimentDetail['price'],
                'material'     => $supplimentDetail['material'],
                'description'  => $supplimentDetail['description'],
            ]);

            foreach ($images as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $imagePath = 'suppliment_images/' . $filename;
                $image->move(public_path('suppliment_images/'), $filename);
    
                SupplimentImage::create([
                    'product_id' => $suppliment->id,
                    'image'      => $imagePath, 
                ]);
            }
            return $suppliment;
        } catch (\Throwable $e) {
            Log::error('[Suppliment][addSupplimentDetails] Error adding suppliment details: ' . $e->getMessage());
        }
    }
}
