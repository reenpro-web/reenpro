@php($featured_projects = get_field('projects_object'))
@php($descClass = $descDisplay ?? '')
@if($featured_projects)
  <div class="donation-projects mb-100 mb-md-135">
    <div class="container">
      <div class="row justify-content-center">
        @if(get_field('projects_heading'))
          <div class="col-12 col-md-8 col-lg-6 text-center">
            <h2 class="donation-projects__heading mb-50 mb-md-85">{{ get_field('projects_heading') }}</h2>
          </div>
        @endif
      </div>
    </div>
    <div class="container container--no-right">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          <div class="donation-projects__cards">
            @foreach($featured_projects as $featured_project)
              @php($postID = $featured_project->ID)
              <div>
                <div class="full-img donation-projects__card-image mb-20 mb-md-30">
                  @if(get_the_post_thumbnail($postID))
                    {!! get_the_post_thumbnail($postID, 'projects-cards-small') !!}
                  @else
                    {!! wp_get_attachment_image(get_field('default_image_small_project', 'options'), 'projects-cards-small') !!}
                  @endif
                  <div class="donation-projects__card-text">
                    @if(get_field('project_location', $postID) || get_field('project_power', $postID))
                      <div class="donation-projects__card-properties">
                        <div class="d-flex justify-content-md-around">
                          @if(get_field('project_location', $postID))
                            <div class="mr-40 mr-md-0">
                              <div class="donation-projects__card-properties-wrapping donation-projects__card-properties-wrapping--location">
                                <div class="donation-projects__card-properties-heading">Vieta:</div>
                                <div class="donation-projects__card-properties-item">{{ get_field('project_location', $postID) }}</div>
                              </div>
                            </div>
                          @endif
                          @if(get_field('project_power', $postID))
                            <div>
                              <div class="donation-projects__card-properties-wrapping donation-projects__card-properties-wrapping--power">
                                <div class="donation-projects__card-properties-heading">Galia:</div>
                                <div class="donation-projects__card-properties-item">{{ get_field('project_power', $postID) }}</div>
                              </div>
                            </div>
                          @endif
                        </div>
                      </div>
                    @endif
                  </div>
                </div>
                <div class="{{ $descClass }}">
                  <h4 class="mb-10 mb-lg-30">{{ get_the_title($postID) }}</h4>
                  @if(get_field('project_desc', $postID))
                    <div class="projects-card__desc mb-30">{!! get_field('project_desc', $postID) !!}</div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
          @php(wp_reset_postdata())
        </div>
      </div>
    </div>
  </div>
@endif
