<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Product extends Model
{

    protected $guard = 'gym';

    protected $fillable = [
        'gym_id',
        'name',
        'product_code',
        'brand',
        'category',
        'product_tag',
        'total_rating',
        'price',
        'review_count',
        'availability',
        'description'
    ];


    /**
     * The function generates a UUID and assigns it to the 'uuid' attribute of a model before it is
     * created.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    /**
     * The `gym` function in PHP returns a relationship with the `Gym` class based on the `id`
     * attribute.
     * 
     * @return This function is returning a relationship between the current model and the Gym model.
     * It specifies that the current model belongs to the Gym model using the 'id' column as the
     * foreign key on both models.
     */
    public function gym()
    {
        return $this->belongsTo(Gym::class, 'id', 'gym_id');
    }
}
