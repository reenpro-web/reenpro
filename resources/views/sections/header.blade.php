<header class="header" id="header">
  <div class="container">
    <div class="row no-gutters align-items-center justify-content-between justify-content-lg-between">
      <div class="align-self-center header-logo pr-md-0">
        <a href="{{ esc_url(home_url('/')) }}" class="header-logo__white" target="_self">
          {!! wp_get_attachment_image(get_field('logo', 'option'), 'full') !!}
        </a>
        <a href="{{ esc_url(home_url('/')) }}" class="header-logo__color" target="_self">
          {!! wp_get_attachment_image(get_field('logo_color', 'option'), 'full') !!}
        </a>
      </div>
      <div class="header-wrapper d-flex align-items-center flex-grow-1" id="headerMenu">
        @if(has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'header-menu', 'after' => '<i class="sub-menu__arrow"></i> <i class="close-menu"></i> <span class="sub-menu__wrapper"> ', 'before' => '</span>', 'echo' => false]) !!}
        @endif

        <div class="header-buttons d-xl-flex">
          @if(get_field('header_form_button', 'option'))
            <?php $linkHeaderButton = get_field('header_form_button', 'options'); ?>
            <div class="header-button text-left pr-30 pr-xl-0 mr-xl-20 mb-20 mb-xl-0 pl-30 pl-xl-0 pl-lg-50 pr-lg-50">
              <div>
                <a class="button button--mid-wide d-block d-xl-inline-block"
                   href="{{ $linkHeaderButton['url'] }}"
                   target="{{ $linkHeaderButton['target'] }}">
                  {{ $linkHeaderButton['title'] }}<i></i>
                </a>
              </div>
            </div>
          @endif
          @if(get_field('header_offer_button', 'option'))
            <div class="header-button text-left pl-30 pr-30 pl-lg-50 pr-lg-50 pr-xl-0 pl-xl-0 mb-20 mb-xl-0">
              <div class="JS-SCROLL">
                <div class="button button--mid-wide button--purple d-block d-xl-inline-block {{ (is_singular('product') || is_singular('donation')) ? 'getMainOfferHeader' : '' }}"
                  @if(!is_singular('product') && !is_singular('donation'))
                    id="getOffer"
                    data-toggle="modal"
                    data-target="#offerModal"
                  @endif>
                  {!! get_field('header_offer_button', 'option') !!} <i></i>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
      <div class="d-xl-none">
        <div class="align-self-center text-right d-block header-burger d-xl-none" id="headerBurger">
          <div><span></span><span></span><span></span></div>
        </div>
      </div>
    </div>
  </div>
</header>
<div class="header-blur" id="headerBlur"></div>
