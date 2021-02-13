<?php

namespace App\Http\Controllers;

use App\Order;
use App\UnionPay;
use Illuminate\Http\Request;

/**
 * Class UnionPayController
 * @package App\Http\Controllers
 */
class UnionPayController extends Controller
{
    /**
     * @param Request $request
     */
    public function checkout(Request $request)
    {
        $order = Order::findOrFail(mt_rand(1, 140));

        // you application logic goes here
        // the above order is just for example.

        return view('unionpay.checkout', compact('order'));
    }

    /**
     * @param $order_id
     * @param Request $request
     */
    public function payment($order_id, Request $request)
    {
        $order = Order::findOrFail($order_id);

        $gateway = with(new UnionPay);

        try {
            $response = $gateway->purchase([
                'amount' => $gateway->formatAmount($order->amount),
                'transactionId' => str_pad($order->id, 8, '0', STR_PAD_LEFT),
                'currency' => 'AUD',
                'cancelUrl' => $gateway->getCancelUrl($order),
                'returnUrl' => $gateway->getReturnUrl($order),
            ], $request);
        } catch (Exception $e) {
            $order->update(['payment_status' => Order::PAYMENT_PENDING]);

            return redirect()
                ->route('checkout.payment.unionpay.failed', [$order->id])
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
     */
    public function completed($order_id, Request $request)
    {
        $order = Order::findOrFail($order_id);

        $gateway = with(new UnionPay);

        $response = $gateway->complete([
            'amount' => $gateway->formatAmount($order->amount),
            'transactionId' => str_pad($order->id, 8, '0', STR_PAD_LEFT),
            'currency' => 'AUD',
            'cancelUrl' => $gateway->getCancelUrl($order),
            'returnUrl' => $gateway->getReturnUrl($order),
        ], $request);

        if ($response->isSuccessful()) {
            $order->update([
                'transaction_id' => $response->getTransactionReference(),
                'payment_status' => Order::PAYMENT_COMPLETED,
            ]);

            return redirect()->route('checkout.payment.unionpay')->with([
                'message' => 'Payment Successful, Thank you for your order!',
            ]);
        }

        return redirect()->back()->with([
            'message' => $response->getMessage(),
        ]);
    }

    /**
     * @param $order_id
     * @param Request $request
     */
    public function failed($order_id, Request $request)
    {
        $order = Order::findOrFail($order_id);

        return view('checkout.payment', compact('order'));
    }

    /**
     * @param $order_id
     */
    public function refund($order_id)
    {
        $order = Order::findOrFail($order_id);

        $gateway = with(new UnionPay);

        try {
            $response = $gateway->refund([
                'transactionReference' => $order->transaction_id,
                'amount' => $order->amount,
                'transactionId' => str_pad($order->id, 8, '0', STR_PAD_LEFT),
            ]);
        } catch (Exception $e) {
            // error response
        }

        if ($response->isSuccessful()) {
            // success
        }

        // failed

        if ($response->isRedirect()) {
            $response->redirect();
        }

        return redirect()->back()->with([
            'message' => "We're unable to process your payment at the moment, please try again!",
        ]);
    }
}
