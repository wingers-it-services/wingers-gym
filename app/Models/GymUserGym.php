<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymUserGym extends Model
{
    protected $fillable = [
        'user_id',
        'gym_id'
       
    ];

    public static function countUsersInGym(int $gymId)
    {
        return self::where('gym_id', $gymId)->count();
    }
}
