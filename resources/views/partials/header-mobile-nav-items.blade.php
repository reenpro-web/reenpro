@foreach($items as $item)
  @php
    $url   = esc_url($item->url ?? '#');
    $title = wp_strip_all_tags($item->title ?? '');
    $tag   = ! empty($item->ID)
      ? (get_field('menu_tag', $item) ?: '')
      : ($item->menu_tag ?? '');
    if (! $tag && ! empty($item->description)) {
      $tag = wp_strip_all_tags($item->description);
    }
    $icon  = ! empty($item->ID) ? get_field('menu_img', $item) : null;
  @endphp
  <a href="{{ $url }}" class="header-mobile-nav__item">
    @if($icon)
      <span class="header-mobile-nav__icon">
        <img src="{{ esc_url($icon) }}" alt="" loading="lazy">
      </span>
    @endif
    <span class="header-mobile-nav__text">
      <span class="header-mobile-nav__item-title">{!! \App\theme_esc_text($title) !!}</span>
      @if($tag)
        <span class="header-mobile-nav__tag">{!! \App\theme_esc_text($tag) !!}</span>
      @endif
    </span>
  </a>
@endforeach
