<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
