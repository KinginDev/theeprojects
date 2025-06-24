<?php

return [
    'processing_fee' => 2.5, // Default Monnify fee percentage

    "contract_code"  => env('MONNIFY_CONTRACT_CODE', 'your_contract_code_here'),
    "api_key"        => env('MONNIFY_API_KEY', 'your_api_key_here'),
    "secret_key"     => env('MONNIFY_SECRET_KEY', 'your_secret_key_here'),
];
