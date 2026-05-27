<?php
/* Template Name: Parama */
?>

<div class="donation-banner">
  <div class="donation-intro"
       style="background-image: url(<?php echo wp_get_attachment_image_url(get_field('donation_intro_image'), 'full') ?>);">
    <div class="container">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-12 col-md-10 col-xl-6">
          <?php if (get_field('donation_intro_heading')) { ?>
            <h1 class="donation-intro__heading c-white mb-40 h2">
              <?php the_field('donation_intro_heading'); ?>
            </h1>
          <?php } ?>
          <?php if (get_field('donation_intro_text')) { ?>
            <div class="donation-intro__text c-white mb-40 ">
              <?php the_field('donation_intro_text'); ?>
            </div>
          <?php } ?>
          <?php if (get_field('get_offer_text', 'options')) { ?>
            <div>
              <div class="button button--wide getMainOffer"><?php the_field('get_offer_text', 'options'); ?>
                <i></i></div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="donation-info">
  <div class="container">
    <div class="row custom-row justify-content-center">
      <div class="col-12 col-xl-10 custom-column mb-60">
        <?php if (have_rows('donation_form_cards')) { ?>
          <div class="row custom-row home-info__wrapper">
            <?php while (have_rows('donation_form_cards')) { ?>
              <?php the_row(); ?>
              <div class="col-12 col-lg-4 text-center custom-column">
                <div class="home-info__item">

                  <svg class="mb-20" xmlns="http://www.w3.org/2000/svg" width="8" height="128.433"
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
                  <div class="mb-20">
                    <?php echo wp_get_attachment_image(get_sub_field('icon'), 'full') ?>
                  </div>
                  <h3 class="mb-20"><?php the_sub_field('title'); ?></h3>
                  <div><?php the_sub_field('text'); ?></div>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>

      <?php if (get_field('donation_form_button')) { ?>
        <?php
        $link = get_field('donation_form_button'); ?>
        <div class="col-12 text-center">
          <div>
            <a class="button button--wide"
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

<div class="donation-conditions"
     style="background-image: url(<?php echo wp_get_attachment_image_url(get_field('donation_conditions_img'), 'full') ?>);">
  <div class="container">
    <div class="row custom-row donation-conditions__wrapper">
      <?php if (get_field('donation_conditions_heading')) { ?>
        <div class="col-12 text-center">
          <h3 class="donation-conditions__heading mb-85"><?php the_field('donation_conditions_heading'); ?></h3>
        </div>
      <?php } ?>
      <?php if (have_rows('donation_conditions_cards')) { ?>
        <?php $i = 1; ?>
        <?php while (have_rows('donation_conditions_cards')) { ?>
          <?php the_row(); ?>
          <div class="col-12 col-lg-3 text-center">
            <div class="donation-conditions__item">
              <div class="donation-conditions__item-number mb-20"><?php echo $i; ?></div>
              <h3 class="mb-20"><?php the_sub_field('title'); ?></h3>
              <div><?php the_sub_field('text'); ?></div>
            </div>
          </div>
          <?php $i++;
        } ?>
      <?php } ?>
    </div>
  </div>
</div>


<div class="donation-process mt-120 mb-150">
  <div class="container">
    <div class="row justify-content-center mb-80">
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
      <div class="col-12">
        <?php if (have_rows('process_steps')) { ?>
          <?php $i = 1; ?>
          <div class="donation-process__items d-flex align-items-center mb-100">
            <?php while (have_rows('process_steps')) { ?>
              <?php the_row(); ?>
              <?php $isHidden = $i === 1 ? 'd-none' : ''; ?>
              <div class="indicator-line <?php echo $isHidden; ?>"></div>
              <div class="donation-process__item ">
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
        <?php } ?>
        <?php if (get_field('get_offer_text', 'options')) { ?>
          <div class="text-center">
            <div class="button button--wide getMainOffer"><?php the_field('get_offer_text', 'options'); ?>
              <i></i></div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php 
  get_template_part('includes/projects-small-cards');
  get_template_part('includes/main-form');
  get_template_part('includes/faq'); 
?>


