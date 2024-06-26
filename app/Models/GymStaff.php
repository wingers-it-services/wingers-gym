<?php

namespace App\Models;

use App\Traits\SessionTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Log;

class GymStaff extends Model
{
    use SoftDeletes;
    use SessionTrait;
    protected $table = 'gym_staffs';
    protected $fillable = [
        'name',
        'designation_id',
        'salary',
        'image',
        'gym_id',
        'employee_id',
        'email',
        'number',
        'address',
        'joining_date'
    ];


    public function addGymStaff(array $gymStaffArray, int $gymId, ?string $imagePath)
    {
        try {
            $this->create([
                'name' => $gymStaffArray['full_name'],
                'blood_group' => $gymStaffArray['blood_group'],
                'employee_id' => $gymStaffArray['staff_id'],
                'email' => $gymStaffArray['email'],
                'number' => $gymStaffArray['phone_number'],
                'designation_id' => $gymStaffArray['designation'],
                'joining_date' => $gymStaffArray['joining_date'],
                'address' => $gymStaffArray['address'],
                'salary' => $gymStaffArray['salary'],
                'image' => $imagePath,
                'gym_id' => $gymId
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateStaff(array $updateStaff, $imagePath)
    {

        $uuid = $updateStaff['uuid'];
        $staffDetail = GymStaff::where('uuid', $uuid)->first();

        // Check if the user exists
        if (!$staffDetail) {
            return redirect()->back()->with('error', 'User not found');
        }
        try {
            $staffDetail->update([
                'name' => $updateStaff['member_name'],
                'designation_id' => $updateStaff['member_designation'],
                'salary' => $updateStaff['salary'],
            ]);

            if (isset($imagePath)) {
                $staffDetail->update([
                    'image' => $imagePath
                ]);
            }


            return $staffDetail->save();
        } catch (\Throwable $e) {
            Log::error('[GymStaff][updateStaff] Error while updating user detail: ' . $e->getMessage());
        }
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
