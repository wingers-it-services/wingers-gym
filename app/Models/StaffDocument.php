<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class StaffDocument extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'staff_id',
        'aadhaar_card',
        'pan_card',
        'cancel_cheque',
        'other'
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

    public function createOrUpdateDocument(array $staffDocumentDetails)
    {
        // Retrieve the existing document record
        $existingDocument = $this->where('staff_id', $staffDocumentDetails['staff_id'])->first();

        $aadhaarCardPath = $existingDocument->aadhaar_card ?? null;
        $panCardPath = $existingDocument->pan_card ?? null;
        $cancelChequePath = $existingDocument->cancel_cheque ?? null;
        $otherDocumentPath = $existingDocument->other ?? null;

        // Handle Aadhaar Card upload
        if ($staffDocumentDetails['aadhaar_card']) {
            $aadhaarCard = $staffDocumentDetails['aadhaar_card'];
            if ($aadhaarCardPath) {
                // Delete the old file
                unlink(public_path($aadhaarCardPath));
            }
            $filename = time() . '_' . $aadhaarCard->getClientOriginalName();
            $aadhaarCardPath = 'staff_adharcard/' . $filename;
            $aadhaarCard->move(public_path('staff_adharcard/'), $filename);
        }

        // Handle PAN Card upload
        if ($staffDocumentDetails['pan_card']) {
            $panCard=$staffDocumentDetails['pan_card'];
            if ($panCardPath) {
                // Delete the old file
                unlink(public_path($panCardPath));
            }
            $filename = time() . '_' . $panCard->getClientOriginalName();
            $panCardPath = 'staff_pan_card/' . $filename;
            $panCard->move(public_path('staff_pan_card/'), $filename);
        }

        // Handle Cancel Cheque upload
        if ($staffDocumentDetails['cancel_cheque']) {
            $cancelCheque=$staffDocumentDetails['cancel_cheque'];
            if ($cancelChequePath) {
                // Delete the old file
                unlink(public_path($cancelChequePath));
            }
            $filename = time() . '_' . $cancelCheque->getClientOriginalName();
            $cancelChequePath = 'staff_cancel_cheque/' . $filename;
            $cancelCheque->move(public_path('staff_cancel_cheque/'), $filename);
        }

        // Handle Other Document upload
        if ($staffDocumentDetails['other']) {
            $otherDocument=$staffDocumentDetails['other'];
            if ($otherDocumentPath) {
                // Delete the old file
                unlink(public_path($otherDocumentPath));
            }
            $filename = time() . '_' . $otherDocument->getClientOriginalName();
            $otherDocumentPath = 'staff_other_documents/' . $filename;
            $otherDocument->move(public_path('staff_other_documents/'), $filename);
        }

        // Update or create the StaffDocument record
        return $this->updateOrCreate(
            ['staff_id' => $staffDocumentDetails['staff_id']],
            [
                'aadhaar_card'  => $aadhaarCardPath,
                'pan_card'      => $panCardPath,
                'cancel_cheque' => $cancelChequePath,
                'other'         => $otherDocumentPath
            ]
        );
    }
}
