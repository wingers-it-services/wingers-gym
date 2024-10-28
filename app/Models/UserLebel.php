<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
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

    public function goalWiseWorkouts()
    {
        return $this->hasMany(GoalWiseWorkouts::class, 'user_lebel_id');
    }

    public function goalWiseDiets()
    {
        return $this->hasMany(GoalWiseDiet::class, 'user_lebel_id');
    }

    public function addLebel(array $lebel)
    {
        try {
            return $this->create([
                'lebel'  => $lebel['lebel']
            ]);
        } catch (\Throwable $e) {
            Log::error('[UserLebel][addLebel] Error adding lebel: ' . $e->getMessage());
        }
    }

    public function updateLebel(array $updateLebel)
    {

        $lebelDetails = $this->where('uuid', $updateLebel['uuid'])->first();

        if (!$lebelDetails) {
            return redirect()->back()->with('error', 'Lebel not found');
        }
        try {
            $lebelDetails->update([
                'lebel' => $updateLebel['lebel'],
            ]);
            return $lebelDetails->save();
        } catch (\Throwable $e) {
            Log::error('[UserLebel][updateLebel] Error while updating lebel detail: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the lebel details.');
        }
    }
}
