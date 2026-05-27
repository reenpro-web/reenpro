<?php
/* Template Name: Apie mus */
?>

<div class="about-intro d-flex">
  <div class="container  mt-auto mb-auto">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-xl-6  text-center">
        <h1 class="about-intro__heading c-white h3 mb-40 mb-md-30"><?php the_title() ?></h1>
        <?php if (get_field('about_intro_text')) { ?>
          <div class="about-intro__text fs-md-20 c-white"><?php the_field('about_intro_text'); ?></div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php if (have_rows('about_info_slider')) { ?>

  <div class="about-info pt-50 pt-md-120 pb-100 pb-md-160">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-5 offset-lg-1">
          <?php if (get_field('about_info_heading')) { ?>
            <h3 class="about-info__heading mb-50"><?php the_field('about_info_heading'); ?></h3>
          <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6 col-lg-5 offset-lg-1 mb-20 mb-md-0">
          <?php if (get_field('about_info_text')) { ?>
            <div class="about-info__text"><?php the_field('about_info_text'); ?></div>
          <?php } ?>
        </div>
        <div class="col-12 col-md-6 col-lg-5 col-xl-4 offset-lg-1 ">
          <div class="about-info__slider">
            <?php while (have_rows('about_info_slider')) { ?>
              <?php the_row(); ?>
              <div class="mb-30 mb-lg-50">
                <div class="d-flex justify-content-between align-items-center mb-15">
                  <div class="about-info__slider-heading mr-20 mr-md-0"><?php the_sub_field('heading'); ?></div>
                  <div class="about-info__slider-text"><?php the_sub_field('text'); ?></div>
                </div>
                <div class="about-info__slider-item">
                  <span
                    style="background-color: <?php the_sub_field('color'); ?>; width: <?php the_sub_field('number'); ?>%;"></span>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<?php get_template_part('includes/about-cards'); ?>



<?php $featured_projects = get_field('about_projects') ?>
<?php if ($featured_projects) { ?>
  <div
    class="home-projects pt-50 pt-md-120 mb-100 mb-md-160 <?php echo get_field('display_projects') ? 'd-none' : '' ?>">
    <div class="container">
      <div class="row mb-50 mb-md-80">
        <div class="col-12  col-xl-5 offset-xl-2">
          <div class="ml-lg-100 ">
            <?php if (get_field('about_projects_heading')) { ?>
              <h3
                class="projects-list__heading text-center text-lg-left  mb-20"><?php the_field('about_projects_heading'); ?></h3>
            <?php } ?>
            <?php if (get_field('about_projects_text')) { ?>
              <div
                class="projects-list__text text-center text-lg-left"><?php the_field('about_projects_text'); ?></div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php $projectCounter = 0; ?>
      <div class="projects-cards">
        <?php foreach ($featured_projects as $featured_project) { ?>
          <?php $postID = $featured_project->ID; ?>
          <div
            class="mb-50 mb-md-80 project-item cat-0">
            <div class="row align-items-center">
              <div
                class="col-12 mb-20 mb-lg-0  <?php echo $projectCounter % 2 ? 'col-lg-6 order-lg-1 ' : 'col-lg-6  order-lg-2 ' ?>">
                <div
                  class="projects-card__slider <?php echo $projectCounter % 2 ? '' : 'projects-card__slider--right ' ?>">
                  <?php
                  $imageArrayProjects = get_field('project_gallery', $postID);
                  foreach ($imageArrayProjects as $image_id_projects) { ?>
                    <div>
                      <div
                        class="projects-card__slider-img"><?php echo wp_get_attachment_image($image_id_projects, 'projects-cards') ?></div>
                    </div>
                  <?php } ?>
                </div>
                <?php if (get_field('project_location', $postID) || get_field('project_power', $postID) || get_field('project_client', $postID)) { ?>
                  <div
                    class="projects-card__properties d-md-none <?php echo $projectCounter % 2 ? '' : 'projects-card__properties--right' ?>">
                    <div class="d-flex justify-content-start justify-content-sm-between">
                      <?php if (get_field('project_location', $postID)) { ?>
                        <div class="mr-40 mr-sm-0">
                          <div class="projects-card__properties-wrapping projects-card__properties-wrapping--location">
                            <div class="projects-card__properties-heading">Vieta:</div>
                            <div
                              class="projects-card__properties-item"> <?php echo get_field('project_location', $postID); ?></div>
                          </div>
                        </div>
                      <?php } ?>
                      <?php if (get_field('project_power', $postID)) { ?>
                        <div class="">
                          <div class="projects-card__properties-wrapping projects-card__properties-wrapping--power">
                            <div class="projects-card__properties-heading">Galia:</div>
                            <div
                              class="projects-card__properties-item"> <?php echo get_field('project_power', $postID); ?></div>
                          </div>
                        </div>
                      <?php } ?>
                      <?php if (get_field('project_client', $postID)) { ?>
                        <div class="d-none d-sm-block">
                          <div class="projects-card__properties-wrapping projects-card__properties-wrapping--client">
                            <div class="projects-card__properties-heading">Įrengimo metai:</div>
                            <div
                              class="projects-card__properties-item"> <?php echo get_field('project_client', $postID); ?></div>
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
                  <h4 class="mb-20 mb-md-10 fs-25 mb-lg-30"><?php echo get_the_title($postID) ?></h4>
                  <?php if (get_field('project_desc', $postID)) { ?>
                    <div class="projects-card__desc mb-30">
                      <?php echo get_field('project_desc', $postID); ?>
                    </div>
                  <?php } ?>
                </div>
                <?php if (get_field('project_location', $postID) || get_field('project_power', $postID) || get_field('project_client', $postID)) { ?>
                  <div
                    class="projects-card__properties d-none d-md-block <?php echo $projectCounter % 2 ? '' : 'projects-card__properties--right' ?>">
                    <div class="d-flex justify-content-between">
                      <?php if (get_field('project_location', $postID)) { ?>
                        <div class="">
                          <div class="projects-card__properties-wrapping projects-card__properties-wrapping--location">
                            <div class="projects-card__properties-heading">Vieta:</div>
                            <div
                              class="projects-card__properties-item"> <?php echo get_field('project_location', $postID); ?></div>
                          </div>
                        </div>
                      <?php } ?>
                      <?php if (get_field('project_power', $postID)) { ?>
                        <div class="">
                          <div class="projects-card__properties-wrapping projects-card__properties-wrapping--power">
                            <div class="projects-card__properties-heading">Galia:</div>
                            <div
                              class="projects-card__properties-item"> <?php echo get_field('project_power', $postID); ?></div>
                          </div>
                        </div>
                      <?php } ?>
                      <?php if (get_field('project_client', $postID)) { ?>
                        <div class="">
                          <div class="projects-card__properties-wrapping projects-card__properties-wrapping--client">
                            <div class="projects-card__properties-heading">Įrengimo metai:</div>
                            <div
                              class="projects-card__properties-item"> <?php echo get_field('project_client', $postID); ?></div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>

            <?php $projectCounter++; ?>
          </div>
        <?php } ?>
      </div>
      <?php wp_reset_postdata(); ?>
      <?php if (get_field('about_projects_button')) { ?>
        <div class="text-center">
          <a class="button button--wide d-block d-md-inline-block"
             href="<?php echo get_post_type_archive_link('projects'); ?>"><?php the_field('about_projects_button'); ?>
            <i></i></a>
        </div>
      <?php } ?>
    </div>
  </div>
<?php } ?>




<?php get_template_part('includes/global-logos'); ?>

<?php get_template_part('includes/main-form'); ?>


<style>
  @media only screen and (max-width: 768px) {
    .about-intro {
    <?php if (get_field('about_intro_img_mobile'))  { ?> background-image: url(<?php echo wp_get_attachment_image_url(get_field('about_intro_img_mobile'), 'full') ?>);
    <?php } else { ?> background-image: url(<?php echo wp_get_attachment_image_url(get_field('about_intro_img'), 'full') ?>);
    <?php } ?>
    }
  }

  @media only screen and (min-width: 769px) {
    .about-intro {
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('about_intro_img'), 'full') ?>);
    }
</style>
