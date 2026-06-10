<header class="header{{ \App\theme_has_hero_header() ? ' header--dark' : ' header--scrolled' }}" id="header">
  <div class="header-inner">

    {{-- Logo --}}
    <a href="{{ esc_url(home_url('/')) }}" class="header-logo" aria-label="Reenpro">
      {!! wp_get_attachment_image(get_field('logo', 'option'), 'full', false, ['class' => 'header-logo__white']) !!}
      {!! wp_get_attachment_image(get_field('logo_color', 'option'), 'full', false, ['class' => 'header-logo__color']) !!}
    </a>

    {{-- Desktop Navigation --}}
    @php
      $nav_items = has_nav_menu('primary_navigation')
        ? (wp_get_nav_menu_items(get_nav_menu_locations()['primary_navigation'] ?? 0) ?: [])
        : [];

      function header_children($items, $parent_id) {
        return array_values(array_filter($items, fn($i) => (int) $i->menu_item_parent === (int) $parent_id));
      }

      function header_find($items, $needle) {
        foreach ($items as $i) {
          if ($i->menu_item_parent == 0 && stripos($i->title, $needle) !== false) {
            return $i;
          }
        }
        return null;
      }

      function header_panel_item($url, $title, $tag = '') {
        return (object) [
          'url'      => $url,
          'title'    => $title,
          'menu_tag' => $tag,
        ];
      }

      $projektai = header_find($nav_items, 'gyvendint');
      $projektai_sub = $projektai ? header_children($nav_items, $projektai->ID) : [];

      $paslaugos = header_find($nav_items, 'paslaug');
      $paslaugos_sub = $paslaugos ? header_children($nav_items, $paslaugos->ID) : [];
      if (! $paslaugos_sub) {
        $paslaugos_sub = [
          header_panel_item('/paslaugos/saules-elektrines-verslui/', 'Saulės elektrinės verslui'),
          header_panel_item('/paslaugos/saules-elektrines-namams/', 'Saulės elektrinės namams'),
          header_panel_item('/paslaugos/elektromobiliu-ikrovimo-stoteles/', 'Elektromobilių įkrovimo stotelės'),
          header_panel_item('/paslaugos/energijos-kaupikliai/', 'Elektros kaupikliai namams ir verslui'),
          header_panel_item('/paslaugos/projektavimas/', 'Saulės elektrinių projektavimas'),
          header_panel_item('/paslaugos/prieziura/', 'Saulės elektrinių priežiūra (O&M)'),
        ];
      }

      $iranga = header_find($nav_items, 'ranga');
      $iranga_sub = $iranga ? header_children($nav_items, $iranga->ID) : [];

      $parama = header_find($nav_items, 'arama');
      $parama_sub = $parama ? header_children($nav_items, $parama->ID) : [];

      $apie = header_find($nav_items, 'apie');
      $apie_sub = $apie ? header_children($nav_items, $apie->ID) : [];

      $mobile_root = [
        [
          'title' => 'Įgyvendinti projektai',
          'url'   => $projektai ? esc_url($projektai->url) : (get_post_type_archive_link('projects') ?: '/igyvendinti-projektai/'),
          'panel' => $projektai_sub ? ['id' => 'projektai', 'items' => $projektai_sub] : null,
        ],
        [
          'title' => 'Paslaugos',
          'url'   => $paslaugos ? esc_url($paslaugos->url) : '#',
          'panel' => $paslaugos_sub ? ['id' => 'paslaugos', 'items' => $paslaugos_sub] : null,
        ],
        [
          'title' => 'Įranga',
          'url'   => $iranga ? esc_url($iranga->url) : '/iranga/',
          'panel' => $iranga_sub ? ['id' => 'iranga', 'items' => $iranga_sub] : null,
        ],
        [
          'title' => 'Parama',
          'url'   => $parama ? esc_url($parama->url) : '/parama/',
          'panel' => $parama_sub ? ['id' => 'parama', 'items' => $parama_sub] : null,
        ],
        [
          'title' => 'Apie mus',
          'url'   => $apie ? esc_url($apie->url) : '/apie-mus/',
          'panel' => $apie_sub ? ['id' => 'apie', 'items' => $apie_sub] : null,
        ],
      ];
    @endphp

    <nav class="header-nav" id="headerNav">
      <ul class="header-nav__list">

        {{-- Įgyvendinti projektai --}}
        <li class="header-nav__item {{ $projektai_sub ? 'header-nav__item--has-panel' : '' }}">
          <a href="{{ $projektai ? esc_url($projektai->url) : '/igyvendinti-projektai/' }}" class="header-nav__link">
            Įgyvendinti projektai
            @if($projektai_sub)
              <svg class="header-nav__chevron" viewBox="0 0 12 7" fill="none"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            @endif
          </a>
          @if($projektai_sub)
            @include('partials.header-nav-panel', ['items' => $projektai_sub, 'layout' => 'single'])
          @endif
        </li>

        {{-- Paslaugos --}}
        <li class="header-nav__item header-nav__item--has-panel">
          <a href="{{ $paslaugos ? esc_url($paslaugos->url) : '#' }}" class="header-nav__link">
            Paslaugos
            <svg class="header-nav__chevron" viewBox="0 0 12 7" fill="none"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          @include('partials.header-nav-panel', ['items' => $paslaugos_sub, 'layout' => 'double'])
        </li>

        {{-- Įranga --}}
        <li class="header-nav__item {{ $iranga_sub ? 'header-nav__item--has-panel' : '' }}">
          <a href="{{ $iranga ? esc_url($iranga->url) : '/iranga/' }}" class="header-nav__link">
            Įranga
            @if($iranga_sub)
              <svg class="header-nav__chevron" viewBox="0 0 12 7" fill="none"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            @endif
          </a>
          @if($iranga_sub)
            @include('partials.header-nav-panel', ['items' => $iranga_sub, 'layout' => 'double'])
          @endif
        </li>

        {{-- Parama --}}
        <li class="header-nav__item {{ $parama_sub ? 'header-nav__item--has-panel' : '' }}">
          <a href="{{ $parama ? esc_url($parama->url) : '/parama/' }}" class="header-nav__link">
            Parama
            @if($parama_sub)
              <svg class="header-nav__chevron" viewBox="0 0 12 7" fill="none"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            @endif
          </a>
          @if($parama_sub)
            @include('partials.header-nav-panel', ['items' => $parama_sub, 'layout' => 'double'])
          @endif
        </li>

        {{-- Apie mus --}}
        <li class="header-nav__item {{ $apie_sub ? 'header-nav__item--has-panel' : '' }}">
          <a href="{{ $apie ? esc_url($apie->url) : '/apie-mus/' }}" class="header-nav__link">
            Apie mus
            @if($apie_sub)
              <svg class="header-nav__chevron" viewBox="0 0 12 7" fill="none"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            @endif
          </a>
          @if($apie_sub)
            @include('partials.header-nav-panel', ['items' => $apie_sub, 'layout' => 'single'])
          @endif
        </li>

      </ul>
    </nav>

    {{-- CTA buttons --}}
    <div class="header-actions">
      @if(get_field('header_form_button', 'options'))
        @php $linkHeaderButton = get_field('header_form_button', 'options'); @endphp
        <a class="header-btn header-btn--red"
           href="{{ esc_url($linkHeaderButton['url']) }}"
           target="{{ $linkHeaderButton['target'] }}">
          {{ $linkHeaderButton['title'] }}<i></i>
        </a>
      @endif
      @if(get_field('header_offer_button', 'options'))
        <div class="header-btn header-btn--purple {{ (is_singular('product') || is_singular('donation')) ? 'getMainOfferHeader' : '' }}"
          @if(! is_singular('product') && ! is_singular('donation'))
            id="getOffer"
            data-toggle="modal"
            data-target="#offerModal"
          @endif>
          {!! get_field('header_offer_button', 'options') !!}<i></i>
        </div>
      @endif
    </div>

    {{-- Mobile burger --}}
    <button class="header-burger" id="headerBurger" aria-label="Navigacija">
      <span></span><span></span><span></span>
    </button>

  </div>

  {{-- Mobile nav --}}
  <div class="header-mobile-nav" id="headerMobileNav" aria-hidden="true">
    <div class="header-mobile-nav__sheet">
      <div class="header-mobile-nav__stage">
        <div class="header-mobile-nav__view header-mobile-nav__view--root is-active" data-mobile-nav-view="root">
          <div class="header-mobile-nav__scroll">
            <ul class="header-mobile-nav__list">
              @foreach($mobile_root as $entry)
                <li>
                  @if($entry['panel'])
                    <button type="button"
                            class="header-mobile-nav__drill"
                            data-mobile-nav-target="{{ $entry['panel']['id'] }}">
                      <span>{{ $entry['title'] }}</span>
                      <svg class="header-mobile-nav__chevron" viewBox="0 0 8 12" fill="none" aria-hidden="true">
                        <path d="M1 1l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </button>
                  @else
                    <a href="{{ $entry['url'] }}" class="header-mobile-nav__link">
                      <span>{{ $entry['title'] }}</span>
                    </a>
                  @endif
                </li>
              @endforeach
            </ul>
          </div>
        </div>

        @foreach($mobile_root as $entry)
          @if($entry['panel'])
            <div class="header-mobile-nav__view"
                 data-mobile-nav-view="{{ $entry['panel']['id'] }}"
                 hidden>
              <div class="header-mobile-nav__toolbar">
                <button type="button" class="header-mobile-nav__back" aria-label="Atgal">
                  <svg viewBox="0 0 8 12" fill="none" aria-hidden="true">
                    <path d="M7 1L2 6l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </button>
                <span class="header-mobile-nav__toolbar-title">{{ $entry['title'] }}</span>
                <button type="button" class="header-mobile-nav__close" aria-label="Uždaryti">
                  <svg viewBox="0 0 14 14" fill="none" aria-hidden="true">
                    <path d="M1 1l12 12M13 1L1 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                  </svg>
                </button>
              </div>
              <div class="header-mobile-nav__scroll">
                @include('partials.header-mobile-nav-items', ['items' => $entry['panel']['items']])
              </div>
            </div>
          @endif
        @endforeach
      </div>

      <div class="header-mobile-nav__actions">
        @if(get_field('header_form_button', 'options'))
          @php $linkHeaderButton = get_field('header_form_button', 'options'); @endphp
          <a class="header-btn header-btn--red header-btn--full" href="{{ esc_url($linkHeaderButton['url']) }}">
            {{ $linkHeaderButton['title'] }}<i></i>
          </a>
        @endif
        @if(get_field('header_offer_button', 'options'))
          <div class="header-btn header-btn--purple header-btn--full"
            data-toggle="modal"
            data-target="#offerModal">
            {!! get_field('header_offer_button', 'options') !!}<i></i>
          </div>
        @endif
      </div>
    </div>
  </div>
</header>
<div class="header-blur" id="headerBlur"></div>
