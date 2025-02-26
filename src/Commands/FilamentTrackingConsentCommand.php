<?php

namespace Postare\FilamentTrackingConsent\Commands;

use Illuminate\Console\Command;

class FilamentTrackingConsentCommand extends Command
{
    public $signature = 'filament-tracking-consent';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
