<?php $args = array(
  'post_type' => 'projects',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'orderby' => 'date',
  'order' => 'DESC',
);
$loop = new WP_Query($args); ?>
<?php if ($loop->have_posts()) { ?>

  <div class="projects-cards" id="mainProjecsSlider">
    <?php $projectCounter = 0; ?>
    <?php while ($loop->have_posts()) : $loop->the_post();
      if ($projectCounter >= 6) {
        $hiddenClass = 'd-none';
      }
      ?>
      <?php $terms = get_the_terms($post->ID, 'projects_category'); ?>
      <div
        class="projects-wrapper mb-50 mb-md-80 project-item cat-0 <?php foreach ($terms as $term) : echo ' cat-' . $term->term_id; endforeach ?> <?php echo $hiddenClass; ?>">
        <div class="row align-items-center">
          <div
            class="col-12 mb-20 mb-lg-0  <?php echo $projectCounter % 2 ? 'col-lg-6 order-lg-1 ' : 'col-lg-6  order-lg-2 ' ?>">
            <div
              class="projects-card__slider <?php echo $projectCounter % 2 ? '' : 'projects-card__slider--right ' ?>">
              <?php
              $imageArrayProjects = get_field('project_gallery');
              foreach ($imageArrayProjects as $image_id_projects) { ?>
                <?php echo wp_get_attachment_image($image_id_projects, 'projects-cards') ?>
              <?php } ?>
            </div>
            <?php if (get_field('project_location') || get_field('project_power') || get_field('project_client')) { ?>
              <div
                class="projects-card__properties  d-md-none <?php echo $projectCounter % 2 ? '' : 'projects-card__properties--right' ?>">
                <div class="d-flex justify-content-start justify-content-sm-between">
                  <?php if (get_field('project_location')) { ?>
                    <div class="mr-40 mr-sm-0">
                      <div class="projects-card__properties-wrapping projects-card__properties-wrapping--location">
                        <div class="projects-card__properties-heading">Vieta:</div>
                        <div
                          class="projects-card__properties-item"> <?php echo get_field('project_location'); ?></div>
                      </div>
                    </div>
                  <?php } ?>
                  <?php if (get_field('project_power')) { ?>
                    <div class="">
                      <div class="projects-card__properties-wrapping projects-card__properties-wrapping--power">
                        <div class="projects-card__properties-heading">Galia:</div>
                        <div class="projects-card__properties-item"> <?php echo get_field('project_power'); ?></div>
                      </div>
                    </div>
                  <?php } ?>
                  <?php if (get_field('project_client')) { ?>
                    <div class="d-none d-sm-block">
                      <div class="projects-card__properties-wrapping projects-card__properties-wrapping--client">
                        <div class="projects-card__properties-heading">Įrengimo metai:</div>
                        <div class="projects-card__properties-item"> <?php echo get_field('project_client'); ?></div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>

          </div>
          <div
            class="col-12   <?php echo $projectCounter % 2 ? 'order-lg-2 col-lg-6 col-xl-4 ' : 'col-lg-5 col-xl-4  order-lg-1 offset-lg-1 offset-xl-2' ?>">
            <div class="<?php echo $projectCounter % 2 ? 'mr-lg-100' : 'ml-lg-100' ?>">
              <h4 class="mb-20 mb-md-10 fs-25"><?php the_title() ?></h4>
              <?php if (get_field('project_desc')) { ?>
                <div class="projects-card__desc mb-30">
                  <?php echo get_field('project_desc'); ?>
                </div>
              <?php } ?>
            </div>
            <?php if (get_field('project_location') || get_field('project_power') || get_field('project_client')) { ?>
              <div
                class="projects-card__properties d-none d-md-block <?php echo $projectCounter % 2 ? '' : 'projects-card__properties--right' ?>">
                <div class="d-flex justify-content-between">
                  <?php if (get_field('project_location')) { ?>
                    <div class="">
                      <div class="projects-card__properties-wrapping projects-card__properties-wrapping--location">
                        <div class="projects-card__properties-heading">Vieta:</div>
                        <div
                          class="projects-card__properties-item"> <?php echo get_field('project_location'); ?></div>
                      </div>
                    </div>
                  <?php } ?>
                  <?php if (get_field('project_power')) { ?>
                    <div class="">
                      <div class="projects-card__properties-wrapping projects-card__properties-wrapping--power">
                        <div class="projects-card__properties-heading">Galia:</div>
                        <div class="projects-card__properties-item"> <?php echo get_field('project_power'); ?></div>
                      </div>
                    </div>
                  <?php } ?>
                  <?php if (get_field('project_client')) { ?>
                    <div class="">
                      <div class="projects-card__properties-wrapping projects-card__properties-wrapping--client">
                        <div class="projects-card__properties-heading">Įrengimo metai:</div>
                        <div class="projects-card__properties-item"> <?php echo get_field('project_client'); ?></div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php $projectCounter++; endwhile;
    wp_reset_postdata(); ?>

  </div>

  <div class="text-center" id="loadMore">
    <div class="button button--wide d-block d-md-inline-block">
      <?php echo get_field('projects_intro_button', 'options') ? the_field('projects_intro_button', 'options') : 'Daugiau' ?>
      <i></i></div>
  </div>
<?php } ?>
