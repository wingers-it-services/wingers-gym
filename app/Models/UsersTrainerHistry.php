<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersTrainerHistry extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'user_id',
        'trainer_id',
    ];
}
