<?php

namespace App;

use Exception;
use Illuminate\Http\Request;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Omnipay;

/**
 * Class SecurePay
 * @package App
 */
class SecurePay
{
    /**
     * @return mixed
     */
    public function gateway()
    {
        $gateway = Omnipay::create('SecurePay_DirectPost');

        $gateway->setMerchantId(config('services.securepay.merchant_id'));
        $gateway->setTransactionPassword(config('services.securepay.password'));
        $gateway->setTestMode(config('services.securepay.sandbox'));

        return $gateway;
    }

    /**
     * @param array $parameters
     * @param Request $request
     */
    public function card(array $parameters, Request $request)
    {
        return [
            'card' => new CreditCard([
                'firstName' => $request->get('first_name'),
                'lastName' => $request->get('last_name'),
                'number' => $request->get('card_number'),
                'expiryMonth' => $request->get('expiry_month'),
                'expiryYear' => $request->get('expiry_year'),
                'cvv' => $request->get('cvc'),
            ]),
        ];
    }

    /**
     * @param array $parameters
     * @param Request $request
     * @return mixed
     */
    public function purchase(array $parameters, Request $request)
    {
        $parameters = array_merge($parameters, $this->card($parameters, $request));

        try {
            $response = $this->gateway()
                ->purchase($parameters)
                ->send();

        } catch (InvalidCreditCardException $e) {
            throw new Exception($e->getMessage());
        }

        return $response;
    }

    /**
     * @param array $parameters
     * @param Request $request
     * @return mixed
     */
    public function complete(array $parameters, Request $request)
    {
        $parameters = array_merge($parameters, $this->card($parameters, $request));

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
        return route('checkout.payment.failed', $order->id);
    }

    /**
     * @param $order
     */
    public function getReturnUrl($order)
    {
        return route('checkout.payment.completed', $order->id);
    }
}
