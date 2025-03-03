<?php

namespace Postare\FilamentTrackingConsent\Pages;

use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Contracts\Support\Htmlable;
use Postare\DbConfig\AbstractPageSettings;

class TrackingConsentPage extends AbstractPageSettings
{
    public ?array $data = [];

    public function getTitle(): string | Htmlable
    {
        return config('filament-tracking-consent.settings-page.title');
    }

    public static function getNavigationLabel(): string
    {
        return config('filament-tracking-consent.settings-page.navigation-label');
    }

    public static function getNavigationIcon(): string | Htmlable
    {
        return config('filament-tracking-consent.settings-page.navigation-icon');
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-tracking-consent.settings-page.navigation-group', null);
    }

    protected ?string $subheading = '';

    protected static string $view = 'filament-tracking-consent::config-page';

    protected function settingName(): string
    {
        return 'tracking_consent';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make(__('filament-tracking-consent::tracking-consent.banner_title'))
                    ->columns(2)
                    ->schema([
                        Tabs::make('Tabs')
                            ->columnSpanFull()
                            ->contained(false)
                            ->tabs([
                                Tabs\Tab::make(__('filament-tracking-consent::tracking-consent.banner_section'))
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('cookieconsent.title')
                                            ->label(__('filament-tracking-consent::tracking-consent.banner_title'))
                                            ->default(__('filament-tracking-consent::tracking-consent.banner_title'))
                                            ->columnSpanFull()
                                            ->required(),

                                        Forms\Components\Textarea::make('cookieconsent.description')
                                            ->label(__('filament-tracking-consent::tracking-consent.banner_message'))
                                            ->default(__('filament-tracking-consent::tracking-consent.banner_message'))
                                            ->columnSpanFull()
                                            ->required(),
                                        Forms\Components\Select::make('cookieconsent.layout')
                                            ->label(__('filament-tracking-consent::tracking-consent.layout'))
                                            ->live(true)
                                            ->options([
                                                'box' => 'Box',
                                                'cloud' => 'Cloud',
                                                'bar' => 'Bar',
                                            ])
                                            ->default('box')
                                            ->required(),

                                        Forms\Components\Select::make('cookieconsent.layout_variant')
                                            ->label(__('filament-tracking-consent::tracking-consent.layout_variant'))
                                            ->options(fn (Get $get) => match ($get('cookieconsent.layout')) {
                                                'box' => [
                                                    'wide' => 'Wide',
                                                    'inline' => 'Inline',
                                                    '' => 'None',
                                                ],
                                                default => [
                                                    'inline' => 'Inline',
                                                    '' => 'None',
                                                ]
                                            })
                                            ->default(''),

                                        Forms\Components\Select::make('cookieconsent.positionX')
                                            ->label(__('filament-tracking-consent::tracking-consent.position_x'))
                                            ->options(fn (Get $get) => match ($get('cookieconsent.layout')) {
                                                'box' => [
                                                    '' => 'None',
                                                ],
                                                default => [
                                                    'left' => 'Left',
                                                    'right' => 'Right',
                                                    'center' => 'Center',
                                                ]
                                            })
                                            ->default('center'),

                                        Forms\Components\Select::make('cookieconsent.positionY')
                                            ->label(__('filament-tracking-consent::tracking-consent.position_y'))
                                            ->options(fn (Get $get) => match ($get('cookieconsent.layout')) {
                                                'bar' => [
                                                    'top' => 'Top',
                                                    'bottom' => 'Bottom',
                                                ],
                                                default => [
                                                    'top' => 'Top',
                                                    'bottom' => 'Bottom',
                                                    'middle' => 'Middle',
                                                ]
                                            })
                                            ->default('middle'),
                                    ]),
                                Tabs\Tab::make(__('filament-tracking-consent::tracking-consent.preferences_section'))
                                    ->schema([
                                        Forms\Components\TextInput::make('cookieconsent.preferences_title')
                                            ->label(__('filament-tracking-consent::tracking-consent.preferences_title'))
                                            ->default(__('filament-tracking-consent::tracking-consent.preferences_title'))
                                            ->columnSpanFull()
                                            ->required(),

                                        Forms\Components\Textarea::make('cookieconsent.preferences_description')
                                            ->label(__('filament-tracking-consent::tracking-consent.preferences_message'))
                                            ->default(__('filament-tracking-consent::tracking-consent.preferences_message'))
                                            ->columnSpanFull()
                                            ->required(),
                                    ]),
                            ]),

                    ]),
                Repeater::make('track_and_cookies')
                    ->label(__('filament-tracking-consent::tracking-consent.tracking_codes_label'))
                    ->columns(2)
                    ->columnSpanFull()
                    ->deleteAction(
                        fn (Action $action) => $action->requiresConfirmation(),
                    )
                    ->schema([
                        Forms\Components\Select::make('position')
                            ->label(__('filament-tracking-consent::tracking-consent.position'))
                            ->options([
                                'head' => __('filament-tracking-consent::tracking-consent.positions.head'),
                                'body' => __('filament-tracking-consent::tracking-consent.positions.body'),
                                'footer' => __('filament-tracking-consent::tracking-consent.positions.footer'),
                            ])
                            ->default('body')
                            ->required(),
                        Forms\Components\Select::make('category')
                            ->label(__('filament-tracking-consent::tracking-consent.category'))
                            ->options([
                                'analytics' => 'Analytics',
                                'marketing' => 'Marketing',
                                'necessary' => __('filament-tracking-consent::tracking-consent.necessary'),
                                'other' => 'Altro',
                            ])
                            ->default('analytics')
                            ->required(),
                        Forms\Components\Textarea::make('code')
                            ->label(__('filament-tracking-consent::tracking-consent.code'))
                            ->rows(5)
                            ->columnSpanFull()
                            ->required(),

                        Repeater::make('cookies')
                            ->label(__('filament-tracking-consent::tracking-consent.cookies_table'))
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('filament-tracking-consent::tracking-consent.name'))
                                    ->required(),
                                Forms\Components\TextInput::make('service')
                                    ->label(__('filament-tracking-consent::tracking-consent.service'))
                                    ->required(),
                                Forms\Components\TextInput::make('description')
                                    ->label(__('filament-tracking-consent::tracking-consent.description'))
                                    ->required(),
                                Forms\Components\TextInput::make('expiration')
                                    ->label(__('filament-tracking-consent::tracking-consent.expiration'))
                                    ->required(),
                            ])
                            ->deleteAction(
                                fn (Action $action) => $action->requiresConfirmation(),
                            )
                            ->addActionLabel(__('filament-tracking-consent::tracking-consent.add_cookie'))
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->columnSpanFull(),
                    ]),

            ])
            ->statePath('data');
    }
}
