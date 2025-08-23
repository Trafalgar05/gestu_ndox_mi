<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration du service SMS
    |--------------------------------------------------------------------------
    |
    | Cette configuration est utilisée pour l'envoi de SMS de confirmation
    | aux utilisateurs après la création d'un signalement.
    |
    */

    'api_key' => env('SMS_API_KEY'),
    'api_secret' => env('SMS_API_SECRET'),
    'from' => env('SMS_FROM_NUMBER', 'GestuNdoxMi'),
    
    /*
    |--------------------------------------------------------------------------
    | Service SMS par défaut
    |--------------------------------------------------------------------------
    |
    | Le service SMS par défaut à utiliser. Les options disponibles sont:
    | 'log', 'twilio', 'vonage'
    |
    */
    'default' => env('SMS_SERVICE', 'log'),
    
    /*
    |--------------------------------------------------------------------------
    | Configuration des services SMS
    |--------------------------------------------------------------------------
    |
    | Configuration spécifique pour chaque service SMS supporté.
    |
    */
    'services' => [
        'log' => [
            'channel' => env('SMS_LOG_CHANNEL', 'stack'),
        ],
        
        'twilio' => [
            'sid' => env('TWILIO_SID'),
            'token' => env('TWILIO_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],
        
        'vonage' => [
            'key' => env('VONAGE_KEY'),
            'secret' => env('VONAGE_SECRET'),
            'from' => env('VONAGE_FROM'),
        ],
    ],
];