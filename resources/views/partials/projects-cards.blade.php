@php
  $projectsQuery = new WP_Query(['post_type' => 'projects', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC']);
  $projectCounter = 0;
  $hiddenClass = '';
@endphp
@if($projectsQuery->have_posts())
  <div class="projects-cards" id="mainProjecsSlider">
    @while($projectsQuery->have_posts()) <?php $projectsQuery->the_post(); ?>
      @php
        if ($projectCounter >= 6) $hiddenClass = 'd-none';
        $terms = get_the_terms(get_the_ID(), 'projects_category');
        $catClasses = '';
        if ($terms && !is_wp_error($terms)) {
          foreach ($terms as $term) $catClasses .= ' cat-' . $term->term_id;
        }
      @endphp
      <div class="projects-wrapper mb-50 mb-md-80 project-item cat-0{{ $catClasses }} {{ $hiddenClass }}">
        <div class="row align-items-center">
          <div class="col-12 mb-20 mb-lg-0 {{ $projectCounter % 2 ? 'col-lg-6 order-lg-1' : 'col-lg-6 order-lg-2' }}">
            <div class="projects-card__slider {{ $projectCounter % 2 ? '' : 'projects-card__slider--right' }}">
              <?php $imageArrayProjects = get_field('project_gallery'); ?>
              @foreach($imageArrayProjects as $image_id_projects)
                {!! wp_get_attachment_image($image_id_projects, 'projects-cards') !!}
              @endforeach
            </div>
            @if(get_field('project_location') || get_field('project_power') || get_field('project_client'))
              <div class="projects-card__properties d-md-none {{ $projectCounter % 2 ? '' : 'projects-card__properties--right' }}">
                <div class="d-flex justify-content-start justify-content-sm-between">
                  @if(get_field('project_location'))
                    <div class="mr-40 mr-sm-0">
                      <div class="projects-card__properties-wrapping projects-card__properties-wrapping--location">
                        <div class="projects-card__properties-heading">Vieta:</div>
                        <div class="projects-card__properties-item">{{ get_field('project_location') }}</div>
                      </div>
                    </div>
                  @endif
                  @if(get_field('project_power'))
                    <div>
                      <div class="projects-card__properties-wrapping projects-card__properties-wrapping--power">
                        <div class="projects-card__properties-heading">Galia:</div>
                        <div class="projects-card__properties-item">{{ get_field('project_power') }}</div>
                      </div>
                    </div>
                  @endif
                  @if(get_field('project_client'))
                    <div class="d-none d-sm-block">
                      <div class="projects-card__properties-wrapping projects-card__properties-wrapping--client">
                        <div class="projects-card__properties-heading">Įrengimo metai:</div>
                        <div class="projects-card__properties-item">{{ get_field('project_client') }}</div>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            @endif
          </div>
          <div class="col-12 {{ $projectCounter % 2 ? 'order-lg-2 col-lg-6 col-xl-4' : 'col-lg-5 col-xl-4 order-lg-1 offset-lg-1 offset-xl-2' }}">
            <div class="{{ $projectCounter % 2 ? 'mr-lg-100' : 'ml-lg-100' }}">
              <h4 class="mb-20 mb-md-10 fs-25">{!! \App\theme_esc_text(get_the_title()) !!}</h4>
              @if(get_field('project_desc'))
                <div class="projects-card__desc mb-30">{!! get_field('project_desc') !!}</div>
              @endif
            </div>
            @if(get_field('project_location') || get_field('project_power') || get_field('project_client'))
              <div class="projects-card__properties d-none d-md-block {{ $projectCounter % 2 ? '' : 'projects-card__properties--right' }}">
                <div class="d-flex justify-content-between">
                  @if(get_field('project_location'))
                    <div>
                      <div class="projects-card__properties-wrapping projects-card__properties-wrapping--location">
                        <div class="projects-card__properties-heading">Vieta:</div>
                        <div class="projects-card__properties-item">{{ get_field('project_location') }}</div>
                      </div>
                    </div>
                  @endif
                  @if(get_field('project_power'))
                    <div>
                      <div class="projects-card__properties-wrapping projects-card__properties-wrapping--power">
                        <div class="projects-card__properties-heading">Galia:</div>
                        <div class="projects-card__properties-item">{{ get_field('project_power') }}</div>
                      </div>
                    </div>
                  @endif
                  @if(get_field('project_client'))
                    <div>
                      <div class="projects-card__properties-wrapping projects-card__properties-wrapping--client">
                        <div class="projects-card__properties-heading">Įrengimo metai:</div>
                        <div class="projects-card__properties-item">{{ get_field('project_client') }}</div>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
      <?php $projectCounter++; ?>
    @endwhile
    <?php wp_reset_postdata(); ?>
  </div>

  <div class="text-center" id="loadMore">
    <div class="button button--wide d-block d-md-inline-block">
      {!! get_field('projects_intro_button', 'options') ?: 'Daugiau' !!} <i></i>
    </div>
  </div>
@endif
