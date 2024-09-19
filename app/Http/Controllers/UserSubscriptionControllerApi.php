<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusCodeEnum;
use App\Models\GymSubscription;
use App\Models\UserSubscriptionHistory;
use App\Models\UserSubscriptionPayment;
use App\Traits\errorResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserSubscriptionControllerApi extends Controller
{
    use errorResponseTrait;
    protected $userSubscriptionHistory;
    protected $userSubscriptionPayment;
    protected $gymSubscription;

    public function __construct(
        UserSubscriptionHistory $userSubscriptionHistory,
        UserSubscriptionPayment $userSubscriptionPayment,
        GymSubscription $gymSubscription
    ) {
        $this->userSubscriptionHistory = $userSubscriptionHistory;
        $this->userSubscriptionPayment = $userSubscriptionPayment;
        $this->gymSubscription = $gymSubscription;
    }

    /**
     * The function fetches gym subscriptions and returns a JSON response with the subscription details
     * or an error message if there is an issue.
     * 
     * @return The `fetchSubscription` function returns a JSON response with status, subscriptions data,
     * and a message.
     */
    public function fetchSubscription(Request $request)
    {
        try {
            $request->validate([
                'gym_id' => 'required',
            ]);
            $subscriptions = $this->gymSubscription->where('gym_id', $request->gym_id)->get();

            if ($subscriptions->isEmpty()) {
                return response()->json([
                    'status'        => 422,
                    'subscriptions' => $subscriptions,
                    'message'       => 'There is no subscriptions'
                ], 422);
            }

            $activeSubscription = $this->userSubscriptionHistory
                ->where('gym_id', $request->gym_id)
                ->where('user_id', auth()->user()->id)
                ->where('status', 1)
                ->exists();

            return response()->json([
                'status'                => 200,
                'subscriptions'         => $subscriptions,
                'alredy_subscription'   => $activeSubscription ? 1 : 0,
                'message'               => 'Subscriptions Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserSubscriptionControllerApi][fetchSubscription]Error fetching subscriptions details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching subscriptions details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * The function fetches a user's subscription history and returns it in a JSON response, handling
     * authentication, empty subscriptions, and error cases.
     * 
     * @return The `fetchSubscriptionHistry` function returns a JSON response with the status,
     * subscriptions data, and a message based on the logic within the function.
     */
    public function fetchSubscriptionHistry(Request $request)
    {
        try {
            $request->validate([
                'gym_id' => 'required',
            ]);
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'status'  => 401,
                    'message' => 'User not authenticated',
                ], 401);
            }

            $subscriptions = $this->userSubscriptionHistory->with(['subscription' => function ($query) {
                $query->withTrashed();
            }])
                ->where('user_id', $user->id)
                ->where('gym_id', $request->gym_id)
                ->get();

            if ($subscriptions->isEmpty()) {
                return response()->json([
                    'status'        => 422,
                    'subscriptions' => $subscriptions,
                    'message'       => 'There is no subscriptions'
                ], 422);
            }

            return response()->json([
                'status'         => 200,
                'subscriptions'  => $subscriptions,
                'message'        => 'User subscriptions Fetch Successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('[UserSubscriptionControllerApi][fetchSubscriptionHistry]Error fetching subscriptions details: ' . $e->getMessage());
            return response()->json([
                'status'  => 500,
                'message' => 'Error fetching subscriptions details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function initialisePaymentWithTest(array $data)
    {
        $lastOrderId = UserSubscriptionPayment::latest('id')->value('id');
        $newOrderId = ($lastOrderId == null) ? 'WITS1' :  'W1' . ($lastOrderId + 1);
        $amount = $data['totalprice']/100;

        // $paymentData = [
        //     'merchantId'            =>  'PGTESTPAYUAT',
        //     'merchantTransactionId' =>  $newOrderId,
        //     'merchantUserId'        =>  'MUID123',
        //     'amount'                =>  $amount,
        //     'redirectUrl'           => route('response'),
        //     'redirectMode'          => 'POST',
        //     'callbackUrl'           => route('response'),
        //     'mobileNumber'          => $data['mobile'],
        //     'paymentInstrument'     =>
        //     [
        //         'type' => 'PAY_PAGE',
        //     ],
        // ];

        // $encode = base64_encode(json_encode($paymentData));


        $this->userSubscriptionPayment->newOrder($data);
    }

    // public function purchaseSubscription(Request $request)
    // {

    //     try {
    //         $request->validate([
    //             'gym_id'          => 'required|exists:gyms,id',
    //             'subscription_id' => 'required',
    //             'amount'          => 'required',
    //         ]);

    //         $order = $this->userSubscriptionPayment->newOrder($request->all);
    //         return response()->json([
    //             'status'  => 200,
    //             'order'   => $order,
    //             'message' => 'Error purchasing subscriptions details: '
    //         ], 200);
    //     } catch (Throwable $e) {
    //         Log::error('[UserSubscriptionControllerApi][purchaseSubscription]Error purchasing subscriptions: ' . $e->getMessage());
    //         return response()->json([
    //             'status'  => 500,
    //             'message' => 'Error purchasing subscriptions details: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function phonePeCallback(Request $request)
    {
        try {
            Log::info('PhonePe Callback received: ', $request->all());

            // Decode Base64 response
            $jsonResponse = base64_decode($request->input('response'));

            // Decode JSON response into an associative array
            $decodedResponse = json_decode($jsonResponse, true);

            // Check if JSON decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('JSON decode error: ' . json_last_error_msg());
            }

            // Ensure 'data' field exists in the response
            if (!isset($decodedResponse['data'])) {
                throw new \Exception('Missing data field in response');
            }

            $responseData = $decodedResponse['data'];

            $orderData = [
                'subtotal'            => $responseData['amount'] ?? 0,
                'amount'              => $responseData['amount'] ?? 0,
                'response'            => $jsonResponse,
                'response_code'       => $decodedResponse['code'] ?? null,
                'merchantId'          => $responseData['merchantTransactionId'] ?? null,
            ];

            // Log extracted order data
            Log::info('Extracted Order Data: ', $orderData);

            // Save the order data to the database
            $this->userSubscriptionPayment->newOrder($orderData);

            return response()->json([
                'status' => 'success',
                'message' => 'Callback processed successfully.'
            ], 200);
        } catch (\Exception $e) {
            // Log any exception that occurs
            Log::error('PhonePe Callback Error: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing the callback. ' . $e->getMessage()
            ], 500);
        }
    }

    public function response(Request $request)
    {
        try {
            $request->validate([
                'gym_id'                => 'required|exists:gyms,id',
                'subscription_id'       => 'required|exists:gym_subscriptions,id',
                'merchantTransactionId' => 'required',
                'start_immediately'     => 'required'
            ]);

            $order = UserSubscriptionPayment::where('merchantId',  $request->merchantTransactionId)->first();
            // $project = $this->project->find($order->project_id);
            if (!$order) {
                return response()->json([
                    'success' => 404,
                    'message' => 'No order available for this merchant transection ID',
                ], 404);
            }

            $lastOrderId = UserSubscriptionPayment::latest('id')->value('id');
            $orderId = $request->gym_id . 'WITSGYM' . ($lastOrderId + 1);

            if (!isset($order)) {
                Log::error('[UserSubscriptionControllerApi][response] Invalid order ', [
                    'input' => $request,
                    'Error' => 'This order is not exist in our database.'
                ]);
                return 'Payment failed';
            }
            $user = auth()->user();
            if ($order->response_code == PaymentStatusCodeEnum::PAYMENT_SUCCESS) {
                $orderDetail = $order->update([
                    'orderId'          => $orderId,
                    'userId'           => $user->id,
                    'name'             => $user->firstname . $user->lastname,
                    'email'            => $user->email,
                    'mobile'           => $user->phone_no,
                    'gym_id'           => $request->gym_id,
                    'subscription_id'  => $request->subscription_id,
                ]);

                $subscriptionData = [
                    'gym_id'                  => $request->gym_id,
                    'subscription_id'         => $request->subscription_id,
                    'original_transaction_id' => $request->merchantTransactionId,
                    'start_immediately'       => $request->start_immediately,
                    'status'                  => $request->start_immediately == 1 ? 1 : 0, // Set status based on start_immediately
                    'amount'                  => $order->amount,
                    'coupon_id'               => $order->coupon_id ?? 0
                ];
                

                // Call buySubscription to create the user's subscription
                $subscription = $this->userSubscriptionHistory->buySubscription($subscriptionData);

                if (!$subscription) {
                    return response()->json([
                        'success' => 500,
                        'message' => 'Failed to create subscription',
                    ], 500);
                }
            } else if ($order->response_code == PaymentStatusCodeEnum::PAYMENT_ERROR) {
                $order->update([
                    'orderId'          => $orderId,
                    'userId'           => $user->id,
                    'name'             => $user->firstname . $user->lastname,
                    'email'            => $user->email,
                    'mobile'           => $user->phone_no,
                    'gym_id'           => $request->gym_id,
                    'subscription_id'  => $request->subscription_id,
                ]);
                Log::error('[UserSubscriptionControllerApi][response] Payment failed ' . 'input' . $request);
                // return redirect()->route('project-single', [$project->uuid])->with('status', 'error')->with('message', 'Payment Failed.');
            } else {
                $order->update([
                    'orderId'          => $orderId,
                    'userId'           => $user->id,
                    'name'             => $user->firstname . $user->lastname,
                    'email'            => $user->email,
                    'mobile'           => $user->phone_no,
                    'gym_id'           => $request->gym_id,
                    'subscription_id'  => $request->subscription_id,
                ]);

                Log::error('[UserSubscriptionControllerApi][response] Payment Pending ' . 'input' . $request);
                // return redirect()->route('project-single', [$project->uuid])->with('status', 'error')->with('message', 'Payment Pending.');
            }
            return response()->json([
                'status'  => 200,
                'order'   => $order,
                'message' => 'Order done successfully'
            ], 200);
            // return redirect()->route('project-single', [$project->uuid])->with('status', 'success' . $order->id)->with('message', 'Project downloaded successfully.');
        } catch (\Throwable $e) {
            Log::error('[UserSubscriptionControllerApi][response]Payment not done.' . 'Request=' . $request . 'Throwable=' . $e->getMessage());
            // return redirect()->route('project-single', [$project->uuid])->with('status', 'error')->with('message', 'Payment not done.');
            return response()->json([
                'status'  => 500,
                'message' => 'Order done successfully ' . $e->getMessage()
            ], 500);
        }
    }
}
