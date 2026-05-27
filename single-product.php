<?php
/* Template Name: Įkrovimo stotelės */
?>

<?php if (get_field('battery_title')) { ?>
  <?php $batteryTitle = get_field('battery_title'); ?>
<?php } ?>
<?php if (get_field('battery_icon')) { ?>
  <?php $batteryIcon = wp_get_attachment_image(get_field('battery_icon'), 'full') ?>
<?php } ?>
<?php if (get_field('charging_speed_heading')) { ?>
  <?php $batterySpeedTitle = get_field('charging_speed_heading'); ?>
<?php } ?>
<?php if (get_field('battery_speed_icon')) { ?>
  <?php $batterySpeedIcon = wp_get_attachment_image(get_field('battery_speed_icon'), 'full') ?>
<?php } ?>
<?php if (get_field('charging_time_heading')) { ?>
  <?php $batteryTimeTitle = get_field('charging_time_heading'); ?>
<?php } ?>
<?php if (get_field('battery_time_icon')) { ?>
  <?php $batteryTimeIcon = wp_get_attachment_image(get_field('battery_time_icon'), 'full') ?>
<?php } ?>

<div class="auto-intro mb-50 mb-md-120 d-flex">
  <div class="container mt-auto mb-auto">
    <div class="row align-items-center justify-content-lg-between">
      <div class="col-12 col-md-10 col-xl-5">
        <h1 class="auto-intro__heading c-white mb-40 h2">
          <?php the_title(); ?>
        </h1>
        <?php if (get_field('dock_intro_text')) { ?>
          <div class="auto-intro__text fs-15 c-white mb-40 ">
            <?php the_field('dock_intro_text'); ?>
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
<?php if (!get_field('display_calculator')) { ?>
  <div class="container mb-50 mb-md-120 <?php echo get_field('display_calculator') ? 'd-none' : '' ?>">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-10">
        <div class="auto-calculator">
          <div class="row">
            <div class="col-12 col-md-6 order-2 order-md-1">
              <?php if (get_field('calculator_heading')) { ?>
                <h3 class="mb-20 mb-md-30"> <?php the_field('calculator_heading'); ?></h3>
              <?php } ?>

              <?php $args = array(
                'post_type' => 'cars',
                'post_status' => 'publish',
                'posts_per_page' => -1
              );
              $loop = new WP_Query($args); ?>
              <div class="row mb-20 mb-md-30">

                <div class="col-12 col-md-6 mb-20 mb-md-0">
                  <?php
                  $taxonomies = get_object_taxonomies('cars');
                  $terms = get_terms(array(
                    'taxonomy' => 'car_category',
                    'hide_empty' => true,
                  ));
                  ?>
                  <div class="contact-form__column">
                    <select id="hiddenMainTaxSelect">
                      <option value=""></option>
                      <?php foreach ($terms as $term) { ?>
                        <option value="<?php echo $term->name; ?>"
                                data-id="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <?php if ($loop->have_posts()) { ?>
                    <div class="contact-form__column">

                      <select id="hiddenMainPostSelect">
                        <option value=""></option>
                        <?php while ($loop->have_posts()) : $loop->the_post(); ?>
                          <?php $terms = get_the_terms($post->ID, 'car_category'); ?>
                          <option value="<?php the_title() ?>" id="<?php the_ID(); ?>"
                                  data-id="<?php foreach ($terms as $term) : echo $term->term_id; endforeach ?>">
                            <?php if (get_field('car_title', $post->ID)) { ?>
                              <?php echo get_field('car_title', $post->ID) ?>
                            <?php } else { ?>
                              <?php the_title(); ?>
                            <?php } ?>
                          </option>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                      </select>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div id="calcError" class="c-red hide mt-5 mb-10 fs-12">Pasirinkite automobilį</div>
              <div class="button w-100" id="calcCar"><?php the_field('calculator_button'); ?> <i></i></div>
            </div>
            <div class="col-12 col-md-6 col-lg-5 offset-lg-1 order-1 order-md-2 mb-10 mb-md-0">
              <?php echo wp_get_attachment_image(get_field('calculator_img'), 'calc-img') ?>
            </div>
          </div>

          <div class="row d-none mt-50 mt-md-100" id="calcData">
            <?php if (get_field('calculator_data_heading')) { ?>
              <div class="col-12 text-center">
                <h4 class="mb-30"> <?php the_field('calculator_data_heading'); ?></h4>
              </div>
            <?php } ?>

            <?php if ($loop->have_posts()) { ?>
              <?php while ($loop->have_posts()) : $loop->the_post(); ?>
                <?php $terms = get_the_terms($post->ID, 'car_category'); ?>
                <div class="col-12">
                  <div class="row d-none selected-car" id="<?php the_ID(); ?>">
                    <div class="col-12 col-md-4 col-lg-5 text-center text-md-left mb-20 mb-md-0">
                      <h3 class="mb-0"><?php foreach ($terms as $term) : echo $term->name; endforeach ?></h3>
                      <h3 class="mb-0"><?php the_title() ?></h3>
                    </div>
                    <div class="col-12 col-md-8 col-lg-7">
                      <?php if (get_field('battery', $post->ID) || get_field('charging_speed', $post->ID) || get_field('charging_speed', $post->ID)) { ?>
                        <div class="row">
                          <?php if (get_field('battery', $post->ID)) { ?>
                            <div class="col-4">
                              <div class="mb-10 car-data__icon d-flex">
                                <?php echo $batteryIcon; ?>
                              </div>
                              <div> <?php echo $batteryTitle; ?></div>
                              <div class="fs-md-20 fw-bold">
                                <?php echo get_field('battery', $post->ID); ?>
                              </div>
                            </div>
                          <?php } ?>
                          <?php if (get_field('charging_speed', $post->ID)) { ?>
                            <div class="col-4">
                              <div class="mb-10 car-data__icon d-flex">
                                <?php echo $batterySpeedIcon; ?></div>
                              <div> <?php echo $batterySpeedTitle; ?></div>
                              <div class="fs-md-20 fw-bold">
                                <?php echo get_field('charging_speed', $post->ID); ?>
                              </div>
                            </div>
                          <?php } ?>
                          <?php if (get_field('charging_time', $post->ID)) { ?>
                            <div class="col-4">
                              <div class="mb-10 car-data__icon d-flex">
                                <?php echo $batteryTimeIcon; ?></div>
                              <div> <?php echo $batteryTimeTitle; ?></div>
                              <div class="fs-md-20 fw-bold">
                                <?php echo get_field('charging_time', $post->ID); ?>
                              </div>
                            </div>
                          <?php } ?>
                        </div>
                      <?php } else { ?>
                        <div class="row">
                          <div class="col-12">
                            <div class="fs-20">
                              Duomenų apie šį modelį nepateikta.
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                    <?php if (get_field('get_offer_text', 'options')) { ?>
                      <div class="col-12 text-center mt-40 mb-10 mb-md-0">
                        <div
                          class="button button--wide getMainOffer d-block d-md-inline-block"><?php the_field('get_offer_text', 'options'); ?>
                          <i></i></div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              <?php endwhile;
              wp_reset_postdata(); ?>
            <?php } ?>


          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<?php if (have_rows('docks')) { ?>
  <div class="auto-docks  mb-100 mb-md-120">
    <div class="container">
      <div class="row justify-content-center">
        <?php if (get_field('heading_docks')) { ?>
          <div class="col-12 text-center">
            <h3 class="auto-docks__heading mb-50 mb-md-85"><?php the_field('heading_docks'); ?></h3>
          </div>
        <?php } ?>
      </div>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          <div class="row custom-row auto-docks__wrapper justify-content-center">
            <?php while (have_rows('docks')) { ?>
              <?php the_row(); ?>
              <div class="col-12 col-md-6 col-lg-4 custom-column mb-30">
                <div class="auto-docks__item h-100">
                  <div class="auto-docks__item-img text-center">
                    <?php echo wp_get_attachment_image(get_sub_field('img'), 'docks-cards'); ?>
                  </div>
                  <div class="p-25 p-md-30">
                    <h4 class="mb-25 mb-md-30 text-center"><?php the_sub_field('title'); ?></h4>
                    <div><?php the_sub_field('desc'); ?></div>
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
<?php if (have_rows('choose_reenpro')) { ?>

  <div class="auto-choose bg-purple pt-50 pt-md-120 pb-50 pb-md-120">
    <div class="container">
      <div class="row">
        <?php if (get_field('choose_title')) { ?>
          <div class="col-12 text-center">
            <h2 class="auto-choose__heading mb-50 mb-md-80 c-white h3"><?php the_field('choose_title'); ?></h2>
          </div>
        <?php } ?>
        <?php while (have_rows('choose_reenpro')) { ?>
          <?php the_row(); ?>
          <div class="col-12 col-md-6 col-lg-3 mb-50 mb-md-30">
            <div class="auto-choose__item h-100">
              <div class="auto-choose__item-img text-center">
                <?php echo wp_get_attachment_image(get_sub_field('icon'), 'full'); ?>
              </div>
              <div class="pt-20 c-white">
                <h3 class="mb-20 mb-md-30 text-center c-white h4"><?php the_sub_field('title'); ?></h3>
                <div class="text-center"><?php the_sub_field('text'); ?></div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
<?php } ?>
<?php if (have_rows('donation_blocks')) { ?>

  <div class="auto-donation pt-50 pt-md-120 pb-120">
    <div class="container">
      <div class="row justify-content-center">
        <?php if (get_field('donation_title')) { ?>
          <div class="col-12 col-md-10 col-lg-8   text-center">
            <h2 class="auto-donation__heading mb-50 mb-md-80 h3"><?php the_field('donation_title'); ?></h2>
            <div class="mb-50 mb-md-80"><?php the_field('donation_text'); ?></div>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="container container--no-padding">
      <?php $donationCounter = 0; ?>
      <?php while (have_rows('donation_blocks')) { ?>
        <?php the_row(); ?>
        <div class="row align-items-center mb-50 mb-md-80">
          <div
            class="col-12 mb-30 mb-lg-0  <?php echo $donationCounter % 2 ? 'col-lg-6 order-lg-2 ' : 'col-lg-6  order-lg-1 ' ?>">
            <div class="auto-donation__img">
              <?php echo wp_get_attachment_image(get_sub_field('img'), 'docks-donation'); ?>
            </div>
          </div>
          <div
            class="col-12  pl-30 pr-30 pr-md-15 pl-md-15  text-center  mb-30 mb-lg-0 <?php echo $donationCounter % 2 ? ' col-lg-6 col-xl-5  offset-xl-1 pr-lg-65 pl-lg-0' : 'col-lg-6 col-xl-5  order-lg-2 pl-lg-65 pr-lg-0' ?>">
            <div>
              <div class="auto-donation__icon mb-20">
                <?php echo wp_get_attachment_image(get_sub_field('icon'), 'full'); ?>
              </div>
              <div
                class="auto-donation__wrapper <?php echo $donationCounter % 2 ? 'auto-donation__wrapper--right' : '' ?>">
                <h3
                  class="auto-donation__heading mb-0 h4 <?php echo $donationCounter % 2 ? 'auto-donation__heading--right' : '' ?>">
                  <?php the_sub_field('title'); ?>
                </h3>
                <span
                  class="auto-donation__heading-icon  <?php echo $donationCounter % 2 ? 'auto-donation__heading-icon--right' : '' ?>">
                  <span class="dot"></span>
              </span>
              </div>
              <div class="text-center mt-20"><?php the_sub_field('text'); ?></div>

            </div>
          </div>
        </div>
        <?php $donationCounter++;
      } ?>
    </div>
    <div class="container">
      <?php if (get_field('get_offer_text', 'options')) { ?>
        <div class="text-center">
          <div
            class="button button--wide getMainOffer d-block d-md-inline-block"><?php the_field('get_offer_text', 'options'); ?>
            <i></i></div>
        </div>
      <?php } ?>
    </div>
  </div>
<?php } ?>

<div class="auto-financing bg-purple mb-md-120">
  <div class="row align-items-start align-items-lg-center">
    <div class="col-12 col-lg-6 mb-30 mb-md-0 pl-0 pr-0 pr-md-6 pl-md-0">
      <?php if (get_field('financing_img')) { ?>
        <div class="auto-financing__img">
          <?php echo wp_get_attachment_image(get_field('financing_img'), 'full'); ?>
        </div>
      <?php } ?>
    </div>
    <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
      <div class="auto-financing__wrapper pl-15 pr-15 pl-lg-0 pr-lg-20 pt-30 pt-lg-0 pb-30 pb-lg-20 pt-lg-20">
        <?php if (get_field('financing_title')) { ?>
          <h2 class="auto-financing__heading mb-45 c-white h3"><?php the_field('financing_title'); ?></h2>
        <?php } ?>
        <?php if (get_field('financing_title')) { ?>
          <div class="auto-financing__text c-white">
            <?php the_field('financing_blocks'); ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

</div>
<?php if (have_rows('process_steps')) { ?>
  <div class="donation-process mt-50 mt-md-120 mb-60 mb-md-170">
    <div class="container">
      <div class="row justify-content-center mb-50 mb-md-80">
        <?php if (get_field('process_heading')) { ?>
          <div class="col-12 col-md-10 col-lg-8 col-xl-5 text-center">
            <h2 class="donation-conditions__heading mb-20 h3"><?php the_field('process_heading'); ?></h2>
            <?php if (get_field('process_text')) { ?>
              <div><?php the_field('process_text'); ?></div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">
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

          <?php if (get_field('get_offer_text', 'options')) { ?>
            <div class="text-center mt-20 mt-lg-0">
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

<div class=" <?php echo get_field('display_cards') ? 'd-none' : '' ?>">
  <?php echo get_template_part('includes/projects-small-cards', '', ['descDisplay' => 'd-none']) ?>
</div>

<?php get_template_part('includes/global-logos'); ?>


<?php
if ( get_the_ID() == 2930 ) {
    get_template_part('includes/bess-form');
}
elseif (get_field('select_form') == 'car') {
  get_template_part('includes/auto-form');
} 
elseif (get_field('select_form') == 'sun') {
  get_template_part('includes/main-form');
}
?>
<?php get_template_part('includes/faq'); ?>


<style>
  @media only screen and (max-width: 768px) {
    .auto-intro {
    <?php if (get_field('dock_intro_img_mobile'))  { ?> background-image: url(<?php echo wp_get_attachment_image_url(get_field('dock_intro_img_mobile'), 'full') ?>);
    <?php } else { ?> background-image: url(<?php echo wp_get_attachment_image_url(get_field('dock_intro_img'), 'full') ?>);
    <?php } ?>
    }
  }

  @media only screen and (min-width: 769px) {
    .auto-intro {
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('dock_intro_img'), 'full') ?>);
    }
</style>
