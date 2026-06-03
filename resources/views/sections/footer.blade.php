@include('partials.button')

<footer class="footer pt-60 pb-55 pt-lg-130 pb-lg-80">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6 col-lg-3 text-left mb-20 mb-lg-0 order-1">
        <div class="align-self-center footer-logo mb-30">
          <a href="{{ esc_url(home_url('/')) }}" target="_self">
            {!! wp_get_attachment_image(get_field('logo', 'option'), 'full') !!}
          </a>
        </div>
        <div class="d-none d-md-block">
          @if(get_field('footer_text', 'options'))
            <div class="mb-30">{!! get_field('footer_text', 'options') !!}</div>
          @endif
          @if(get_field('footer__cert', 'options'))
            <div class="mb-40 mb-lg-0">
              <div class="footer-icon d-inline-block mr-10">
                {!! wp_get_attachment_image(get_field('footer__cert', 'options'), 'full') !!}
              </div>
            </div>
          @endif
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3 col-xl-2 offset-xl-1 order-3 order-lg-2">
        @if(has_nav_menu('footer_1'))
          {!! wp_nav_menu(['theme_location' => 'footer_1', 'menu_class' => '', 'container_class' => 'footer-menu', 'echo' => false]) !!}
        @endif
      </div>

      <div class="col-12 col-md-6 col-lg-3 col-xl-2 mb-60 mb-lg-0 order-4 order-lg-3">
        @if(has_nav_menu('footer_2'))
          {!! wp_nav_menu(['theme_location' => 'footer_2', 'menu_class' => '', 'container_class' => 'footer-menu', 'echo' => false]) !!}
        @endif
      </div>

      <div class="col-12 col-md-6 col-lg-3 offset-xl-1 order-4 order-md-2 order-lg-4">
        @if(have_rows('global_contacts', 'options'))
          <div class="mb-40 mb-md-40">
            @while(have_rows('global_contacts', 'options')) @php(the_row())
              <div class="footer-info__details footer-info__details--{{ get_sub_field('info_type')['value'] }}">
                {!! get_sub_field('info', 'options') !!}
              </div>
            @endwhile
          </div>
        @endif
        @if(have_rows('footer_socials', 'options'))
          <div class="mb-40 mb-lg-0">
            @while(have_rows('footer_socials', 'options')) @php(the_row())
              <a class="footer-socials__link" href="{{ get_sub_field('link') }}" target="_blank">
                {!! wp_get_attachment_image(get_sub_field('icon', 'options'), 'full') !!}
              </a>
            @endwhile
          </div>
        @endif
        <div class="d-md-none">
          @if(get_field('footer_text', 'options'))
            <div class="mb-30">{!! get_field('footer_text', 'options') !!}</div>
          @endif
          @if(get_field('footer__cert', 'options'))
            <div class="mb-40 mb-lg-0">
              <div class="footer-icon d-inline-block mr-10">
                {!! wp_get_attachment_image(get_field('footer__cert', 'options'), 'full') !!}
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</footer>
