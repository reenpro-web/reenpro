@if(have_rows('global_logos', 'options'))
  <div class="about-logos pt-50 pt-md-120 pb-50 pb-md-120 {{ get_field('display_logos') ? 'd-none' : '' }}">
    <div class="container container--no-right">
      <div class="row justify-content-center">
        @if(get_field('logos_heading', 'options'))
          <div class="col-12 col-md-6 text-center">
            <h3 class="about-reviews__heading mb-50 mb-lg-80">{{ get_field('logos_heading', 'options') }}</h3>
          </div>
        @endif
        <div class="col-12">
          <div class="about-logos__slider">
            @while(have_rows('global_logos', 'options')) @php(the_row())
              <div class="text-center about-logos__slider-slide">
                <div>{!! wp_get_attachment_image(get_sub_field('logo', 'options'), 'full') !!}</div>
                <div>
                  <div class="about-logos__slider-slide--power d-flex align-items-center">
                    <div class="flex-grow-1 mr-10">
                      <svg xmlns="http://www.w3.org/2000/svg" width="13.489" height="29.431">
                        <defs><clipPath id="clip-path"><path fill="none" stroke="#707070" stroke-width="1.3" d="M0 0h13.489v29.431H0z"/></clipPath></defs>
                        <g clip-path="url(#clip-path)">
                          <path d="M9.197.613L.613 17.781h6.131v11.032l6.131-14.715H6.744z" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3"/>
                        </g>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
            @endwhile
          </div>
        </div>
      </div>
    </div>
  </div>
@endif
