# Laravel Support Page

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sfolador/support.svg?style=flat-square)](https://packagist.org/packages/sfolador/support)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/sfolador/support/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/sfolador/support/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/sfolador/support/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/sfolador/support/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sfolador/support.svg?style=flat-square)](https://packagist.org/packages/sfolador/support)

A Laravel package that provides a ready-to-use support page with a contact form, email notifications, and optional Filament admin panel integration.

## Features

- Beautiful, responsive support form with Tailwind CSS styling
- Email notifications for new support requests
- Optional Google reCAPTCHA v2 protection
- Customizable support request types
- Translatable (i18n support)
- Optional Filament admin panel integration
- Fully configurable routes, middleware, and layout

## Requirements

- PHP 8.3 or higher
- Laravel 11.x or 12.x

## Installation

Install the package via Composer:

```bash
composer require sfolador/support
```

Publish and run the migrations:

```bash
php artisan vendor:publish --tag="support-migrations"
php artisan migrate
```

Publish the config file:

```bash
php artisan vendor:publish --tag="support-config"
```

## Configuration

After publishing, the configuration file will be located at `config/support.php`:

```php
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
```

### Environment Variables

Add these variables to your `.env` file:

```env
# Required: Email address to receive support requests
SUPPORT_EMAIL=support@yourdomain.com

# Optional: Enable reCAPTCHA protection
SUPPORT_RECAPTCHA_ENABLED=true
SUPPORT_RECAPTCHA_SITE_KEY=your-site-key
SUPPORT_RECAPTCHA_SECRET_KEY=your-secret-key
```

## Usage

Once installed, the support page is available at `/support` (or your configured `route_prefix`).

### Routes

The package registers two routes:

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | /support | support | Display the support form |
| POST | /support | support.store | Submit a support request |

### Using Your Own Layout

By default, the package uses a minimal standalone layout. To use your application's layout:

1. Update `config/support.php`:

```php
'layout' => 'layouts.app', // Your layout file
```

2. Make sure your layout has the following sections:
   - `@yield('title')` - Page title
   - `@yield('scripts')` - For reCAPTCHA script (if enabled)
   - `@yield('content')` - Main content

### Customizing Views

Publish the views to customize them:

```bash
php artisan vendor:publish --tag="support-views"
```

The views will be published to `resources/views/vendor/support/`.

### Customizing Translations

Publish the translation files:

```bash
php artisan vendor:publish --tag="support-translations"
```

The translations will be published to `lang/vendor/support/`.

### Custom Support Types

Modify the `support_types` array in the config to add or change support request types:

```php
'support_types' => [
    'bug' => 'Bug Report',
    'feature' => 'Feature Request',
    'billing' => 'Billing Question',
    'other' => 'Other',
],
```

## Filament Integration

If you're using [Filament](https://filamentphp.com/), this package provides a ready-to-use admin panel for managing support requests.

### Setup

Register the plugin in your `AdminPanelProvider`:

```php
use Sfolador\Support\Filament\SupportPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugins([
            SupportPlugin::make(),
        ]);
}
```

This adds a "Support Requests" resource to your admin panel where you can:

- View all support requests
- Filter by support type
- View individual request details
- Delete requests

## Database

The package creates a `support_requests` table with the following structure:

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Requester's name |
| email | string | Requester's email |
| support_type | string | Type of support request |
| content | text | Request details |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

### Accessing Support Requests

You can query support requests using the `SupportRequest` model:

```php
use Sfolador\Support\Models\SupportRequest;

// Get all requests
$requests = SupportRequest::all();

// Get requests by type
$issues = SupportRequest::where('support_type', 'issue')->get();

// Get recent requests
$recent = SupportRequest::latest()->take(10)->get();
```

## Email Notifications

When a support request is submitted, an email notification is sent to the configured `support_email` address. The email includes:

- Requester's name
- Requester's email
- Support type
- Request content

Make sure your Laravel mail configuration is properly set up.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Simone Folador](https://github.com/sfolador)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
