# Filament Tracking Consent

[![Latest Version on Packagist](https://img.shields.io/packagist/v/postare/filament-tracking-consent.svg?style=flat-square)](https://packagist.org/packages/postare/filament-tracking-consent)  
[![Total Downloads](https://img.shields.io/packagist/dt/postare/filament-tracking-consent.svg?style=flat-square)](https://packagist.org/packages/postare/filament-tracking-consent)

A Filament plugin that allows you to easily integrate tracking codes (e.g., Google Analytics) into your frontend, manage related cookies, and display a fully customizable GDPR consent banner.

## Prerequisites

This package requires the [DB Config](https://github.com/postare/db-config) plugin. Ensure you have it installed before proceeding.

## Installation

Install the package via Composer:

```bash
composer require postare/filament-tracking-consent
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag="filament-tracking-consent-config"
```

The default configuration file looks like this:

```php
return [
];
```

## Registering the Plugin

To enable the plugin, add it to the `plugins` array inside your Filament panel provider, typically located in `app/Providers/Filament/AdminPanelProvider.php`:

```php
->plugins([
    ...
    \Postare\FilamentTrackingConsent\FilamentTrackingConsentPlugin::make(),
])
```

## Usage

### Adding the Consent Banner

Include the tracking consent component in your layout file, just before the closing `<head>` tag:

```blade
<x-filament-tracking-consent::tracking-consent />
```

### Injecting Tracking Code

To insert tracking scripts dynamically, add the following stack placeholders in your layout:

-   **Immediately after opening `<body>`**:

    ```blade
    @stack('tracking-consent-body-start')
    ```

-   **Just before closing `</body>`**:

    ```blade
    @stack('tracking-consent-body-end')
    ```

### Cookie Preferences Button

To allow users to manage their consent preferences, add this stack wherever you want the preferences button to appear (e.g., in the footer):

```blade
@stack('tracking-consent-preferences-btn')
```

## Credits

-   [Francesco Apruzzese](https://github.com/postare)
-   [All Contributors](../../contributors)

## License

This package is open-source software licensed under the [MIT License](LICENSE.md).
