<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusCodeEnum;
use App\Models\User;
use App\Models\UserSubscriptionPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserSubscriptionPurchaseControllerApi extends Controller
{
    protected $payment;
    protected $user;

    public function __construct(
        UserSubscriptionPayment $payment,
        User $user,
    ) {
        $this->payment = $payment;
        $this->user = $user;
    }
    
    public function response(Request $request)
    {
        try {
            $responseData = $request->all();
            $order = $this->payment->where('orderId',  $responseData['transactionId'])->first();

            if (!isset($order)) {
                Log::error('[CheckoutController][response] Invalid order ', [
                    'input' => $request,
                    'Error' => 'This order is not exist in our database.'
                ]);
                return 'Payment failed';
            }

            if ($responseData['code'] == PaymentStatusCodeEnum::PAYMENT_SUCCESS) {
                $invoiceView = view('user.invoice-order-success', [
                    'order'               => $order,
                    'providerReferenceId' => $responseData['providerReferenceId']
                ])->render();
                $order->update([
                    'response_code'       => $responseData['code'],
                    'merchantId'          => $responseData['merchantId'],
                    'providerReferenceId' => $responseData['providerReferenceId'],
                    'responseData'        => json_encode($responseData),
                    'invoice'             => $invoiceView,
                ]);
                

                // return $invoiceView;
                return redirect()->back()->with('status', 'success')->with('message', 'Payment Done now login.');
            } else if ($responseData['code'] == PaymentStatusCodeEnum::PAYMENT_ERROR) {
                $invoiceView = view('emailTemplate.invoice-order-failed ', [
                    'order'               => $order,
                    'providerReferenceId' => $responseData['providerReferenceId']
                ])->render();

                $order->update([
                    'response_code'       => $responseData['code'],
                    'merchantId'          => $responseData['merchantId'],
                    'providerReferenceId' => $responseData['providerReferenceId'],
                    'responseData'        => json_encode($responseData),
                    'invoice'             => $invoiceView,
                ]);
                return $invoiceView;
                Log::error('[CheckoutController][response] Payment failed ' . 'input' . $request);
                return redirect()->back()->with('status', 'error')->with('message', 'Payment Failed.');
            } else {
                $invoiceView = view('emailTemplate.invoice-order-pending', ['order' => $order])->render();
                $order->update([
                    'response_code'  => $responseData['code'],
                    'merchantId'     => $responseData['merchantId'],
                    'responseData'   => json_encode($responseData),
                    'invoice'        => $invoiceView,
                ]);
                return $invoiceView;
                Log::error('[CheckoutController][response] Payment Pending ' . 'input' . $request . 'responseData' . json_encode($responseData));
                return redirect()->back()->with('status', 'error')->with('message', 'Payment Pending.');
            }
            return redirect()->back()->with('status', 'success' . $order->id)->with('message', 'Project downloaded successfully.');
        } catch (\Throwable $e) {
            Log::error('Payment not done.' . 'Request=' . $request . 'Throwable=' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Payment not done.');
        }
    }
}
