<?php

if ($args['postNo']) {
  $projectCounter = $args['postNo'];
}

?>
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
