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
        'special_ingredients',
        'category'
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
                'suppliments_name'         => $supplimentDetail['name'],
                'brand_name'   => $supplimentDetail['brand_name'],
                'rate'        => $supplimentDetail['price'],
                'comission'        => $supplimentDetail['comission'],
                'discount'        => $supplimentDetail['discount'],
                'gst'        => $supplimentDetail['gst'],
                'amount'        => $supplimentDetail['amount']??00,
                'company_name'        => $supplimentDetail['company_name'],
                'company_contact'        => $supplimentDetail['company_contact'],
                'company_address'        => $supplimentDetail['company_address'],
                'company_website'        => $supplimentDetail['suppliment_company_website'],
                'description'  => $supplimentDetail['description'],
                'warrenty'  => $supplimentDetail['supliment_warrenty'],
                'warrenty_details'  => $supplimentDetail['supliment_warrenty_details'],
                'item_form'  => $supplimentDetail['item_form'],
                'manufacturer'  => $supplimentDetail['manufacturer'],
                'flavour'  => $supplimentDetail['flavour'],
                'age_range'  => $supplimentDetail['age_range'],
                'size'  => $supplimentDetail['supliment_size'],
                'net_quantity'  => $supplimentDetail['quantity'],
                'diet_type'  => $supplimentDetail['diet_type'],
                'product_benefits'  => $supplimentDetail['product_benefits'],
                'item_dimensions'  => $supplimentDetail['item_dimensions'],
                'special_ingredients'  => $supplimentDetail['special_ingredients'],
             'category'     => $supplimentDetail['category'],
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
