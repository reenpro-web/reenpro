<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-555BGXH
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
<!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
<?php
do_action('get_header');
get_template_part('templates/header');
?>
<main class="main main-pt">
  <?php include Wrapper\template_path(); ?>
</main><!-- /.main -->

<?php
do_action('get_footer');
get_template_part('templates/footer');
wp_footer();
?>
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>


<?php $args = array(
  'post_type' => 'cars',
  'post_status' => 'publish',
  'posts_per_page' => -1
);
$loop = new WP_Query($args); ?>
<?php if ($loop->have_posts()) { ?>
  <select id="hiddenPostSelect" class="d-none">
    <option value="">Automobilio modelis</option>
    <?php while ($loop->have_posts()) : $loop->the_post(); ?>
      <?php $terms = get_the_terms($post->ID, 'car_category'); ?>
      <option value="<?php the_title() ?>"
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
<?php } ?>

<?php
$taxonomies = get_object_taxonomies('cars');
$terms = get_terms(array(
  'taxonomy' => 'car_category',
  'hide_empty' => true,
));
?>
<select id="hiddenTaxSelect" class="d-none">
  <option value="">Automobilio gamintojas</option>
  <?php foreach ($terms as $term) { ?>
    <option value="<?php echo $term->name; ?>" data-id="<?php echo $term->term_id; ?>">
      <?php echo $term->name; ?>
    </option>
  <?php } ?>
</select>

