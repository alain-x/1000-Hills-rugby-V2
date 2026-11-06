<?php

return [
    'enabled' => (bool) env('PESAPAL_ENABLED', false),

    'environment' => env('PESAPAL_ENV', 'sandbox'),

    'consumer_key' => env('PESAPAL_CONSUMER_KEY'),

    'consumer_secret' => env('PESAPAL_CONSUMER_SECRET'),

    'ipn_id' => env('PESAPAL_IPN_ID'),

    'currency' => env('PESAPAL_CURRENCY', 'RWF'),

    'max_donation_rwf' => (float) env('DONATION_MAX_RWF', 2000000),

    'fx' => [
        'USD' => (float) env('FX_USD_RWF', 1300),
        'EUR' => (float) env('FX_EUR_RWF', 1400),
        'GBP' => (float) env('FX_GBP_RWF', 1600),
    ],

    'base_url' => env('PESAPAL_ENV', 'sandbox') === 'production'
        ? 'https://pay.pesapal.com/v3'
        : 'https://cybqa.pesapal.com/pesapalv3',
];
