<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Support Email
    |--------------------------------------------------------------------------
    |
    | The email address where support requests will be sent.
    |
    */
    'support_email' => env('SUPPORT_EMAIL'),

    /*
    |--------------------------------------------------------------------------
    | Support Types
    |--------------------------------------------------------------------------
    |
    | The types of support requests that users can submit.
    | The key is stored in the database, the value is displayed to the user.
    |
    */
    'support_types' => [
        'issue' => 'Technical Issue',
        'email' => 'Email Support',
        'data_removal' => 'Data Removal Request',
        'inquiry' => 'General Inquiry',
    ],

    /*
    |--------------------------------------------------------------------------
    | reCAPTCHA Configuration
    |--------------------------------------------------------------------------
    |
    | Enable or disable reCAPTCHA for the support form.
    | If enabled, you must provide your site key and secret key.
    |
    */
    'recaptcha' => [
        'enabled' => env('SUPPORT_RECAPTCHA_ENABLED', false),
        'site_key' => env('SUPPORT_RECAPTCHA_SITE_KEY'),
        'secret_key' => env('SUPPORT_RECAPTCHA_SECRET_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the middleware and route prefix for the support page.
    |
    */
    'middleware' => ['web'],
    'route_prefix' => 'support',

    /*
    |--------------------------------------------------------------------------
    | Layout Configuration
    |--------------------------------------------------------------------------
    |
    | The layout that the support page should extend.
    | Use 'support::layouts.app' for the default layout,
    | or specify your own (e.g., 'layouts.app').
    |
    */
    'layout' => 'support::layouts.app',

    /*
    |--------------------------------------------------------------------------
    | Page Title
    |--------------------------------------------------------------------------
    |
    | The title displayed on the support page.
    |
    */
    'page_title' => 'Contact Support',
];
