<?php

namespace App\Http\Controllers;

use App\Models\UserInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GymInquiryController extends Controller
{
    public function viewInquiry(Request $request)
    {
        // $uuid = $request->input('uuid');
        $gym = Auth::guard('gym')->user();
        $inquiries = UserInquiry::where('gym_id',$gym->id)->get();

        return view('GymOwner.enquiry-read', compact('inquiries'));
    }

    public function getDetails(Request $request)
    {
        $inquiry = UserInquiry::find($request->id);
        return response()->json([
            'name' => $inquiry->user->firstname,
            'date' => $inquiry->created_at->format('d M Y'),
            'message' => $inquiry->description,
            'image' => asset($inquiry->user->image) 
        ]);
    }
}
