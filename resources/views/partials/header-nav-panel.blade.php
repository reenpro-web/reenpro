@php
  $layout = $layout ?? 'single';
@endphp

<div class="header-panel header-panel--{{ $layout }}">
  <div class="header-panel__grid">
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
      <a href="{{ $url }}" class="header-panel__item">
        @if($icon)
          <div class="header-panel__icon">
            <img src="{{ esc_url($icon) }}" alt="" loading="lazy">
          </div>
        @endif
        <span class="header-panel__text">
          <span class="header-panel__title">{!! \App\theme_esc_text($title) !!}</span>
          @if($tag)
            <span class="header-panel__tag">{!! \App\theme_esc_text($tag) !!}</span>
          @endif
        </span>
      </a>
    @endforeach
  </div>
</div>
