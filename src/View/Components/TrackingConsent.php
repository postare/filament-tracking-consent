<?php

namespace Postare\FilamentTrackingConsent\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TrackingConsent extends Component
{
    public $categories;

    public $cookiesByCategory;

    public $trackAndCookies;

    public $categories_only;

    public $cookieconsent;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->trackAndCookies = collect(db_config('tracking_consent.track_and_cookies'));

        $this->cookieconsent = db_config('tracking_consent.cookieconsent');

        $this->categories = $this->trackAndCookies->flatMap(function ($item) {
            return collect($item['cookies'])->map(function ($cookie) use ($item) {
                return ['category' => $item['category'], 'cookie' => $cookie];
            });
        })->groupBy('category')->union($this->trackAndCookies->pluck('category')->flip()->map(function () {
            return collect();
        }))->map(function ($group) {
            return $group->pluck('cookie');
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string | null
    {
        // se vuoto, non fare nulla
        if ($this->cookieconsent === null) {
            // non renderizzare il componente
            return null;
        }

        return view('filament-tracking-consent::tracking-consent', [
            'categories' => $this->categories,
            'cookieconsent' => $this->cookieconsent,
            'trackAndCookies' => $this->trackAndCookies,
        ]);
    }
}
