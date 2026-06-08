<header class="header" id="header">
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
        return array_values(array_filter($items, fn($i) => (int)$i->menu_item_parent === (int)$parent_id));
      }
      function header_find($items, $needle) {
        foreach ($items as $i) {
          if ($i->menu_item_parent == 0 && stripos($i->title, $needle) !== false) return $i;
        }
        return null;
      }
    @endphp

    <nav class="header-nav" id="headerNav">
      <ul class="header-nav__list">

        {{-- Įgyvendinti projektai --}}
        @php $projektai = header_find($nav_items, 'gyvendint'); $projektai_sub = $projektai ? header_children($nav_items, $projektai->ID) : []; @endphp
        <li class="header-nav__item {{ $projektai_sub ? 'header-nav__item--dropdown' : '' }}">
          <a href="{{ $projektai ? esc_url($projektai->url) : '/igyvendinti-projektai/' }}" class="header-nav__link">
            Įgyvendinti projektai
            @if($projektai_sub)<svg class="header-nav__chevron" viewBox="0 0 12 7" fill="none"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>@endif
          </a>
          @if($projektai_sub)
            <ul class="header-nav__dropdown">
              @foreach($projektai_sub as $child)
                <li><a href="{{ esc_url($child->url) }}">{{ $child->title }}</a></li>
              @endforeach
            </ul>
          @endif
        </li>

        {{-- Paslaugos - mega menu --}}
        <li class="header-nav__item header-nav__item--mega">
          <a href="#" class="header-nav__link" role="button">
            Paslaugos
            <svg class="header-nav__chevron" viewBox="0 0 12 7" fill="none"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <div class="header-mega">
            <div class="header-mega__grid">
              <a href="/paslaugos/saules-elektrines-verslui/" class="header-mega__card">
                <div class="header-mega__icon"><svg viewBox="0 0 24 24" fill="none"><path d="M6.76 4.84L4.96 3.05 3.55 4.46l1.79 1.79 1.42-1.41zM4 10.5H1v2h3v-2zm9-9.95h-2V3.5h2V.55zm7.45 3.91l-1.41-1.41-1.79 1.79 1.41 1.41 1.79-1.79zm-3.21 13.7l1.79 1.8 1.41-1.41-1.8-1.79-1.4 1.4zM20 10.5v2h3v-2h-3zm-8-5c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm-1 16.95h2V19.5h-2v2.95zm-7.45-3.91l1.41 1.41 1.79-1.8-1.41-1.41-1.79 1.8z" fill="currentColor"/></svg></div>
                <span>Saulės elektrinės verslui</span>
              </a>
              <a href="/paslaugos/saules-elektrines-namams/" class="header-mega__card">
                <div class="header-mega__icon"><svg viewBox="0 0 24 24" fill="none"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" fill="currentColor"/></svg></div>
                <span>Saulės elektrinės namams</span>
              </a>
              <a href="/paslaugos/elektromobiliu-ikrovimo-stoteles/" class="header-mega__card">
                <div class="header-mega__icon"><svg viewBox="0 0 24 24" fill="none"><path d="M14.5 2h-9C4.67 2 4 2.67 4 3.5v17c0 .83.67 1.5 1.5 1.5h9c.83 0 1.5-.67 1.5-1.5V3.5c0-.83-.67-1.5-1.5-1.5zM10 20c-.83 0-1.5-.67-1.5-1.5S9.17 17 10 17s1.5.67 1.5 1.5S10.83 20 10 20zm4-4H6V4h8v12zm4-9h2v2h-2V7zm0 4h2v2h-2v-2z" fill="currentColor"/></svg></div>
                <span>Elektromobilių įkrovimo stotelės</span>
              </a>
              <a href="/paslaugos/energijos-kaupikliai/" class="header-mega__card">
                <div class="header-mega__icon"><svg viewBox="0 0 24 24" fill="none"><path d="M15.67 4H14V2h-4v2H8.33C7.6 4 7 4.6 7 5.33v15.33C7 21.4 7.6 22 8.33 22h7.33c.74 0 1.34-.6 1.34-1.33V5.33C17 4.6 16.4 4 15.67 4zm-2.67 9h-2v4H9v-4H7l4-6 4 6h-2z" fill="currentColor"/></svg></div>
                <span>Elektros kaupikliai namams ir verslui</span>
              </a>
              <a href="/paslaugos/projektavimas/" class="header-mega__card">
                <div class="header-mega__icon"><svg viewBox="0 0 24 24" fill="none"><path d="M19.14 12.94c.04-.3.06-.61.06-.94s-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.07.62-.07.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z" fill="currentColor"/></svg></div>
                <span>Saulės elektrinių projektavimas</span>
              </a>
              <a href="/paslaugos/prieziura/" class="header-mega__card">
                <div class="header-mega__icon"><svg viewBox="0 0 24 24" fill="none"><path d="M12 1c-4.97 0-9 4.03-9 9v7c0 1.1.9 2 2 2h1v-8H4v-1c0-3.87 3.13-7 7-7s7 3.13 7 7v1h-2v8h1c1.1 0 2-.9 2-2v-7c0-4.97-4.03-9-9-9z" fill="currentColor"/></svg></div>
                <span>Saulės elektrinių priežiūra (O&amp;M)</span>
              </a>
            </div>
          </div>
        </li>

        {{-- Įranga --}}
        @php $iranga = header_find($nav_items, 'ranga'); $iranga_sub = $iranga ? header_children($nav_items, $iranga->ID) : []; @endphp
        <li class="header-nav__item {{ $iranga_sub ? 'header-nav__item--dropdown' : '' }}">
          <a href="{{ $iranga ? esc_url($iranga->url) : '/iranga/' }}" class="header-nav__link">
            Įranga
            @if($iranga_sub)<svg class="header-nav__chevron" viewBox="0 0 12 7" fill="none"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>@endif
          </a>
          @if($iranga_sub)
            <ul class="header-nav__dropdown">
              @foreach($iranga_sub as $child)
                <li><a href="{{ esc_url($child->url) }}">{{ $child->title }}</a></li>
              @endforeach
            </ul>
          @endif
        </li>

        {{-- Parama --}}
        @php $parama = header_find($nav_items, 'arama'); $parama_sub = $parama ? header_children($nav_items, $parama->ID) : []; @endphp
        <li class="header-nav__item {{ $parama_sub ? 'header-nav__item--dropdown' : '' }}">
          <a href="{{ $parama ? esc_url($parama->url) : '/parama/' }}" class="header-nav__link">
            Parama
            @if($parama_sub)<svg class="header-nav__chevron" viewBox="0 0 12 7" fill="none"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>@endif
          </a>
          @if($parama_sub)
            <ul class="header-nav__dropdown">
              @foreach($parama_sub as $child)
                <li><a href="{{ esc_url($child->url) }}">{{ $child->title }}</a></li>
              @endforeach
            </ul>
          @endif
        </li>

        {{-- Apie mus --}}
        <li class="header-nav__item">
          <a href="/apie-mus/" class="header-nav__link">Apie mus</a>
        </li>

      </ul>
    </nav>

    {{-- CTA buttons --}}
    <div class="header-actions">
      @if(get_field('header_form_button', 'option'))
        @php $linkHeaderButton = get_field('header_form_button', 'options'); @endphp
        <a class="header-btn header-btn--red"
           href="{{ esc_url($linkHeaderButton['url']) }}"
           target="{{ $linkHeaderButton['target'] }}">
          {{ $linkHeaderButton['title'] }}<i></i>
        </a>
      @endif
      @if(get_field('header_offer_button', 'option'))
        <div class="header-btn header-btn--purple {{ (is_singular('product') || is_singular('donation')) ? 'getMainOfferHeader' : '' }}"
          @if(! is_singular('product') && ! is_singular('donation'))
            id="getOffer"
            data-toggle="modal"
            data-target="#offerModal"
          @endif>
          {!! get_field('header_offer_button', 'option') !!}<i></i>
        </div>
      @endif
    </div>

    {{-- Mobile burger --}}
    <button class="header-burger" id="headerBurger" aria-label="Navigacija">
      <span></span><span></span><span></span>
    </button>

  </div>

  {{-- Mobile nav --}}
  <div class="header-mobile-nav" id="headerMobileNav">
    <ul class="header-mobile-nav__list">
      <li><a href="{{ get_post_type_archive_link('projects') ?: '/igyvendinti-projektai/' }}">Įgyvendinti projektai</a></li>
      <li class="header-mobile-nav__item--expand">
        <button class="header-mobile-nav__toggle">
          Paslaugos
          <svg viewBox="0 0 12 7" fill="none"><path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </button>
        <ul class="header-mobile-nav__sub">
          <li><a href="/paslaugos/saules-elektrines-verslui/">Saulės elektrinės verslui</a></li>
          <li><a href="/paslaugos/saules-elektrines-namams/">Saulės elektrinės namams</a></li>
          <li><a href="/paslaugos/elektromobiliu-ikrovimo-stoteles/">Elektromobilių įkrovimo stotelės</a></li>
          <li><a href="/paslaugos/energijos-kaupikliai/">Elektros kaupikliai namams ir verslui</a></li>
          <li><a href="/paslaugos/projektavimas/">Saulės elektrinių projektavimas</a></li>
          <li><a href="/paslaugos/prieziura/">Saulės elektrinių priežiūra (O&amp;M)</a></li>
        </ul>
      </li>
      <li><a href="/iranga/">Įranga</a></li>
      <li><a href="/parama/">Parama</a></li>
      <li><a href="/apie-mus/">Apie mus</a></li>
    </ul>
    <div class="header-mobile-nav__actions">
      @if(get_field('header_form_button', 'option'))
        @php $linkHeaderButton = get_field('header_form_button', 'options'); @endphp
        <a class="header-btn header-btn--red header-btn--full" href="{{ esc_url($linkHeaderButton['url']) }}">
          {{ $linkHeaderButton['title'] }}<i></i>
        </a>
      @endif
      @if(get_field('header_offer_button', 'option'))
        <div class="header-btn header-btn--purple header-btn--full"
          data-toggle="modal" data-target="#offerModal">
          {!! get_field('header_offer_button', 'option') !!}<i></i>
        </div>
      @endif
    </div>
  </div>
</header>
<div class="header-blur" id="headerBlur"></div>
