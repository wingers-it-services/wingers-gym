<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function states()
    {
        return $this->hasMany(State::class, 'country_code', 'code');
    }

    public function cities()
    {
        return $this->hasManyThrough(City::class, State::class, 'country_code', 'state_code', 'code', 'code');
    }
}
