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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship to the Gym model
    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id');
    }
}
