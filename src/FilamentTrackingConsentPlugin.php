<?php

namespace Postare\FilamentTrackingConsent;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentTrackingConsentPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-tracking-consent';
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            \Postare\FilamentTrackingConsent\Pages\TrackingConsentPage::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
