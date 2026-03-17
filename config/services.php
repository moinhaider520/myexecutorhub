<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'recaptcha' => [
        'site_key' => env('RECAPTCHA_SITE_KEY'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    ],

    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],

    'cpanel' => [
        'base_url' => env('CPANEL_BASE_URL'),
        'username' => env('CPANEL_USERNAME'),
        'api_token' => env('CPANEL_API_TOKEN'),
        'account_username' => env('CPANEL_ACCOUNT_USERNAME'),
        'domain' => env('CPANEL_MAIL_DOMAIN', 'executorhub.co.uk'),
        'webmail_url' => env('CPANEL_WEBMAIL_URL'),
        'mailbox_quota_mb' => env('CPANEL_MAILBOX_QUOTA_MB', 1024),
    ],

    'moneyhub' => [
        'client_id' => env('MONEYHUB_CLIENT_ID'),
        'redirect_uri' => env('MONEYHUB_REDIRECT_URI', 'https://executorhub.co.uk/customer/bank_accounts/moneyhub/callback'),
        'identity_base_url' => env('MONEYHUB_IDENTITY_BASE_URL', 'https://identity.moneyhub.co.uk'),
        'api_base_url' => env('MONEYHUB_API_BASE_URL', 'https://api.moneyhub.co.uk/v3.0'),
        'private_key_path' => env('MONEYHUB_PRIVATE_KEY_PATH', storage_path('app/moneyhub/private_key.pem')),
        'jwks_kid' => env('MONEYHUB_JWKS_KID'),
    ],

];


