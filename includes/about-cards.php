<?php if (have_rows('about_cards', 'options')) { ?>

  <div class="about-cards bg-purple pt-120 pb-120">
    <div class="container container--no-right">
	  <?php if (get_field('about_cards_heading', 'options')) { ?>
          <div class="text-start mb-20 mb-lg-30">
            <h3 class="about-cards__heading c-white"><?php the_field('about_cards_heading', 'options'); ?></h3>
          </div>
      <?php } ?>
      <div class="about-cards__slider">
        <?php while (have_rows('about_cards', 'options')) { ?>
          <?php the_row(); ?>
          <?php if (get_sub_field('display_card')) { ?>
            <div class="about-card ">
              <div class="full-img about-card__image">
                <?php if (get_sub_field('video_check')) { ?>
                  <div class="about-video">
                    <video class="wi-video-player" width="100%" height="100%" loop muted webkit-playsinline playsinline
                           controlslist="nodownload" <?php if (get_sub_field('video_img')) { ?> poster="<?php the_sub_field('video_img'); ?> " <?php } ?>>
                      <source class="" src="<?php the_sub_field('video'); ?>" type="video/mp4">
                    </video>
                    <div class="about-video--wrapper bgVideo">
                      <?php if (get_sub_field('icon', 'options')) { ?>
                        <div class="mb-20">
                          <?php echo wp_get_attachment_image(get_sub_field('icon', 'options'), 'full') ?>
                        </div>
                      <?php } ?>

                      <?php if (get_sub_field('heading', 'options')) { ?>
                        <h5
                          class="c-white mb-20 about-card__text-heading">  <?php the_sub_field('heading', 'options') ?></h5>
                      <?php } ?>
                      <?php if (get_sub_field('text', 'options')) { ?>
                        <div class="c-white fs-13">  <?php the_sub_field('text', 'options') ?></div>
                      <?php } ?>
                    </div>
                    <button class="about-video--play playVideo">
                      <svg width="48" height="61" viewBox="0 0 48 61" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 61V0L48 30.5L0 61ZM5.63969 50.625L37.4726 30.5L5.63969 10.375V50.625Z"
                              fill="white"/>
                      </svg>
                    </button>
                  </div>
                <?php } else { ?>

                  <?php echo wp_get_attachment_image(get_sub_field('image', 'options'), 'about-cards-new') ?>
                <?php } ?>

                <?php if (get_sub_field('video_check')) { ?>
                <?php } else { ?>
                  <div class="about-card__text">
                    <?php if (get_sub_field('icon', 'options')) { ?>
                      <div class="mb-20">
                        <?php echo wp_get_attachment_image(get_sub_field('icon', 'options'), 'full') ?>
                      </div>
                    <?php } ?>

                    <?php if (get_sub_field('heading', 'options')) { ?>
                      <h5
                        class="c-white mb-20 about-card__text-heading">  <?php the_sub_field('heading', 'options') ?></h5>
                    <?php } ?>
                    <?php if (get_sub_field('text', 'options')) { ?>
                      <div class="c-white fs-13">  <?php the_sub_field('text', 'options') ?></div>
                    <?php } ?>
                  </div>
                <?php } ?>

              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
<?php } ?>
