<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentUserDiet extends Model
{
    protected $fillable = ['gym_id', 'user_id', 'diet_id', 'current_day', 'is_completed'];
}
