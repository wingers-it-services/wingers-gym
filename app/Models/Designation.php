<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Designation extends Model
{
    use SoftDeletes;
    protected $table = 'designations';

    protected $fillable = [
        'designation_name',
        'gym_id',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    /**
     * The function `addAdminDesignation` adds a new admin designation to a gym with the specified details.
     *
     * @param array designation The `addAdminDesignation` function takes an array `` and an
     * integer `` as parameters. The `` array should have a key `designation_name` which
     * is used to set the `designation_name` field in the database table when creating a new record. The
     * @param int gymId The `gymId` parameter is an integer that represents the ID of the gym to which the
     * admin designation will be added.
     */
    public function addAdminDesignation(array $designation, int $gymId)
    {
        $this->create([
            'designation_name' => $designation['designation_name'],
            'gym_id' => $gymId,
            'status' => 1
        ]);
    }
}
