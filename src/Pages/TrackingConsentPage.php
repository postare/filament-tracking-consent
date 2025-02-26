<?php

namespace Postare\FilamentTrackingConsent\Pages;

use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Postare\DbConfig\AbstractPageSettings;
use Riodwanto\FilamentAceEditor\AceEditor;
use Illuminate\Contracts\Support\Htmlable;

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

                Section::make('Aspetto banner cookies')
                    ->columns(2)
                    ->schema([

                        Forms\Components\TextInput::make('cookieconsent.title')
                            ->label('Titolo del banner')
                            ->default('Questo sito utilizza i cookies')
                            ->columnSpanFull()
                            ->required(),

                        Forms\Components\TextArea::make('cookieconsent.description')
                            ->label('Messaggio del banner')
                            ->default('Questo sito utilizza i cookies per garantire la migliore esperienza di navigazione.')
                            ->columnSpanFull()
                            ->required(),

                        Forms\Components\Select::make('cookieconsent.layout')
                            ->label('Layout')
                            ->live(true)
                            ->options([
                                'box' => 'Box',
                                'cloud' => 'Cloud',
                                'bar' => 'Bar',
                            ])
                            ->default('box')
                            ->required(),

                        Forms\Components\Select::make('cookieconsent.layout_variant')
                            ->label('Variante')
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
                            ->label('Posizione orizzontale')
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
                            ->label('Posizione verticale')
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
                Repeater::make('track_and_cookies')
                    ->label('Codici di tracciamento e relativi Cookies')
                    ->columns(2)
                    ->columnSpanFull()
                    ->deleteAction(
                        fn (Action $action) => $action->requiresConfirmation(),
                    )
                    ->schema([
                        Forms\Components\Select::make('position')
                            ->label('Posizione')
                            ->options([
                                'head' => 'HEAD',
                                'body' => 'Inizio BODY',
                                'footer' => 'Fine BODY',
                            ])
                            ->default('body')
                            ->required(),
                        Forms\Components\Select::make('category')
                            ->label('Categoria')
                            ->options([
                                'analytics' => 'Analytics',
                                'marketing' => 'Marketing',
                                'necessary' => 'Necessari',
                                'other' => 'Altro',
                            ])
                            ->default('analytics')
                            ->required(),
                        AceEditor::make('code')
                            ->label('Codice')
                            ->columnSpanFull()
                            ->required(),

                        Repeater::make('cookies')
                            ->label('Tabella dei cookies')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nome')
                                    ->required(),
                                Forms\Components\TextInput::make('service')
                                    ->label('Servizio')
                                    ->required(),
                                Forms\Components\TextInput::make('description')
                                    ->label('Descrizione')
                                    ->required(),
                                Forms\Components\TextInput::make('expiration')
                                    ->label('Scadenza')
                                    ->required(),
                            ])
                            ->deleteAction(
                                fn (Action $action) => $action->requiresConfirmation(),
                            )
                            ->addActionLabel('Aggiungi cookie')
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->columnSpanFull(),
                    ]),

            ])
            ->statePath('data');
    }
}
