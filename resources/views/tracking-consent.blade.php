<trackandcookie>
    {{-- Quello che metti qui dentro viene renderizzato nella head --}}
    {{-- Codici di tracking per la head --}}

    <link rel="stylesheet" href="/css/postare/filament-tracking-consent/filament-tracking-consent-styles.css" />
    <script src="/js/postare/filament-tracking-consent/filament-tracking-consent-scripts.js"></script>

    @foreach ($trackAndCookies as $track)
        {{--
            This code snippet removes the 'type' attribute from the <script> tags in the tracking code.
            It uses a regular expression to match <script> tags with any 'type' attribute and replaces them with <script> tags without the 'type' attribute.
            The regular expression '/<script(.*?)type=".*?"(.*?)>/' is used to find the <script> tags with 'type' attribute.
            The replacement string '<script$1$2>' reconstructs the <script> tag without the 'type' attribute.
        --}}
        @php
            $tracking_code = preg_replace('/<script(.*?)type=".*?"(.*?)>/', '<script$1$2>', $track['code']);
            $tracking_code = preg_replace('/<script(.*?)>/', '<script$1 type="text/plain" data-category="' . $track['category'] . '">', $tracking_code);
        @endphp

        @if ($track['position'] == 'head')
            {!! $tracking_code !!}
        @elseif ($track['position'] == 'body')
            @push('trackandcookie-body-start')
                {!! $tracking_code !!}
            @endpush
        @elseif ($track['position'] == 'footer')
            @push('trackandcookie-body-end')
                {!! $tracking_code !!}
            @endpush
        @endif
    @endforeach
</trackandcookie>

@push('trackandcookie-preferences-btn')
    &middot;
    <button class="footer-link" type="button" data-cc="show-preferencesModal">Preferenze Cookies</button>
@endpush

@push('trackandcookie-body-end')
    {{--
        All config. options available here:
        https://cookieconsent.orestbida.com/reference/configuration-reference.html
    --}}

    <script>
        CookieConsent.run({

                guiOptions: {
                    consentModal: {
                        layout: @js($cookieconsent['layout'] . ($cookieconsent['layout_variant'] ? ' ' . $cookieconsent['layout_variant'] : '')),
                        position: @js($cookieconsent['positionY'] . ' ' . $cookieconsent['positionX']),
                        flipButtons: false,
                        equalWeightButtons: false
                    },
                    preferencesModal: {
                        layout: 'box',
                        // position: 'left right',
                        flipButtons: false,
                        equalWeightButtons: true
                    }
                },

            categories: {
                necessary: {
                    enabled: true,  // this category is enabled by default
                    readOnly: true  // this category cannot be disabled
                },

                @foreach ($categories as $category => $cookies)

                    {{ $category }}: {},

                @endforeach
            },

            language: {
                default: 'it',
                translations: {
                    it: {
                        consentModal: {
                            title: @js($cookieconsent['title']),
                            description: @js($cookieconsent['description']),
                            acceptAllBtn: 'Accetta tutti',
                            acceptNecessaryBtn: 'Rifiuta tutti',
                            showPreferencesBtn: 'Gestisci preferenze individuali'
                        },
                        preferencesModal: {
                            title: 'Gestisci le preferenze dei cookie',
                            acceptAllBtn: 'Accetta tutti',
                            acceptNecessaryBtn: 'Rifiuta tutti',
                            savePreferencesBtn: 'Accetta selezione corrente',
                            closeIconLabel: 'Chiudi modale',
                            sections: [
                                {
                                    title: 'Qualcuno ha detto ... cookie?',
                                    description: 'Ne voglio uno!'
                                },
                                {
                                    title: 'Cookie strettamente necessari',
                                    description: 'Questi cookie sono essenziali per il corretto funzionamento del sito web e non possono essere disabilitati.',

                                    // questo campo genererà un toggle collegato alla categoria 'necessary'
                                    linkedCategory: 'necessary'
                                },

                                @foreach ($categories as $category => $cookies)
                                    //
                                    {
                                        title: '{{ ucfirst($category) }}',
                                        description: 'Questi cookie raccolgono informazioni su come utilizzi il nostro sito web. Questo ci permette di migliorare il nostro sito web e la tua esperienza di navigazione.',

                                        //this field will generate a toggle linked to the category
                                        linkedCategory: '{{ $category }}',

                                        @if($cookies->count() > 0)
                                        //
                                        cookieTable: {
                                            headers: {
                                                name: "Name",
                                                domain: "Service",
                                                description: "Description",
                                                expiration: "Expiration"
                                            },
                                            body: [

                                            @foreach ($cookies as $cookie)

                                            {
                                                name: @js($cookie['name']),
                                                domain: @js($cookie['service']),
                                                description: @js($cookie['description']),
                                                expiration: @js($cookie['expiration'])
                                            },

                                            @endforeach

                                            ]
                                        }
                                        //
                                        @endif
                                    },
                                    //
                                @endforeach

                                {
                                    title: 'Ulteriori informazioni',
                                    description: 'Per qualsiasi domanda relativa alla mia politica sui cookie e alle tue scelte, per favore <a href="#contact-page">contattaci</a>'
                                }
                            ]
                        }
                    }
                }
            }
        });
    </script>
@endpush
