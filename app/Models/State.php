<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['country_code', 'code', 'name'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'state_code', 'code');
    }
}
