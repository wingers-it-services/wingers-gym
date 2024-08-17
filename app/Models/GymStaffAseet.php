<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymStaffAseet extends Model
{
    protected $fillable = [
        'gym_id',
        'staff_id',
        'name',
        'category',
        'tag',
        'allocation_date',
        'price',
        'status',
        'image',
    ];

}
