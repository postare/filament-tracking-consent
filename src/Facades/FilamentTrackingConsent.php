<?php

namespace Postare\FilamentTrackingConsent\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Postare\FilamentTrackingConsent\FilamentTrackingConsent
 */
class FilamentTrackingConsent extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Postare\FilamentTrackingConsent\FilamentTrackingConsent::class;
    }
}
