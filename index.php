<?php
/* Template Name: Titulinis puslapis */
?>
<div class="home-slider">
  <div class="home-banner">
    <?php if (have_rows('index_intro_banner')) { ?>
      <?php $i = 0; ?>
      <?php while (have_rows('index_intro_banner')) { ?>
        <?php the_row(); ?>
        <div class="home-intro d-flex bg--<?php echo $i; ?>">
          <div class="container mt-auto mb-auto">
            <div class="row align-items-center justify-content-lg-between">
              <div class="col-12 col-md-10 col-lg-8 col-xxl-6">
                <?php if (get_sub_field('index_intro_heading')) { ?>
				  <?php if ($i == 0) {?>
				  <h1 class="home-intro__heading mb-24 h1">
                    <?php the_sub_field('index_intro_heading'); ?>
                  </h1>
				  <?php } else { ?>
				  <h2 class="home-intro__heading mb-24 h1">
                    <?php the_sub_field('index_intro_heading'); ?>
                  </h2>
				  <?php } ?>
                <?php } ?>
                <?php if (get_sub_field('index_intro_heading')) { ?>
                  <div class="home-intro__text c-white mb-30">
                    <?php the_sub_field('index_intro_text'); ?>
                  </div>
                <?php } ?>
                <?php if (get_field('get_offer_text', 'options')) { ?>
                  <div>
				    <?php if (get_sub_field("index_intro_cta_url")) { ?>
					  <a href="<?php echo esc_attr( get_sub_field('index_intro_cta_url') ); ?>" class="button button--wide d-block d-md-inline-block"><?php the_field('get_offer_text', 'options'); ?><i></i></a>
					<?php } else { ?>
					  <a href = "#mainForm" class="button button--wide d-block d-md-inline-block"><?php the_field('get_offer_text', 'options'); ?><i></i></a>
				    <?php } ?>
                  </div>
                <?php } ?>
              </div>
              <div class="col-12 col-md-2 col-xl-5">
              </div>
            </div>
          </div>
        </div>
      <?php $i++; } ?>
    <?php } ?>
  </div>
  <div class="home-slider__dots">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-10 col-xl-7">
        </div>
        <div class="col-12 col-md-2 col-xl-5 text-right">
          <div class="slick-slide__nav"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="home-numbers pt-50 pt-md-120 pb-50 pb-md-160">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-6 col-xl-5 col-xl-4 text-center">
        <?php if (get_field('index_number_heading')) { ?>
          <h3 class="home-numbers__heading mb-50">
            <?php the_field('index_number_heading'); ?>
          </h3>
        <?php } ?>
      </div>
    </div>

    <?php if (have_rows('index_numbers')) { ?>
      <div class="row align-items-center">
        <?php while (have_rows('index_numbers')) { ?>
          <?php the_row(); ?>
          <div class="col-12 col-md-6 col-xl-3 text-center text-md-left">
            <div class="home-numbers__item d-flex align-items-center justify-content-center">
              <div class="home-numbers__item-number mr-20"><?php the_sub_field('number'); ?></div>
              <div class="home-numbers__item-text fw-bold"><?php the_sub_field('text'); ?></div>
            </div>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
</div>

<div class="home-info">
  <div class="container">
    <div class="row custom-row justify-content-center">
      <div class="col-12 col-xl-10 custom-column">
        <?php if (have_rows('index_info_cards')) { ?>
          <div class="row custom-row home-info__wrapper">
            <?php while (have_rows('index_info_cards')) { ?>
              <?php the_row(); ?>
              <div class="col-12 col-lg-4 text-center custom-column">
                <div class="home-info__item mb-50 mb-lg-0">
                  <svg class="mb-25 d-none d-lg-inline" xmlns="http://www.w3.org/2000/svg" width="8" height="128.433"
                       viewBox="0 0 8 128.433">
                    <g id="Group_244" data-name="Group 244" transform="translate(-493 -1449)">
                      <g id="Ellipse_265" data-name="Ellipse 265" transform="translate(493 1449)" fill="#fff"
                         stroke="#12122d" stroke-width="2">
                        <circle cx="4" cy="4" r="4" stroke="none"/>
                        <circle cx="4" cy="4" r="3" fill="none"/>
                      </g>
                      <path id="Path_77" data-name="Path 77" d="M429.948,1287v120.433" transform="translate(67 170)"
                            fill="none" stroke="#12122d" stroke-width="2"/>
                    </g>
                  </svg>
                  <div class="mb-20">
                    <?php echo wp_get_attachment_image(get_sub_field('icon'), 'full') ?>

                  </div>
                  <h4 class="mb-20 mb-md-25"><?php the_sub_field('heading'); ?></h4>
                  <div><?php the_sub_field('text'); ?></div>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php $featured_projects = get_field('index_projects') ?>
<?php if ($featured_projects) { ?>

  <div class="home-projects pt-50 pt-md-120 mb-100 mb-md-160 <?php echo get_field('display_projects') ? 'd-none' : '' ?>"">
    <div class="container">
      <div class="row mb-50 mb-md-80">
        <div class="col-12  col-xl-5 offset-xl-2">
          <div class="ml-lg-100 ">
            <?php if (get_field('index_projects_heading')) { ?>
              <h3
                class="projects-list__heading text-center text-lg-left  mb-20"><?php the_field('index_projects_heading'); ?></h3>
            <?php } ?>
            <?php if (get_field('index_projects_text')) { ?>
              <div
                class="projects-list__text text-center text-lg-left"><?php the_field('index_projects_text'); ?></div>
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
      <?php if (get_field('index_projects_button')) { ?>
        <div class="text-center">
          <a class="button button--wide d-block d-md-inline-block"
             href="<?php echo get_post_type_archive_link('projects'); ?>"><?php the_field('index_projects_button'); ?>
            <i></i></a>
        </div>
      <?php } ?>
    </div>
  </div>
<?php } ?>
		
<?php get_template_part('includes/about-cards'); ?>

<div class="home-donation pt-50 pt-md-120 pb-80 pb-md-140">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">
        <h3 class="home-donation__heading c-white"><?php the_field('index_donation_heading'); ?></h3>
        <div class="home-donation__text c-white mb-50"><?php the_field('index_donation_text'); ?></div>
        <?php if (have_rows('index_donation_buttons')) { ?>
          <?php while (have_rows('index_donation_buttons')) { ?>
            <?php the_row(); ?>
            <?php $linkHomeButtons = get_sub_field('link'); ?>
            <div class="home-donation__link d-md-inline-block">
              <a class=" button button--wide d-block "
                 href="<?php echo $linkHomeButtons['url']; ?>"
                 target="<?php echo $linkHomeButtons['target']; ?>">
                <?php echo $linkHomeButtons['title']; ?><i></i>
              </a>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php get_template_part('includes/global-logos'); ?>
<?php get_template_part('includes/main-form'); ?>
<?php get_template_part('includes/blog-news-section'); ?>
<?php if (have_rows('index_logos')) { ?>
  <div class="home-logos pt-50 pb-50 pt-lg-110 pb-lg-110">
    <div class="container">
      <div class="home-logos__slider">
        <?php while (have_rows('index_logos')) { ?>@
          <?php the_row(); ?>
          <div class="pl-10 pr-10 pl-lg-25 pr-lg-25 text-center home-clients__slider-slide">
            <?php echo wp_get_attachment_image(get_sub_field('logo'), 'home_logos') ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
<?php } ?>


<style>
  <?php if (have_rows('index_intro_banner')): ?>
  <?php $i = 0; ?>
  <?php while (have_rows('index_intro_banner')): the_row(); ?>
  .bg--<?php echo $i;?> {
    background-image: url(<?php echo wp_get_attachment_image_url(get_sub_field('index_intro_image'), 'full') ?>);

    /*background-image: linear-gradient(90.22deg, #852A48 0.16%, rgba(133, 42, 72, 0) 54.37%, rgba(133, 42, 72, 0) 95.11%),*/
    /*url(*/<?php //echo wp_get_attachment_image_url(get_sub_field('img'), 'full') ?>/*);*/
  }



  @media only screen and (max-width: 768px) {
    .bg--<?php echo $i;?> {

    <?php if (get_sub_field('index_intro_image_mobile'))  { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_sub_field('index_intro_image_mobile'), 'full') ?>);
    <?php } else { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_sub_field('index_intro_image'), 'full') ?>);


      /*  background-image: linear-gradient(90.22deg, #852A48 0.16%, rgba(133, 42, 72, 0) 54.37%, rgba(133, 42, 72, 0) 95.11%),*/
      /*  url(*/<?php //echo wp_get_attachment_image_url(get_sub_field('img_mobile'), 'full') ?>/*);*/
    <?php //} else { ?>
      /*  background-image: linear-gradient(90.22deg, #852A48 0.16%, rgba(133, 42, 72, 0) 54.37%, rgba(133, 42, 72, 0) 95.11%),*/
      /*  url(*/<?php //echo wp_get_attachment_image_url(get_sub_field('img'), 'full') ?>/*);*/


    <?php } ?>

    }
  }


  <?php $i++; endwhile; ?>
  <?php endif; ?>
  @media only screen and (max-width: 768px) {
    .home-info {
    <?php if (get_field('index_info_image_mobile'))  { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('index_info_image_mobile'), 'full') ?>);
    <?php } else { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('index_info_image'), 'full') ?>);
    <?php } ?>
    }


    .home-donation {
    <?php if (get_field('index_donation_image_mobile'))  { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('index_donation_image_mobile'), 'full') ?>);
    <?php } else { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('index_donation_image'), 'full') ?>);
    <?php } ?>
    }

  }

  @media only screen and (min-width: 769px) {

    .home-info {
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('index_info_image'), 'full') ?>);
    }

    .home-donation {
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('index_donation_image'), 'full') ?>);
    }
  }

</style>
