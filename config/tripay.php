<?php

return [
    'callback_token' => env('TRIPAY_CALLBACK_TOKEN'),
    'api_key' => env('TRIPAY_API_KEY'),
    'private_key' => env('TRIPAY_PRIVATE_KEY'),
    'api_url' => env('TRIPAY_API_URL'),
    'merchant_code' => env(key: 'TRIPAY_MERCHANT_CODE')
];
