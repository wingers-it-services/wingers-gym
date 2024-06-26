<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DesignationController extends Controller
{
    protected $designation;

    public function __construct(Designation $designation)
    {
        $this->designation = $designation;
    }

    public function viewDesignation()
    {
        $designations = $this->designation->all();
        return view('admin.designation', compact('designations'));
    }

    public function addDesignation(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'designation_name' => 'required'
            ]);
            $this->designation->addAdminDesignation($validatedData);

            return redirect()->route('viewDesignation')->with('success', 'Designation added successfully!');
        } catch (\Exception $e) {
            Log::error('[DesignationController][addDesignation]Error adding : ' . 'Request=' . $e->getMessage());
            return back()->with('status', 'error')->with('message', 'Designation Not Added ');
        }
    }

    public function deleteDesignation($uuid)
    {
        $designation = $this->designation->where('uuid', $uuid)->firstOrFail();
        $designation->delete();
        return redirect()->route('viewDesignation')->with('success', 'Designation deleted successfully!');
    }
}
