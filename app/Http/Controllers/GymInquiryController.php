<?php

namespace App\Http\Controllers;

use App\Models\UserInquiry;
use Illuminate\Http\Request;

class GymInquiryController extends Controller
{
    public function viewInquiry(Request $request)
    {
        // $uuid = $request->input('uuid');
        $inquiries = UserInquiry::get();

        return view('GymOwner.enquiry-read', compact('inquiries'));
    }
}
