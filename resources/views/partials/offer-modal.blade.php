<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>

@php
  $carArgs  = ['post_type' => 'cars', 'post_status' => 'publish', 'posts_per_page' => -1];
  $carLoop  = new WP_Query($carArgs);
  $carTerms = get_terms(['taxonomy' => 'car_category', 'hide_empty' => true]);
@endphp

@if($carLoop->have_posts())
  <select id="hiddenPostSelect" class="d-none">
    <option value="">Automobilio modelis</option>
    @while($carLoop->have_posts()) <?php $carLoop->the_post(); ?>
      <?php $terms = get_the_terms(get_the_ID(), 'car_category'); ?>
      <option value="{{ get_the_title() }}"
              data-id="@foreach($terms as $term){{ $term->term_id }}@endforeach">
        {{ get_field('car_title', get_the_ID()) ?: get_the_title() }}
      </option>
    @endwhile
    <?php wp_reset_postdata(); ?>
  </select>
@endif

<select id="hiddenTaxSelect" class="d-none">
  <option value="">Automobilio gamintojas</option>
  @foreach($carTerms as $term)
    <option value="{{ $term->name }}" data-id="{{ $term->term_id }}">{{ $term->name }}</option>
  @endforeach
</select>

@if(!is_singular('product') && !is_singular('donation'))
<div class="container">
  <div class="modal fade" id="offerModal">
    <div class="modal-header w-100">
      <button type="button" class="modal-header__button" data-dismiss="modal" aria-label="Close" id="leaveToggle">
        <svg xmlns="http://www.w3.org/2000/svg" width="20.193" height="20.193" viewBox="0 0 20.193 20.193">
          <g transform="translate(-1724.221 -58.586)">
            <path d="M13582.194,1704.432h24.557" transform="translate(-6673.211 -10749.276) rotate(45)" fill="none" stroke="#fff" stroke-width="4"/>
            <path d="M0,0H24.557" transform="translate(1742.999 60) rotate(135)" fill="none" stroke="#fff" stroke-width="4"/>
          </g>
        </svg>
      </button>
    </div>
    <div class="row justify-content-center mt-auto mb-auto h-100">
      <div class="col-12 col-md-10 col-lg-6">
        <div class="modal-dialog modal-dialog-centered modal-dialog--medium">
          <div class="modal-content modal-content--background">
            <div class="modal-body p-0 m-0">
              <div class="row justify-content-center" id="formButtons">
                <div class="col-12">
                  @if(get_field('modal_heading', 'option'))
                    <h3 class="c-white mb-30 mb-md-80 text-center">{!! get_field('modal_heading', 'option') !!}</h3>
                  @endif
                </div>
                <div class="col-12 col-md-4 mb-30 mb-md-0">
                  <div class="modal-column h-100" id="displaySolarForm">
                    <div class="c-white text-center">
                      <div class="mb-30">{!! wp_get_attachment_image(get_field('modal_solar_img', 'options'), 'home_logos') !!}</div>
                      <div class="c-black fs-18 mb-0 fw-bold">{!! get_field('modal_solar_heading', 'option') !!}</div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-4 mb-30 mb-md-0">
                  <div class="modal-column h-100" id="displayBessForm">
                    <div class="c-white text-center">
                      <div class="mb-30">{!! wp_get_attachment_image(get_field('modal_bess_img', 'options'), 'home_logos') !!}</div>
                      <div class="c-black fs-18 mb-0 fw-bold">{!! get_field('modal_bess_heading', 'option') !!}</div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-4">
                  <div class="modal-column h-100" id="displayCarForm">
                    <div class="c-white text-center">
                      <div class="mb-30">{!! wp_get_attachment_image(get_field('modal_car_img', 'options'), 'home_logos') !!}</div>
                      <div class="c-black fs-18 mb-0 fw-bold">{!! get_field('modal_car_heading', 'option') !!}</div>
                    </div>
                  </div>
                </div>
              </div>

              @if(get_field('contact_form', 'options'))
                <div id="solarForm" class="d-none">
                  <div class="contact-form contact-form--modal mb-30">
                    <h3 class="mb-40 mb-lg-50 contact-form__heading">
                      {!! get_field('contact_heading_main', 'options') ?: 'Užpildyk užklausą' !!}
                    </h3>
                    <div class="contact-tabs mb-10">
                      <div class="contact-tabs__list mb-15">
                        <ul class="nav nav-tabs" id="myTab-modal" role="tablist">
                          <li class="flex-shrink-0">
                            <a class="active modal" id="heading-personal-modal" data-toggle="tab" href="#tab-personal-modal" role="tab">
                              {!! get_field('contact_form_tab_personal', 'options') ?: 'Privatus klientas' !!}
                            </a>
                          </li>
                          @if(get_field('contact_form_business', 'options'))
                            <li class="flex-shrink-0">
                              <a class="modal" id="heading-business-modal" data-toggle="tab" href="#tab-business-modal" role="tab">
                                {!! get_field('contact_form_tab_business', 'options') ?: 'Verslo klientas' !!}
                              </a>
                            </li>
                          @endif
                        </ul>
                      </div>
                    </div>
                    <div class="contact-tabs">
                      <div class="contact-tabs__content pb-50 pb-md-0" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab-personal-modal" role="tabpanel">
                          {!! do_shortcode(get_field('contact_form', 'options')) !!}
                        </div>
                        @if(get_field('contact_form_business', 'options'))
                          <div class="tab-pane fade" id="tab-business-modal" role="tabpanel">
                            {!! do_shortcode(get_field('contact_form_business', 'options')) !!}
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              @endif

              @if(get_field('bess_contact_form', 'options'))
                <div id="bessFormInModal" class="d-none">
                  <div class="contact-form contact-form--modal mb-30">
                    <h3 class="mb-40 mb-lg-50 contact-form__heading">
                      {!! get_field('bess_contact_heading_main', 'options') ?: 'Užpildyk užklausą' !!}
                    </h3>
                    <div class="contact-tabs mb-10">
                      <div class="contact-tabs__list mb-15">
                        <ul class="nav nav-tabs" id="bessTab-modal" role="tablist">
                          <li class="flex-shrink-0">
                            <a class="active modal" id="heading-bess-personal-modal" data-toggle="tab" href="#tab-bess-personal-modal" role="tab">
                              {!! get_field('bess_contact_form_tab_personal', 'options') ?: 'Privatus klientas' !!}
                            </a>
                          </li>
                          @if(get_field('bess_contact_form_business', 'options'))
                            <li class="flex-shrink-0">
                              <a class="modal" id="heading-bess-business-modal" data-toggle="tab" href="#tab-bess-business-modal" role="tab">
                                {!! get_field('bess_contact_form_tab_business', 'options') ?: 'Verslo klientas' !!}
                              </a>
                            </li>
                          @endif
                        </ul>
                      </div>
                    </div>
                    <div class="contact-tabs">
                      <div class="contact-tabs__content pb-50 pb-md-0">
                        <div class="tab-pane fade show active" id="tab-bess-personal-modal" role="tabpanel">
                          {!! do_shortcode(get_field('bess_contact_form', 'options')) !!}
                        </div>
                        @if(get_field('bess_contact_form_business', 'options'))
                          <div class="tab-pane fade" id="tab-bess-business-modal" role="tabpanel">
                            {!! do_shortcode(get_field('bess_contact_form_business', 'options')) !!}
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              @endif

              @if(get_field('contact_car_form', 'options'))
                <div id="carForm" class="d-none car-form">
                  <div class="contact-form contact-form--modal mb-30">
                    @if(get_field('contact_car_heading_main', 'options'))
                      <h3 class="mb-40 mb-lg-50 contact-form__heading">
                        {!! get_field('contact_car_heading_main', 'options') !!}
                      </h3>
                    @endif
                    {!! do_shortcode(get_field('contact_car_form', 'options')) !!}
                  </div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
