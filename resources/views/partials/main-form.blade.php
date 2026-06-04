@if(get_field('contact_form', 'options'))
  <div class="form-section bg-purple pt-50 pt-md-80 pb-50 pb-md-80" id="mainForm">
    <div class="container" id="versloklientas">
      <div class="row align-items-center justify-content-center" id="privatusklientas">
        <div class="col-12 col-lg-5 col-xl-4 offset-xl-1 mb-30 mb-lg-0">
          @if(get_field('contact_title', 'options'))
            <div class="form-section__heading mb-20 mb-md-60 c-white h3">
              {!! get_field('contact_title', 'options') !!}
            </div>
          @endif
          @if(get_field('contact_text', 'options'))
            <div class="form-section__text mb-20 c-white">
              {!! get_field('contact_text', 'options') !!}
            </div>
          @endif
          @if(have_rows('global_contacts', 'options'))
            <div>
              @while(have_rows('global_contacts', 'options')) <?php the_row(); ?>
                <div class="footer-info__details footer-info__details--black footer-info__details--{{ get_sub_field('info_type')['value'] }} {{ get_sub_field('display') ? 'd-none' : '' }}">
                  {!! get_sub_field('info', 'options') !!}
                </div>
              @endwhile
            </div>
          @endif
        </div>
        <div class="col-12 col-lg-6 col-xl-6">
          <div class="contact-form mb-30">
            <h3 class="mb-40 mb-lg-50 contact-form__heading">
              {!! get_field('contact_heading_main', 'options') ?: 'Užpildyk užklausą' !!}
            </h3>
            <div class="contact-tabs mb-10">
              <div id="tabList">
                <div class="contact-tabs__list mb-15">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @if(get_field('contact_form', 'options'))
                      <li class="flex-shrink-0">
                        <a class="active" id="heading-personal" data-toggle="tab" href="#tab-personal" role="tab" aria-controls="tab-personal" aria-selected="true">
                          {!! get_field('contact_form_tab_personal', 'options') ?: 'Privatus klientas' !!}
                        </a>
                      </li>
                    @endif
                    @if(get_field('contact_form_business', 'options'))
                      <li class="flex-shrink-0">
                        <a class="" id="heading-business" data-toggle="tab" href="#tab-business" role="tab" aria-controls="tab-business" aria-selected="true">
                          {!! get_field('contact_form_tab_business', 'options') ?: 'Verslo klientas' !!}
                        </a>
                      </li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
            <div class="contact-tabs">
              <div id="tabAnswer">
                <div class="contact-tabs__content pb-50 pb-md-0" id="myTabContent">
                  @if(get_field('contact_form', 'options'))
                    <div class="tab-pane fade show active" id="tab-personal" role="tabpanel" aria-labelledby="heading-personal">
                      {!! do_shortcode(get_field('contact_form', 'options')) !!}
                    </div>
                  @endif
                  @if(get_field('contact_form_business', 'options'))
                    <div class="tab-pane fade" id="tab-business" role="tabpanel" aria-labelledby="heading-business">
                      {!! do_shortcode(get_field('contact_form_business', 'options')) !!}
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif
