<?php
/* Template Name: Karjera */
?>

<div class="career-intro d-flex mb-60 mb-lg-120">
  <div class="container mt-auto mb-auto">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-xl-5 mb-20 mb-lg-30">
        <h1 class="career-intro__heading c-white h3 mb-30 text-center"><?php the_title() ?></h1>
        <?php if (get_field('intro_text')) { ?>
          <div class="career-intro__text text-center c-white fs-20">
            <?php the_field('intro_text'); ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<div class="career-info mb-60 mb-lg-120">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-6 order-2 order-lg-1">
        <?php if (get_field('career_info_img')) { ?>
          <div class="mb-20 career-info__img">
            <?php echo wp_get_attachment_image(get_field('career_info_img'), 'full') ?>
          </div>
        <?php } ?>
      </div>
      <div class="col-12 col-lg-6 pl-lg-30  pl-xxl-165 order-1 order-lg-2 mb-20 mb-lg-0">
        <?php if (get_field('career_info_heading')) { ?>
          <h3 class="career-info__heading mb-50"><?php the_field('career_info_heading'); ?></h3>
        <?php } ?>
        <?php if (get_field('career_info_text')) { ?>
          <div class="career-info__text"><?php the_field('career_info_text'); ?></div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php if (have_rows('jobs')) { ?>
  <div class="career">
    <div class="job mb-50 mb-lg-110">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-10 col-xxl-8 text-center">
            <?php if (get_field('jobs_heading')) { ?>
              <h3 class="career-info__heading mb-50 mb-xl-80"><?php the_field('jobs_heading'); ?></h3>
            <?php } ?>

            <?php $i = 1; ?>
            <div id="job-accordion" class="">
              <?php while (have_rows('jobs')) { ?>
                <?php the_row(); ?>
                <div class="job-card <?php echo get_sub_field('display_job') ? 'd-none' : '' ?>"
                     itemscope
                     itemprop="mainEntity"
                     itemtype="https://schema.org/Question">
                  <div id="question-<?php echo $i; ?>">
                    <div class="job-card__heading fw-bold job-card__heading-icon collapsed "
                         data-toggle="collapse"
                         data-target="#collapse-<?php echo $i; ?>"
                         aria-expanded="true"
                         aria-controls="collapse-<?php echo $i; ?>"
                         itemprop="name">
                      <div class="d-flex">
                        <div class="flex-grow-0 mr-10 mr-xl-30 job-card__icon">
                          <?php if (get_field('job_icon')) { ?>
                            <?php echo wp_get_attachment_image(get_field('job_icon'), 'full') ?>
                          <?php } ?>
                        </div>
                        <div>
                          <div class="mb-10 text-left">
                            <?php the_sub_field('title'); ?>
                          </div>
                          <div class="job-card__location text-left">
                            <?php the_sub_field('location'); ?>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div id="collapse-<?php echo $i; ?>"
                       class="collapse"
                       aria-labelledby="question-<?php echo $i; ?>"
                       data-parent="#job-accordion"
                       itemscope itemprop="acceptedAnswer"
                       itemtype="https://schema.org/Answer">
                    <div class="job-card__content job-card__content--link text-left"
                         itemprop="text">
                      <?php the_sub_field('desc'); ?>
                    </div>
                  </div>
                </div>
                <?php $i++;
              } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<?php get_template_part('includes/main-form'); ?>


<style>
  @media only screen and (max-width: 768px) {
    .career-intro {
    <?php if (get_field('contacts_image_mobile'))  { ?> background-image: url(<?php echo wp_get_attachment_image_url(get_field('career_image_mobile'), 'full') ?>);
    <?php } else { ?> background-image: url(<?php echo wp_get_attachment_image_url(get_field('career_image'), 'full') ?>);
    <?php } ?>
    }
  }

  @media only screen and (min-width: 769px) {
    .career-intro {
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('career_image'), 'full') ?>);
    }
</style>
