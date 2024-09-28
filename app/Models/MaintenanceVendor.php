<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class MaintenanceVendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gym_id',
        'phone_no',
        'occupation',
        'address',
        'image'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function vendorMaintenance(array $vendorMaintenanceDetails)
    {
        
        $gym = Auth::guard('gym')->user();

        if (isset($vendorMaintenanceDetails['image']) && $vendorMaintenanceDetails['image']->isValid()) {
            $image = $vendorMaintenanceDetails['image'];

            $imageDirectory = 'vendor_maintenance_images/';

            // Generate a unique filename using the original file extension
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Move the image to the desired directory
            $image->move(public_path($imageDirectory), $imageName);

            // Store the image path
            $imagePath = $imageDirectory . $imageName;
        }

        $this->create([
            'name'         => $vendorMaintenanceDetails['name'],
            'image'        => $imagePath ?? null,
            'address'      => $vendorMaintenanceDetails['address'],
            'occupation'   => $vendorMaintenanceDetails['occupation'],
            'gym_id'       => $gym->id,
            'phone_no'     => $vendorMaintenanceDetails['phone_no']
        ]);
    }

    public function updateVendor(array $updateVendor, $imagePath)
    {

        $vendorDetails = $this->where('uuid', $updateVendor['uuid'])->first();

        if (!$vendorDetails) {
            return redirect()->back()->with('error', 'Vendor not found');
        }

        try {

            $vendorDetails->update([
                'name'             => $updateVendor['name'],
                'phone_no'           => $updateVendor['phone_no'],
                'occupation'      => $updateVendor['occupation'],
                'address'      => $updateVendor['address']
            ]);

            // Update image if provided
            if (isset($imagePath)) {
                $vendorDetails->update(['image' => $imagePath]);
            }

            return $vendorDetails->save();
        } catch (\Throwable $e) {
            Log::error('[MaintenanceVendor][updateVendor] Error while updating vendor detail: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the vendor details.');
        }
    }
}
