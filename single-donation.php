<div class="donation-banner">
  <div class="donation-intro d-flex">
    <div class="container mt-auto mb-auto">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-12 col-md-10 col-xl-6">
          <h1 class="donation-intro__heading c-white mb-40 h2">
            <?php the_title() ?>
          </h1>
          <?php if (get_field('donation_intro_text')) { ?>
            <div class="donation-intro__text c-white mb-40 ">
              <?php the_field('donation_intro_text'); ?>
            </div>
          <?php } ?>
          <?php if (get_field('get_offer_text', 'options')) { ?>
            <div>
              <div
                class="button button--wide getMainOffer d-block d-md-inline-block"><?php the_field('get_offer_text', 'options'); ?>
                <i></i></div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if (have_rows('donation_form_cards')) { ?>

  <div class="donation-info">
    <div class="container">
      <div class="row custom-row justify-content-center">
        <div class="col-12 col-xl-10 custom-column mb-60">
          <div class="row custom-row home-info__wrapper">
            <?php while (have_rows('donation_form_cards')) { ?>
              <?php the_row(); ?>
              <div class="col-12 col-lg-4 text-center custom-column mb-20 mb-lg-0">
                <div class="home-info__item">

                  <svg class="mb-20 d-none d-md-inline" xmlns="http://www.w3.org/2000/svg" width="8" height="128.433"
                       viewBox="0 0 8 128.433">
                    <g id="Group_258" data-name="Group 258" transform="translate(-493 -790)">
                      <g id="Ellipse_265" data-name="Ellipse 265" transform="translate(493 790)" fill="none"
                         stroke="#12122d" stroke-width="2">
                        <circle cx="4" cy="4" r="4" stroke="none"/>
                        <circle cx="4" cy="4" r="3" fill="none"/>
                      </g>
                      <path id="Path_77" data-name="Path 77" d="M429.948,1287v120.433" transform="translate(67 -489)"
                            fill="none" stroke="#12122d" stroke-width="2"/>
                    </g>
                  </svg>

                  <svg class="mb-20 d-md-none" xmlns="http://www.w3.org/2000/svg" width="8" height="100"
                       viewBox="0 0 8 100">
                    <g id="Group_258" data-name="Group 258" transform="translate(-493 -790)">
                      <g id="Ellipse_265" data-name="Ellipse 265" transform="translate(493 790)" fill="none"
                         stroke="#12122d" stroke-width="2">
                        <circle cx="4" cy="4" r="4" stroke="none"/>
                        <circle cx="4" cy="4" r="3" fill="none"/>
                      </g>
                      <path id="Path_77" data-name="Path 77" d="M429.948,1287v92" transform="translate(67 -489)"
                            fill="none" stroke="#12122d" stroke-width="2"/>
                    </g>
                  </svg>


                  <div class="mb-20">
                    <?php echo wp_get_attachment_image(get_sub_field('icon'), 'full') ?>
                  </div>
                  <h2 class="mb-20 h4"><?php the_sub_field('title'); ?></h2>
                  <div><?php the_sub_field('text'); ?></div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

        <?php if (get_field('donation_form_button')) { ?>
          <?php
          $link = get_field('donation_form_button'); ?>
          <div class="col-12 text-center">
            <div>
              <a class="button button--wide d-block d-md-inline-block"
                 href="<?php echo $link['url']; ?>"
                <?php if ($link['target']) { ?>
                  target="<?php echo $link['target']; ?>" <?php } else { ?> target="_self" <?php } ?>>
                <?php echo $link['title']; ?> <i></i>
              </a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
<?php } ?>
<?php if (have_rows('donation_conditions_cards')) { ?>

  <div class="donation-conditions">
    <div class="container">
      <div class="row custom-row donation-conditions__wrapper justify-content-center">
        <?php if (get_field('donation_conditions_heading')) { ?>
          <div class="col-12 text-center">
            <h3
              class="donation-conditions__heading mb-50 mb-md-85"><?php the_field('donation_conditions_heading'); ?></h3>
          </div>
        <?php } ?>
        <?php $i = 1; ?>
        <?php while (have_rows('donation_conditions_cards')) { ?>
          <?php the_row(); ?>
          <div class="col-12 col-lg-3 text-center mb-30 mb-lg-30">
            <div class="donation-conditions__item">
              <div class="donation-conditions__item-number mb-20"><?php echo $i; ?></div>
              <h4 class="mb-20"><?php the_sub_field('title'); ?></h4>
              <div class="fs-15 fs-md-16"><?php the_sub_field('text'); ?></div>
            </div>
          </div>
          <?php $i++;
        } ?>
      </div>
    </div>
  </div>

<?php } ?>
<?php if (have_rows('process_steps')) { ?>

<div class="donation-process mt-50 mt-md-120 mb-100 mb-md-150">
  <div class="container">
    <div class="row justify-content-center mb-50 mb-md-80">
      <?php if (get_field('process_heading')) { ?>
        <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">
          <h3 class="donation-conditions__heading mb-20"><?php the_field('process_heading'); ?></h3>
          <?php if (get_field('process_text')) { ?>
            <div><?php the_field('process_text'); ?></div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 ">
          <?php $i = 1; ?>
          <div class="donation-process__wrapper">
            <div class="donation-process__items d-flex align-items-center mb-100">
              <?php while (have_rows('process_steps')) { ?>
                <?php the_row(); ?>
                <?php $isHidden = $i === 1 ? 'd-none' : ''; ?>
                <div class="indicator-line flex-shrink-0 <?php echo $isHidden; ?>"></div>
                <div class="donation-process__item flex-shrink-0">
                  <div class="text-center">
                    <div class="donation-process__item-icon">
                      <div>
                        <?php echo wp_get_attachment_image(get_sub_field('icon'), 'full'); ?>
                      </div>
                      <div class="donation-process__item-text">
                        <?php the_sub_field('title') ?>
                      </div>
                    </div>
                  </div>
                </div>
                <?php $i++; ?>
              <?php } ?>
            </div>
          </div>

      </div>
    </div>
    <div class="row justify-content-center mt-20 mt-lg-0">
      <div class="col-12">
        <?php if (get_field('get_offer_text', 'options')) { ?>
          <div class="text-center">
            <div
              class="button button--wide getMainOffer d-block d-md-inline-block"><?php the_field('get_offer_text', 'options'); ?>
              <i></i></div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php get_template_part('includes/projects-small-cards'); ?>

<?php 
if (is_single(866)){ // ENA parama elektromobilių įkrovimo stotelėms
	get_template_part('includes/auto-form');
}
else if (is_single(2418)){
	get_template_part('includes/bess-form');
}
else{
	get_template_part('includes/main-form');
}
?>
<?php get_template_part('includes/faq'); ?>




<style>
  @media only screen and (max-width: 768px) {
    .donation-intro {
    <?php if (get_field('donation_intro_image_mobile'))  { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('donation_intro_image_mobile'), 'full') ?>);
    <?php } else { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('donation_intro_image'), 'full') ?>);
    <?php } ?>
    }
    .donation-conditions {
    <?php if (get_field('donation_conditions_img_mobile'))  { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('donation_conditions_img_mobile'), 'full') ?>);
    <?php } else { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('donation_conditions_img'), 'full') ?>);
    <?php } ?>
    }
  }

  @media only screen and (min-width: 769px) {
    .donation-intro {
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('donation_intro_image'), 'full') ?>);
    }

    .donation-conditions{
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('donation_conditions_img'), 'full') ?>);
    }
</style>
