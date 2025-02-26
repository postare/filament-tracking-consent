# This is my package filament-tracking-consent

[![Latest Version on Packagist](https://img.shields.io/packagist/v/postare/filament-tracking-consent.svg?style=flat-square)](https://packagist.org/packages/postare/filament-tracking-consent)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/postare/filament-tracking-consent/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/postare/filament-tracking-consent/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/postare/filament-tracking-consent/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/postare/filament-tracking-consent/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/postare/filament-tracking-consent.svg?style=flat-square)](https://packagist.org/packages/postare/filament-tracking-consent)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require postare/filament-tracking-consent
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-tracking-consent-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-tracking-consent-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-tracking-consent-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentTrackingConsent = new Postare\FilamentTrackingConsent();
echo $filamentTrackingConsent->echoPhrase('Hello, Postare!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Francesco Apruzzese](https://github.com/postare)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
