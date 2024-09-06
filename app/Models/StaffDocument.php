<?php

namespace App\Models;

use App\Enums\GymStaffDocumentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class StaffDocument extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'staff_id',
        'gym_id',
        'document_name',
        'file',
        'status'
    ];

    public function gymStaff()
    {
        return $this->belongsTo(GymStaff::class, 'staff_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function addDocuments(array $staffDocumentDetails, $file)
    {
        $gym = Auth::guard('gym')->user();
     
        $this->create([
            'gym_id'         => $gym->id,
            'staff_id'       => $staffDocumentDetails['staff_id'],
            'document_name'  => $staffDocumentDetails['document_name'],
            'file'           => $file,
            'status'         => GymStaffDocumentStatusEnum::NOTVERIFY,
        ]);

    }

    public function createOrUpdateDocument(array $staffDocumentDetails)
    {
        $gym = Auth::guard('gym')->user();
        $existingDocument = $this->where('staff_id', $staffDocumentDetails['staff_id'])->first();

        $aadhaarCardPath = $existingDocument->aadhaar_card ?? null;
        $panCardPath = $existingDocument->pan_card ?? null;
        $cancelChequePath = $existingDocument->cancel_cheque ?? null;
        $otherDocumentPath = $existingDocument->other ?? null;

        if ($staffDocumentDetails['aadhaar_card']) {
            $aadhaarCard = $staffDocumentDetails['aadhaar_card'];
            if ($aadhaarCardPath) {
                unlink(public_path($aadhaarCardPath));
            }
            $filename = time() . '_' . $aadhaarCard->getClientOriginalName();
            $aadhaarCardPath = 'staff_adharcard/' . $filename;
            $aadhaarCard->move(public_path('staff_adharcard/'), $filename);
        }

        if ($staffDocumentDetails['pan_card']) {
            $panCard=$staffDocumentDetails['pan_card'];
            if ($panCardPath) {
                unlink(public_path($panCardPath));
            }
            $filename = time() . '_' . $panCard->getClientOriginalName();
            $panCardPath = 'staff_pan_card/' . $filename;
            $panCard->move(public_path('staff_pan_card/'), $filename);
        }

        if ($staffDocumentDetails['cancel_cheque']) {
            $cancelCheque=$staffDocumentDetails['cancel_cheque'];
            if ($cancelChequePath) {
                unlink(public_path($cancelChequePath));
            }
            $filename = time() . '_' . $cancelCheque->getClientOriginalName();
            $cancelChequePath = 'staff_cancel_cheque/' . $filename;
            $cancelCheque->move(public_path('staff_cancel_cheque/'), $filename);
        }

        if ($staffDocumentDetails['other']) {
            $otherDocument=$staffDocumentDetails['other'];
            if ($otherDocumentPath) {
                unlink(public_path($otherDocumentPath));
            }
            $filename = time() . '_' . $otherDocument->getClientOriginalName();
            $otherDocumentPath = 'staff_other_documents/' . $filename;
            $otherDocument->move(public_path('staff_other_documents/'), $filename);
        }

        return $this->updateOrCreate(
            ['staff_id' => $staffDocumentDetails['staff_id']],
            [
                'gym_id'        => $gym->id,
                'aadhaar_card'  => $aadhaarCardPath,
                'pan_card'      => $panCardPath,
                'cancel_cheque' => $cancelChequePath,
                'other'         => $otherDocumentPath
            ]
        );
    }
}
