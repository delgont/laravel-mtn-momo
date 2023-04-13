<?php

return [
    'base_url' => env('MOMO_BASE_URL', 'https://sandbox.momodeveloper.mtn.com/v1_0/'),
    'target-environment' => env('MOMO_TARGET_ENVIRONMENT', 'sandbox'),

    'collection_subscription_key' => env('MOMO_COLLECTION_SUBSCRIPTION_KEY', 'f822e9603f584bbfab0eab414daf67a7'),
    'disbursement_subscription_key' => env('MOMO_DISBURSEMENT_SUBSCRIPTION_KEY', ''),
    
    'api_key' => env('MOMO_API_KEY', ''),
    'api_user_id' => env('MOMO_API_USER_ID', ''),
    
];