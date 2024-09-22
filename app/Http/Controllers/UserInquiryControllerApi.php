<?php

namespace App\Http\Controllers;

use App\Models\UserInquiry;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserInquiryControllerApi extends Controller
{

    protected $userInquiry;

    public function __construct(
        UserInquiry $userInquiry
    ) {
        $this->userInquiry = $userInquiry;
    }

    public function sendInquiry(Request $request)
    {
        try {
            $request->validate([
                'gym_id'      => 'required|exists:gyms,id',
                'reason'      => 'required',
                'description' => 'required',
                'status'      => 'required'
            ]);

            $request = $request->all();

            $inquiries = $this->userInquiry->sendInquiry($request);

            return response()->json([
                'status'    => 200,
                'inquiries' => $inquiries,
                'message'   => 'Inquiry details added successfully.'
            ], 200);

        } catch (Exception $e) {
            Log::error('[UserInquiryControllerApi][sendInquiry]Error adding inquiry details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error adding inquiry details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function fetchInquiry(Request $request)
    {
        try {

            $request->validate([
                'gym_id' => 'required|exists:gyms,id'
            ]);

            $inquiries = $this->userInquiry
                ->where('user_id', auth()->user()->id)
                ->where('gym_id', $request->gym_id)
                ->get();

            if ($inquiries->isEmpty()) {
                return response()->json([
                    'status'    => 422,
                    'inquiries' => $inquiries,
                    'message'   => 'There is no inquiries'
                ], 200);
            }

            return response()->json([
                'status'    => 200,
                'inquiries' => $inquiries,
                'message'   => 'Inquiry Fetch Successfully'
            ], 200);
            
        } catch (Exception $e) {
            Log::error('[UserInquiryControllerApi][fetchInquiry]Error fetching inquiry details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching inquiry details: ' . $e->getMessage()
            ], 500);
        }
    }
}
