<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class MarketingAdvertisement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'advertisement_type',
        'targetted_no',
        'city',
        'state',
        'country',
        'address',
        'email',
        'phone_no'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function addMarketingAdvertisement(array $marketingAdvertisement)
    {
        $this->create([
            'advertisement_type' => $marketingAdvertisement['advertisement_type'],
            'targetted_no'       => $marketingAdvertisement['targetted_no'],
            'city'               => $marketingAdvertisement['city'],
            'state'              => $marketingAdvertisement['state'],
            'country'            => $marketingAdvertisement['country'],
            'address'            => $marketingAdvertisement['address'],
            'email'              => $marketingAdvertisement['email'],
            'phone_no'           => $marketingAdvertisement['phone_no']
        ]);
    }
}
