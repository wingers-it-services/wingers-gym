<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class UserInjury extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'injury_type',
        'image'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'injury_user');
    }

    public function addInjury(array $injury, $imagePath)
    {
        try {
            return $this->create([
                'injury_type'  => $injury['injury_type'],
                'image'        => $imagePath,
            ]);
        } catch (\Throwable $e) {
            Log::error('[UserInjury][addInjury] Error adding injury: ' . $e->getMessage());
        }
    }

    public function updateInjury(array $updateInjury, $imagePath)
    {

        $InjuryDetails = $this->where('uuid', $updateInjury['uuid'])->first();

        if (!$InjuryDetails) {
            return redirect()->back()->with('error', 'Injury not found');
        }

        try {

            $InjuryDetails->update([
                'injury_type' => $updateInjury['injury_type'],
            ]);

            if (isset($imagePath)) {
                $InjuryDetails->update(['image' => $imagePath]);
            }

            return $InjuryDetails->save();
        } catch (\Throwable $e) {
            Log::error('[UserInjury][updateInjury] Error while updating injury detail: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the injury details.');
        }
    }
}
