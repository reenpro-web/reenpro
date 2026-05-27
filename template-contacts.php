<?php
/* Template Name: Kontaktai */
?>


<div class="contacts-intro d-flex">
  <div class="container mt-auto mb-auto">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-xl-7 mb-20 mb-lg-30">
        <h1 class="contacts-intro__heading c-white h3 mb-30 text-center"><?php the_title() ?></h1>
        <?php if (have_rows('global_contacts', 'options')) { ?>
          <div class="d-flex flex-column flex-lg-row justify-content-center no-gutters align-items-lg-center">
            <?php while (have_rows('global_contacts', 'options')) { ?>
              <?php the_row(); ?>
              <div class="flex-grow-0 mb-20 mb-lg-0 d-flex justify-content-center">
                <div
                  class="contacts-info__details contacts-info__details--<?php echo get_sub_field('info_type')['value'] ?>">
                  <?php the_sub_field('info', 'options'); ?>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
      <div class="col-12 col-md-10 col-xl-6 text-lg-center">
        <?php if (have_rows('company_info')) { ?>
          <div class="contacts-company text-center">
            <?php while (have_rows('company_info')) { ?>
              <?php the_row(); ?>
              <div class="contacts-company__item">
                <?php the_sub_field('title'); ?><span>&nbsp;<?php the_sub_field('info'); ?></span>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php if (have_rows('contacts_cards')) { ?>

  <div class="contacts-cards mt-50 mt-md-120 mb-60  mb-lg-50">
    <div class="container">
      <div class="row">
        <?php if (get_field('contacts_cards_heading')) { ?>
          <div class="col-12 text-center">
            <h3 class="contacts-cards__heading mb-50 mb-md-85"><?php the_field('contacts_cards_heading'); ?></h3>
          </div>
        <?php } ?>
      </div>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-11 text-center">
          <div class="row custom-row justify-content-center">
            <?php while (have_rows('contacts_cards')) { ?>
              <?php the_row(); ?>
              <div class="col-12 col-md-6 col-lg-4 custom-column mb-30 mb-lg-100">
                <div class="contacts-card h-100">
                  <div class="d-flex flex-column h-100">
                    <?php if (get_sub_field('name')) { ?>
                      <h4 class="contacts-card__name mb-30">
                        <?php the_sub_field('name'); ?>
                      </h4>
                    <?php } ?>
                    <?php if (get_sub_field('status') || get_sub_field('job_field')) { ?>
                      <div class="mb-20">
                        <?php if (get_sub_field('status')) { ?>
                          <div class="contacts-card__status">
                            <?php the_sub_field('status'); ?>
                          </div>
                        <?php } ?>
                        <?php if (get_sub_field('job_field')) { ?>
                          <div class="contacts-card__job">
                            <?php the_sub_field('job_field'); ?>
                          </div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                    <div class="mt-auto">
                      <?php if (get_sub_field('tel')) { ?>
                        <div class="contacts-card__tel mb-20">
                          <a href="tel:<?php the_sub_field('tel'); ?>"><?php the_sub_field('tel'); ?></a>
                        </div>
                        <br>
                      <?php } ?>
                      <?php if (get_sub_field('email')) { ?>
                        <div class="contacts-card__mail">
                          <a href="mailto:<?php the_sub_field('email'); ?>"> <?php the_sub_field('email'); ?></a>
                        </div>
                        <br>
                      <?php } ?>
                      <?php $contactButton = get_sub_field('link'); ?>
                      <?php if ($contactButton) { ?>
                        <div class="mb-20">
                          <a class="w-100 button button--wide"
                             href="<?php echo $contactButton['url']; ?>"
                             target="<?php echo $contactButton['target']; ?>">
                            <?php echo $contactButton['title']; ?><i></i>
                          </a>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<?php get_template_part('includes/main-form'); ?>


<style>
  @media only screen and (max-width: 768px) {
    .contacts-intro {
    <?php if (get_field('contacts_image_mobile'))  { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('contacts_image_mobile'), 'full') ?>);
    <?php } else { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('contacts_image'), 'full') ?>);
    <?php } ?>
    }
  }

  @media only screen and (min-width: 769px) {
    .contacts-intro {
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('contacts_image'), 'full') ?>);
    }
</style>
