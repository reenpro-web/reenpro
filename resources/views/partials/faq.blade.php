<?php $i = 1; ?>
@if(have_rows('faq'))
  <div class="container">
    <div class="row justify-content-center mt-50 mt-md-120 mb-100 mb-md-155">
      @if(get_field('faq_heading'))
        <div class="col-12 col-md-10 col-xl-7 text-center">
          <h3 class="mb-40 mb-md-80">{{ get_field('faq_heading') }}</h3>
        </div>
      @endif
      <div class="col-12 col-md-10 col-xl-7">
        <div id="faq-accordion">
          @while(have_rows('faq')) <?php the_row(); ?>
            <div class="faq-card" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
              <div id="question-{{ $i }}">
                <div class="faq-card__heading fw-bold faq-card__heading-icon collapsed"
                     data-toggle="collapse"
                     data-target="#collapse-{{ $i }}"
                     aria-expanded="true"
                     aria-controls="collapse-{{ $i }}"
                     itemprop="name">
                  {!! get_sub_field('heading') !!}
                </div>
              </div>
              <div id="collapse-{{ $i }}"
                   class="collapse"
                   aria-labelledby="question-{{ $i }}"
                   data-parent="#faq-accordion"
                   itemscope itemprop="acceptedAnswer"
                   itemtype="https://schema.org/Answer">
                <div class="faq-card__content faq-card__content--link" itemprop="text">
                  {!! get_sub_field('text') !!}
                </div>
              </div>
            </div>
            <?php $i++; ?>
          @endwhile
        </div>
      </div>
    </div>
  </div>
@endif