<?php if (!is_singular('product') || !is_singular('donation')) { ?>
  <div class="container">
    <div class="modal fade" id="offerModal" >
      <div class="modal-header w-100">
        <button type="button"
                class="modal-header__button"
                data-dismiss="modal"
                aria-label="Close"
                id="leaveToggle">
          <svg xmlns="http://www.w3.org/2000/svg" width="20.193" height="20.193" viewBox="0 0 20.193 20.193">
            <g id="Group_269" data-name="Group 269" transform="translate(-1724.221 -58.586)">
              <path id="Path_542" data-name="Path 542" d="M13582.194,1704.432h24.557" transform="translate(-6673.211 -10749.276) rotate(45)" fill="none" stroke="#fff" stroke-width="4"/>
              <path id="Path_543" data-name="Path 543" d="M0,0H24.557" transform="translate(1742.999 60) rotate(135)" fill="none" stroke="#fff" stroke-width="4"/>
            </g>
          </svg>

        </button>
      </div>
      <div class="row justify-content-center mt-auto mb-auto h-100">
        <div class="col-12 col-md-10 col-lg-6">
          <div class="modal-dialog modal-dialog-centered modal-dialog--medium">
            <div class="modal-content modal-content--background">
              <div class="modal-body p-0 m-0">
                <div class="row justify-content-center" id="formButtons">
                  <div class="col-12">
                    <?php if (get_field('modal_heading', 'option')) { ?>
                      <h3 class="c-white mb-30 b-md-80 text-center">
                        <?php echo get_field('modal_heading', 'option') ?>
                      </h3>
                    <?php } ?>
                  </div>
                  <div class="col-12 col-md-4 mb-30 mb-md-0">
                    <div class="modal-column h-100" id="displaySolarForm">
                      <div class="c-white text-center">
                        <div class="mb-30">
                          <?php echo wp_get_attachment_image(get_field('modal_solar_img', 'options'), 'home_logos') ?>
                        </div>
                        <div
                          class="c-black fs-18 mb-0 fw-bold"> <?php echo get_field('modal_solar_heading', 'option') ?></div>
                      </div>
                    </div>
                  </div>
	              <div class="col-12 col-md-4 mb-30 mb-md-0">
                    <div class="modal-column h-100" id="displayBessForm">
                      <div class="c-white text-center">
                        <div class="mb-30">
                          <?php echo wp_get_attachment_image(get_field('modal_bess_img', 'options'), 'home_logos') ?>
                        </div>
                        <div
                          class="c-black fs-18 mb-0 fw-bold"> <?php echo get_field('modal_bess_heading', 'option') ?></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-4">
                    <div class="modal-column h-100" id="displayCarForm">
                      <div class="c-white text-center">
                        <div class="mb-30">
                          <?php echo wp_get_attachment_image(get_field('modal_car_img', 'options'), 'home_logos') ?>
                        </div>
                        <div
                          class="c-black fs-18 mb-0 fw-bold"> <?php echo get_field('modal_car_heading', 'option') ?></div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if (get_field('contact_form', 'options')) { ?>
                  <div id="solarForm" class="d-none">
                    <div class="contact-form contact-form--modal mb-30">
                      <h3 class="mb-40 mb-lg-50 contact-form__heading">
                        <?php if (get_field('contact_heading_main', 'options')) { ?>
                          <?php the_field('contact_heading_main', 'options'); ?>
                        <?php } else { ?>
                          Užpildyk užklausą
                        <?php } ?>
                      </h3>
                      <div class="contact-tabs mb-10">
                        <div id="tabList-modal">
                          <div class="contact-tabs__list mb-15">
                            <ul class="nav nav-tabs" id="myTab-modal" role="tablist">
                              <?php if (get_field('contact_form', 'options')) { ?>
                                <li class="flex-shrink-0">
                                  <a class="active modal"
                                     id="heading-personal-modal"
                                     data-toggle="tab"
                                     href="#tab-personal-modal"
                                     role="tab"
                                     aria-controls="tab-personal-modal"
                                     aria-selected="true">
                                    <?php if (get_field('contact_form_tab_personal', 'options')) { ?>
                                      <?php the_field('contact_form_tab_personal', 'options'); ?>
                                    <?php } else { ?>
                                      Privatus klientas
                                    <?php } ?>
                                  </a>
                                </li>
                              <?php } ?>
                              <?php if (get_field('contact_form_business', 'options')) { ?>
                                <li class="flex-shrink-0">
                                  <a class="modal"
                                     id="heading-business-modal"
                                     data-toggle="tab"
                                     href="#tab-business-modal"
                                     role="tab"
                                     aria-controls="tab-business-modal"
                                     aria-selected="true">
                                    <?php if (get_field('contact_form_tab_business', 'options')) { ?>
                                      <?php the_field('contact_form_tab_business', 'options'); ?>
                                    <?php } else { ?>
                                      Verslo klientas
                                    <?php } ?>

                                  </a>
                                </li>
                              <?php } ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="contact-tabs">
                        <div id="tabAnswer-modal">
                          <div class="contact-tabs__content pb-50 pb-md-0" id="myTabContent">
                            <?php if (get_field('contact_form', 'options')) { ?>

                              <div class="tab-pane fade show active"
                                   id="tab-personal-modal"
                                   role="tabpanel"
                                   aria-labelledby="heading-personal-modal">
                                <?php echo do_shortcode(get_field('contact_form', 'options')) ?>
                              </div>
                            <?php } ?>
                            <?php if (get_field('contact_form_business', 'options')) { ?>

                              <div class="tab-pane fade"
                                   id="tab-business-modal"
                                   role="tabpanel"
                                   aria-labelledby="heading-business-modal">
                                <?php echo do_shortcode(get_field('contact_form_business', 'options')) ?>
                              </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
	  
				<?php if (get_field('bess_contact_form', 'options')) { ?>
				  <div id="bessFormInModal" class="d-none">
					<div class="contact-form contact-form--modal mb-30">

					  <h3 class="mb-40 mb-lg-50 contact-form__heading">
						<?php 
						  // Check if the heading exists, otherwise fallback to default text
						  $bess_heading = get_field('bess_contact_heading_main', 'options');
						  echo $bess_heading ? $bess_heading : 'Užpildyk užklausą'; 
						?>
					  </h3>

					  <div class="contact-tabs mb-10">
						<div class="contact-tabs__list mb-15">
						  <ul class="nav nav-tabs" id="bessTab-modal" role="tablist">
							<li class="flex-shrink-0">
							  <a class="active modal" 
								 id="heading-bess-personal-modal" 
								 data-toggle="tab" 
								 href="#tab-bess-personal-modal" 
								 role="tab">
								<?php echo get_field('bess_contact_form_tab_personal', 'options') ?: 'Privatus klientas'; ?>
							  </a>
							</li>
							<?php if (get_field('bess_contact_form_business', 'options')) { ?>
							  <li class="flex-shrink-0">
								<a class="modal" 
								   id="heading-bess-business-modal" 
								   data-toggle="tab" 
								   href="#tab-bess-business-modal" 
								   role="tab">
								  <?php echo get_field('bess_contact_form_tab_business', 'options') ?: 'Verslo klientas'; ?>
								</a>
							  </li>
							<?php } ?>
						  </ul>
						</div>
					  </div>

					  <div class="contact-tabs">
						<div class="contact-tabs__content pb-50 pb-md-0">
						  <div class="tab-pane fade show active" id="tab-bess-personal-modal" role="tabpanel">
							<?php 
							  $personal_form = get_field('bess_contact_form', 'options');
							  if ($personal_form) {
								  echo do_shortcode($personal_form);
							  } else {
								  echo "<p style='color:white;'>Error: 'bess_contact_form' field is empty in Options.</p>";
							  }
							?>
						  </div>

						  <?php if (get_field('bess_contact_form_business', 'options')) { ?>
							<div class="tab-pane fade" id="tab-bess-business-modal" role="tabpanel">
							  <?php echo do_shortcode(get_field('bess_contact_form_business', 'options')); ?>
							</div>
						  <?php } ?>
						</div>
					  </div>

					</div>
				  </div>
				<?php } ?>
	  
                <?php if (get_field('contact_car_form', 'options')) { ?>
                  <div id="carForm" class="d-none car-form">
                    <div class="contact-form contact-form--modal mb-30">
                      <?php echo do_shortcode(get_field('contact_car_form', 'options')) ?>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

</body>
</html>

