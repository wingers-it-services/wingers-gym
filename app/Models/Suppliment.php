<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'suppliments_name' ,
    'brand_name',
    'image',
    'rate',
    'comission' , 
    'discount' , 
    'gst',
    'amount', 
    'company_name' , 
    'company_contact',
    'company_address',
    'company_website',
    'description' , 
    'warrenty',
    'ttem_form',
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
