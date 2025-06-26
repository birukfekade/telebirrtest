<?php

return [

    'base_url' => env('TELEBIRR_BASE_URL', 'https://developerportal.ethiotelebirr.et:38443'),
    'fabric_app_id' => env('TELEBIRR_FABRIC_APP_ID'),
    'app_secret' => env('TELEBIRR_APP_SECRET'),
    'merchant_app_id' => env('TELEBIRR_MERCHANT_APP_ID'),
    'merchant_code' => env('TELEBIRR_MERCHANT_CODE'),
    'web_base_url' => env('TELEBIRR_WEB_BASE_URL', 'https://developerportal.ethiotelebirr.et:38443/payment/web/h5/paygate?'),
    'notify_url' => env('TELEBIRR_NOTIFY_URL', 'https://yourdomain.com/telebirr/notify'),
    'redirect_url' => env('TELEBIRR_REDIRECT_URL', 'https://yourdomain.com/payment/success'),
    'private_key_path' => storage_path('app/telebirr/private.pem'),

];
