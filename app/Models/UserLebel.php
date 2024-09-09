<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class UserLebel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'lebel'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function levelUsers()
    {
        return $this->hasMany(LevelUser::class, 'level_id');
    }
}
