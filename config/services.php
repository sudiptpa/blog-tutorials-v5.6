<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
     */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'paypal' => [
        'username' => env('PAYPAL_USERNAME'),
        'password' => env('PAYPAL_PASSWORD'),
        'signature' => env('PAYPAL_SIGNATURE'),
        'sandbox' => env('PAYPAL_SANDBOX'),
    ],
    'securepay' => [
        'merchant_id' => env('SECUREPAY_MERCHANTID'),
        'password' => env('SECUREPAY_PASSWORD'),
        'sandbox' => env('SECUREPAY_SANDBOX', true),
    ],
    'nab' => [
        'unionpay' => [
            'merchant_id' => env('UNIONPAY_MERCHANTID'),
            'password' => env('UNIONPAY_PASSWORD'),
            'sandbox' => env('UNIONPAY_SANDBOX', true),
        ],
    ],
    'auspost' => [
        'api_key' => env('AUSPOST_API_KEY')
    ]
];
