<?php

namespace App\Http\Controllers;

use App\Order;
use App\SecurePay;
use Exception;
use Illuminate\Http\Request;

/**
 * Class PaymentController
 * @package App\Http\Controllers
 */
class PaymentController extends Controller
{
    /**
     * @param Request $request
     */
    public function checkout(Request $request)
    {
        $order = Order::findOrFail(mt_rand(1, 140));

        // you application logic goes here
        // the above order is just for example.

        return view('checkout.payment', compact('order'));
    }

    /**
     * @param $order_id
     * @param Request $request
     */
    public function payment($order_id, Request $request)
    {
        $order = Order::findOrFail($order_id);

        $gateway = new SecurePay;

        try {
            $response = $gateway->purchase([
                'amount' => $gateway->formatAmount($order->amount),
                'transactionId' => $order->id,
                'currency' => 'USD',
                'cancelUrl' => $gateway->getCancelUrl($order),
                'returnUrl' => $gateway->getReturnUrl($order),
            ], $request);
        } catch (Exception $e) {
            $order->update(['payment_status' => Order::PAYMENT_PENDING]);

            return redirect()
                ->route('checkout.payment.failed', [$order->id])
                ->with('message', sprintf("Your payment failed with error: %s", $e->getMessage()));
        }

        if ($response->isRedirect()) {
            $response->redirect();
        }

        return redirect()->back()->with([
            'message' => "We're unable to process your payment at the moment, please try again !",
        ]);
    }

    /**
     * @param $order_id
     * @param Request $request
     * @return mixed
     */
    public function completed($order_id, Request $request)
    {
        $order = Order::findOrFail($order_id);

        $gateway = new SecurePay;

        $response = $gateway->complete([
            'amount' => $gateway->formatAmount($order->amount),
            'transactionId' => $order->id,
            'currency' => 'USD',
            'cancelUrl' => $gateway->getCancelUrl($order),
            'returnUrl' => $gateway->getReturnUrl($order),
        ], $request);

        if ($response->isSuccessful()) {
            $order->update([
                'transaction_id' => $response->getTransactionReference(),
                'payment_status' => Order::PAYMENT_COMPLETED,
            ]);

            return redirect()->route('checkout.payment')->with([
                'message' => 'Payment Successful, Thank you for your order !',
            ]);
        }

        return redirect()->back()->with([
            'message' => $response->getMessage(),
        ]);
    }

    /**
     * @param $order_id
     * @param Request $request
     * @return mixed
     */
    public function failed($order_id, Request $request)
    {
        $order = Order::findOrFail($order_id);

        return view('checkout.payment', compact('order'));
    }
}
