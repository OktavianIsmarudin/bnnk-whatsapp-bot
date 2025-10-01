<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Business API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for WhatsApp Business API integration
    |
    */

    'verify_token' => env('WHATSAPP_VERIFY_TOKEN'),
    'access_token' => env('WHATSAPP_ACCESS_TOKEN'),
    'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
    'app_id' => env('WHATSAPP_APP_ID'),
    'app_secret' => env('WHATSAPP_APP_SECRET'),
    
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Graph API Base URL
    |--------------------------------------------------------------------------
    */
    
    'graph_api_url' => 'https://graph.facebook.com/v18.0',
    
    /*
    |--------------------------------------------------------------------------
    | Bot Configuration
    |--------------------------------------------------------------------------
    */
    
    'bot' => [
        'name' => 'Bot BNNK Surabaya',
        'welcome_message' => "Halo! 👋 Saya Bot BNNK Surabaya.\n\nSaya siap membantu Anda dengan informasi layanan BNNK Surabaya.\n\nKetik *menu* untuk melihat layanan yang tersedia.",
        'default_response' => "Maaf, saya tidak memahami pesan Anda. Ketik *menu* untuk melihat layanan yang tersedia, atau ketik *bantuan* untuk panduan penggunaan bot.",
        'session_timeout' => 1800, // 30 minutes in seconds
    ],
    
    /*
    |--------------------------------------------------------------------------
    | BNNK Information
    |--------------------------------------------------------------------------
    */
    
    'bnnk' => [
        'name' => env('BNNK_NAME', 'BNNK Surabaya'),
        'address' => env('BNNK_ADDRESS', 'Jl. Raya Gubeng No. 6, Gubeng, Surabaya'),
        'phone' => env('BNNK_PHONE', '(031) 8433-456'),
        'email' => env('BNNK_EMAIL', 'bnnksby@bnn.go.id'),
        'website' => env('BNNK_WEBSITE', 'https://surabaya.bnn.go.id'),
        'office_hours' => 'Senin - Jumat: 08:00 - 16:00 WIB',
    ],
];
