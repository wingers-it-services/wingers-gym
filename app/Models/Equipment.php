<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_name',
        'brand_name',
        'image',
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
}
