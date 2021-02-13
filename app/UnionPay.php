<?php

namespace App;

use Exception;
use Omnipay\Omnipay;

/**
 * Class UnionPay
 * @package App
 */
class UnionPay
{
    /**
     * @return \UnionPayGateway
     */
    public function gateway()
    {
        $gateway = Omnipay::create('NABTransact_UnionPay');

        $gateway->setMerchantId(config('services.nab.unionpay.merchant_id'));
        $gateway->setTransactionPassword(config('services.nab.unionpay.password'));
        $gateway->setTestMode(config('services.nab.unionpay.sandbox'));

        return $gateway;
    }

    /**
     * @param array $parameters
     * @return $response
     */
    public function purchase(array $parameters)
    {
        try {
            $response = $this->gateway()
                ->purchase($parameters)
                ->send();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $response;
    }

    /**
     * @param array $parameters
     * @return $response
     */
    public function complete(array $parameters)
    {
        $response = $this->gateway()
            ->completePurchase($parameters)
            ->send();

        return $response;
    }

    /**
     * @param $amount
     */
    public function formatAmount($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    /**
     * @param $order
     */
    public function getCancelUrl($order)
    {
        return route('checkout.payment.unionpay.failed', $order->id);
    }

    /**
     * @param $order
     */
    public function getReturnUrl($order)
    {
        return route('checkout.payment.unionpay.completed', $order->id);
    }
}
