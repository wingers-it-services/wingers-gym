<?php

namespace App\Models;

use App\Traits\SessionTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Log;

class GymStaff extends Model
{
    use SoftDeletes;
    use SessionTrait;
    protected $table = 'gym_staffs';
    protected $fillable = [
        'name',
        'gender',
        'designation_id',
        'salary',
        'image',
        'gym_id',
        'employee_id',
        'blood_group',
        'email',
        'number',
        'address',
        'joining_date',
        'experience',
        'dob',
        'whatsapp_no',
        'fees',
        'staff_commission',
        'gym_commission'

    ];

    public function aadhaarCard()
    {
        return $this->hasOne(StaffDocument::class, 'staff_id');
    }


    public function addGymStaff(array $gymStaffArray, int $gymId, string $imagePath)
    {
        DB::beginTransaction();
        try {
            $gymStaff =  $this->create([
                'name'             => $gymStaffArray['full_name'],
                'gender'           => $gymStaffArray['gender'],
                'blood_group'      => $gymStaffArray['blood_group'],
                'employee_id'      => $gymStaffArray['staff_id'],
                'email'            => $gymStaffArray['email'],
                'number'           => $gymStaffArray['phone_number'],
                'designation_id'   => $gymStaffArray['designation'],
                'joining_date'     => $gymStaffArray['joining_date'],
                'address'          => $gymStaffArray['address'],
                'salary'           => $gymStaffArray['salary'],
                'experience'       => $gymStaffArray['experience'],
                'dob'              => $gymStaffArray['dob'],
                'whatsapp_no'      => $gymStaffArray['whatsapp_no'],
                'fees'             => $gymStaffArray['fees'] ?? 0,
                'staff_commission' => $gymStaffArray['staff_commission'] ?? 0,
                'gym_commission'   => $gymStaffArray['gym_commission'] ?? 0,
                'image'            => $imagePath,
                'gym_id'           => $gymId
            ]);

            if (isset($gymStaffArray['aadhaar_card'])) {
                $image = $gymStaffArray['aadhaar_card'];
                $filename = time() . '_' . $image->getClientOriginalName();
                $adharCardPath = 'staff_adharcard/' . $filename;
                $image->move(public_path('staff_adharcard/'), $filename);
                $gymStaff->aadhaarCard()->create([
                    'aadhaar_card' => $adharCardPath,
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function updateStaff(array $updateStaff, $imagePath)
    {
        $uuid = $updateStaff['uuid'];
        $staffDetail = GymStaff::where('uuid', $uuid)->first();

        if (!$staffDetail) {
            return redirect()->back()->with('error', 'User not found');
        }

        try {
            // Retrieve the designation
            $designation = Designation::where('id', $updateStaff['designation'])->first();

            if (!$designation) {
                return redirect()->back()->with('error', 'Designation not found');
            }

            // Check if the designation is commission-based
            if (!$designation->is_commission_based) {
                $updateStaff['fees'] = 0;
                $updateStaff['staff_commission'] = 0;
                $updateStaff['gym_commission'] = 0;
            }

            // Update the staff details
            $staffDetail->update([
                'name'             => $updateStaff['full_name'],
                'gender'           => $updateStaff['gender'],
                'blood_group'      => $updateStaff['blood_group'],
                'employee_id'      => $updateStaff['employee_id'],
                'email'            => $updateStaff['email'],
                'number'           => $updateStaff['phone_number'],
                'designation_id'   => $updateStaff['designation'],
                'joining_date'     => $updateStaff['joining_date'],
                'address'          => $updateStaff['address'],
                'salary'           => $updateStaff['salary'],
                'experience'       => $updateStaff['experience'],
                'dob'              => $updateStaff['dob'],
                'whatsapp_no'      => $updateStaff['whatsapp_no'],
                'fees'             => $updateStaff['fees'],
                'staff_commission' => $updateStaff['staff_commission'],
                'gym_commission'   => $updateStaff['gym_commission'],
            ]);

            // Update image if provided
            if (isset($imagePath)) {
                $staffDetail->update(['image' => $imagePath]);
            }

            return $staffDetail->save();
        } catch (\Throwable $e) {
            Log::error('[GymStaff][updateStaff] Error while updating user detail: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the staff details.');
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
