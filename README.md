# Filament Tracking Consent

[![Latest Version on Packagist](https://img.shields.io/packagist/v/postare/filament-tracking-consent.svg?style=flat-square)](https://packagist.org/packages/postare/filament-tracking-consent)[![Total Downloads](https://img.shields.io/packagist/dt/postare/filament-tracking-consent.svg?style=flat-square)](https://packagist.org/packages/postare/filament-tracking-consent)

**Filament Tracking Consent** is a Filament plugin that allows you to easily integrate tracking codes (e.g., Google Analytics) into your frontend while ensuring compliance with GDPR and other privacy regulations.

This package includes a **fully customizable cookie consent banner** and provides a structured way to manage tracking scripts based on user preferences.

## Features

✅ **GDPR-Compliant Cookie Consent Banner** – Display a customizable banner for users to accept or reject tracking cookies.  
✅ **Automatic Script Blocking** – Tracking scripts are only executed once user consent is granted.  
✅ **Granular Consent Management** – Users can enable or disable tracking per category (e.g., Analytics, Marketing, Preferences).  
✅ **Easy Integration** – Simple Blade components and stack placeholders to include tracking scripts in your layout.  
✅ **Fully Configurable** – Modify the banner style, text, and behavior via a Filament Page.  
✅ **Supports Multiple Languages** – Easily translate consent messages for multilingual applications.  
✅ **Built on CookieConsent.js** – Uses the powerful [CookieConsent](https://github.com/orestbida/cookieconsent) library by Orest Bida for a robust and reliable solution.

## Prerequisites

This package depends on [DB Config](https://github.com/postare/db-config). Make sure you install it first.

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
    'settings-page' => [
        'title' => 'Tracking Settings',
        'navigation-label' => 'Tracking and Consent',
        'navigation-icon' => 'heroicon-o-presentation-chart-bar',
        'navigation-group' => 'Settings',
    ],
];
```

## Registering the Plugin

To enable the plugin, register it inside your Filament panel provider, typically in `app/Providers/Filament/AdminPanelProvider.php`:

```php
->plugins([
    ...
    \Postare\FilamentTrackingConsent\FilamentTrackingConsentPlugin::make(),
])
```

## Usage

### Displaying the Consent Banner

Add the tracking consent component inside your layout file, **just before the closing `<head>` tag**:

```blade
<x-filament-tracking-consent::tracking-consent />
```

### Injecting Tracking Scripts

Use these stack placeholders to control where tracking scripts are injected:

-   **Immediately after opening `<body>`**:

    ```blade
    @stack('tracking-consent-body-start')
    ```

-   **Just before closing `</body>`**:

    ```blade
    @stack('tracking-consent-body-end')
    ```

### Cookie Preferences Button

To allow users to adjust their cookie preferences after initial selection, place this stack wherever you want the button to appear (e.g., in the footer):

```blade
@stack('tracking-consent-preferences-btn')
```

## JavaScript Dependency

This plugin is powered by [CookieConsent.js](https://github.com/orestbida/cookieconsent), an open-source, lightweight, and highly customizable JavaScript library for managing cookie consent.

### Why CookieConsent.js?

-   **Fully customizable UI** – Modify the banner design to match your brand.
-   **Granular consent control** – Users can enable or disable specific categories of cookies.
-   **Automatic script management** – Blocks tracking scripts until consent is given.
-   **Multiple language support** – Display consent banners in different languages.
-   **Privacy law compliance** – Helps ensure compliance with GDPR, CCPA, and similar regulations.

For advanced customization options, refer to the [CookieConsent documentation](https://github.com/orestbida/cookieconsent).

## Credits

-   [Francesco Apruzzese](https://github.com/postare)
-   [All Contributors](../../contributors)

## License

This package is open-source software licensed under the [MIT License](LICENSE.md).
