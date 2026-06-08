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

      function header_panel_item($url, $title, $description = '') {
        return (object) [
          'url'         => $url,
          'title'       => $title,
          'description' => $description,
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
          @foreach($paslaugos_sub as $item)
            <li><a href="{{ esc_url($item->url) }}">{{ wp_strip_all_tags($item->title) }}</a></li>
          @endforeach
        </ul>
      </li>
      <li><a href="{{ $iranga ? esc_url($iranga->url) : '/iranga/' }}">Įranga</a></li>
      <li><a href="{{ $parama ? esc_url($parama->url) : '/parama/' }}">Parama</a></li>
      <li><a href="{{ $apie ? esc_url($apie->url) : '/apie-mus/' }}">Apie mus</a></li>
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
