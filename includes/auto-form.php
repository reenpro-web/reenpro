<?php if (get_field('contact_car_form', 'options')) { ?>

  <div class="form-section bg-purple pt-80 pb-80" id="mainForm">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-12  col-lg-5 col-xl-4 offset-xl-1 mb-30 mb-lg-0">
          <?php if (get_field('contact_car_title', 'options')) { ?>
            <div class="form-section__heading mb-60 c-white h3">
              <?php the_field('contact_car_title', 'options'); ?>
            </div>
          <?php } ?>
          <?php if (get_field('contact_car_text', 'options')) { ?>
            <div class="form-section__text mb-20 c-white">
              <?php the_field('contact_car_text', 'options'); ?>
            </div>
          <?php } ?>
          <?php if (have_rows('global_contacts', 'options')) { ?>
            <div class="">
              <?php while (have_rows('global_contacts', 'options')) { ?>
                <?php the_row(); ?>
                <div
                  class="footer-info__details footer-info__details--black footer-info__details--<?php echo get_sub_field('info_type')['value'] ?> <?php echo get_sub_field('display') ? 'd-none' : '' ?>">
                  <?php the_sub_field('info', 'options'); ?>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
        <div class="col-12  col-lg-6  col-xl-6">
          <div class="contact-form mb-30">
            <?php echo do_shortcode(get_field('contact_car_form', 'options')) ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

