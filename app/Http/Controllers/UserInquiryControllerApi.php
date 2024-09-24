<?php

namespace App\Http\Controllers;

use App\Models\InquiryReason;
use App\Models\UserInquiry;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserInquiryControllerApi extends Controller
{

    protected $userInquiry;
    protected $inquiryReason;

    public function __construct(
        UserInquiry $userInquiry,
        InquiryReason $inquiryReason
    ) {
        $this->userInquiry = $userInquiry;
        $this->inquiryReason = $inquiryReason;
    }

    public function sendInquiry(Request $request)
    {
        try {
            $request->validate([
                'gym_id'      => 'required|exists:gyms,id',
                'reason'      => 'required',
                'description' => 'required'
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

    public function fetchInquiryReason(Request $request)
    {
        try {

            $inquiryReasons = $this->inquiryReason->orderBy('id', 'desc')->get();

            if ($inquiryReasons->isEmpty()) {
                return response()->json([
                    'status'         => 422,
                    'inquiryReasons' => $inquiryReasons,
                    'message'        => 'There is no inquiries reason'
                ], 200);
            }

            return response()->json([
                'status'         => 200,
                'inquiryReasons' => $inquiryReasons,
                'message'        => 'Inquiry reasons Fetch Successfully'
            ], 200);
            
        } catch (Exception $e) {
            Log::error('[UserInquiryControllerApi][fetchInquiryReason]Error fetching inquiry reasons: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching inquiry reasons: ' . $e->getMessage()
            ], 500);
        }
    }
}
