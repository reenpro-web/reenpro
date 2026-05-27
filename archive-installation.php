<?php if (get_field('product_link_category', 'options')) { ?>
  <script>
    var projectsPageUrl = '<?php echo get_field('product_link_category', 'options'); ?>';
    window.location.href = projectsPageUrl;
  </script>
<?php } else { ?>
  <div class="products-intro d-flex">
    <div class="container mb-auto mt-auto">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8  text-center">
        <?php if (get_field('products_intro_heading', 'options')) { ?>
          <h1
            class="products-intro__heading c-white h3 mb-30"><?php the_field('products_intro_heading', 'options'); ?></h1>
        <?php } ?>
        <?php if (get_field('products_intro_text', 'options')) { ?>
          <div
            class="products-intro__text fs-20 c-white"><?php the_field('products_intro_text', 'options'); ?></div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<div class="products-list bg-purple pt-120 pb-155">
  <div class="container">
    <div class="row justify-content-center">
      <!--      --><?php //if (get_field('products_slider_heading', 'options')) { ?>
      <!--        <div class="col-12 text-center">-->
      <!--          <h3-->
      <!--            class="products-intro__heading c-white h3 mb-80">-->
      <?php //the_field('products_slider_heading', 'options'); ?><!--</h3>-->
      <!--        </div>-->
      <!--      --><?php //} ?>
      <div class="col-12 mb-30 mb-lg-60">
        <div class="row justify-content-center">
          <div class="col-12 col-md-10 col-lg-8 col-xl-7  offset-lg-1 offset-xl-2 text-md-center products-titles">

            <?php $args = array(
              'post_type' => 'products',
              'post_status' => 'publish',
              'posts_per_page' => '-1',
            );
            $loop = new WP_Query($args);
            $productCounter = 0; ?>
            <div id="installationCategories">

            <?php   while ($loop->have_posts()) :
              $loop->the_post(); ?>
              <div class="mb-20 text-md-center d-inline-block">
                <div class="products-title c-white  <?php echo $productCounter === 0 ? 'active' : '' ?>"
                     data-index="<?php echo $productCounter ?>"><?php the_title(); ?></div>
              </div>
              <?php $productCounter++; endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
          </div>
          <div class="col-12 col-lg-3 text-right">
            <div class="products-slider__arrows"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row ">
      <div class="col-12 col-lg-10  offset-lg-1">
        <div id="productSlide" class="products-slider">
          <?php $projectCounter = 0;
          $args = array(
            'post_type' => 'installation',
            'post_status' => 'publish',
            'posts_per_page' => '-1',
          );
          $loop = new WP_Query($args);
          $productCounter = 0;
          while ($loop->have_posts()) :
            $loop->the_post(); ?>
            <div>
              <div class="row mb-20">
                <div class="col-12 col-lg-6 mb-50 mb-lg-0  c-white product-galleries">
                  <div id="products-gallery" class="products-gallery">
                    <?php
                    $imageArray = get_field('product_gallery');
                    foreach ($imageArray as $image_id) { ?>
                      <div class="image">
                        <div class="products-gallery__img">
                          <?php echo wp_get_attachment_image($image_id, 'gallery_img') ?>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-5">
                  <h3 class="c-white mb-50"><?php the_title() ?></h3>
                  <?php if (have_rows('product_spec')) { ?>
                    <div class="row mb-20">
                      <?php while (have_rows('product_spec')) { ?>
                        <?php the_row(); ?>
                        <div class="col-12 col-md-6 c-white">
                          <div class="products-item__spec mb-30"><?php the_sub_field('text'); ?></div>
                        </div>
                      <?php } ?>
                    </div>
                  <?php } ?>
                  <?php if (get_field('product_file')) { ?>
                    <div class="products-item__button d-block d-lg-inline-block text-center">
                      <a class="w-100"
                         target="_blank"
                         download
                         href="<?php the_field('product_file'); ?>">
                        <i></i> Dokumentacija <span></span>
                      </a>
                    </div>
                  <?php } ?>
                </div>
                <div class="col-12">

                </div>
                <?php if (get_field('products_slider_heading', 'options')) { ?>
                  <div class="col-12 col-xl-11 offset-xl-1 mt-50 mt-lg-80 c-white">
                    <?php the_field('product_desc'); ?>
                  </div>
                <?php } ?>
              </div>
            </div>
            <?php $projectCounter++; endwhile;
          wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </div>
</div>


  <div class="products-warranty  mb-120 mt-50 mt-lg-120">
    <div class="row">
      <div class="col-12 col-lg-6 mb-50 mb-md-0 pl-0 pr-0 pr-md-6 pl-md-0">
        <div class="products-warranty__img">
          <?php echo wp_get_attachment_image(get_field('warranty_img', 'options'), 'full'); ?>
        </div>
      </div>
      <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
        <div class="products-warranty__wrapper pl-15 pr-15 pl-lg-0 pr-lg-20 pt-30 pt-lg-0 pb-30 pb-lg-0">
          <?php if (get_field('warranty_heading', 'options')) { ?>
            <h2 class="auto-financing__heading mb-45"><?php the_field('warranty_heading', 'options'); ?></h2>
          <?php } ?>
          <?php if (get_field('warranty_text', 'options')) { ?>
            <div class="products-warranty__text mb-45">
              <?php the_field('warranty_text', 'options'); ?>
            </div>
          <?php } ?>
          <?php if (have_rows('warranty_list', 'options')) { ?>
            <div class="products-warranty__list">
              <?php $i = 1; ?>
              <?php while (have_rows('warranty_list', 'options')) { ?>
                <?php the_row(); ?>
                <div class="mb-30 products-warranty__list-item">
                  <span class="products-warranty__list-item--number"><?php echo $i; ?></span>
                  <h3 class="mb-15 fw-bold">
                    <?php the_sub_field('heading', 'options'); ?>
                  </h3>
                  <div>
                    <?php the_sub_field('text', 'options'); ?>
                  </div>
                </div>
                <?php $i++;
              } ?>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <div class="products-production pt-50 pt-lg-120 pb-120 pb-lg-155"
       style="background-image: url(<?php echo wp_get_attachment_image_url(get_field('production_img', 'options'), 'full') ?>);">
    <div class="container">
      <div class="row  justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8 text-center">
          <?php if (get_field('production_heading', 'options')) { ?>
            <h2
              class="products-production__heading h3 mb-50 mb-lg-80"><?php the_field('production_heading', 'options'); ?></h2>
          <?php } ?>
          <?php if (get_field('production_text', 'options')) { ?>
            <div
              class="products-production__text mb-80"><?php the_field('production_text', 'options'); ?></div>
          <?php } ?>
        </div>
        <div class="col-12 col-xl-10  text-center">

          <?php if (have_rows('production_list', 'options')) { ?>
            <div class="row custom-row products-production__wrapper">
              <?php while (have_rows('production_list', 'options')) { ?>
                <?php the_row(); ?>
                <div class="col-12 col-lg-4 mb-50 mb-lg-0 text-center custom-column">
                  <div class="products-production__item">
                    <div class="mb-20">
                      <?php echo wp_get_attachment_image(get_sub_field('icon'), 'full') ?>
                    </div>
                    <h3 class="mb-20"><?php the_sub_field('heading'); ?></h3>
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
  <?php get_template_part('includes/main-form'); ?>
<?php } ?>

<style>
  @media only screen and (max-width: 768px) {
    .products-intro {
    <?php if (get_field('products_intro_img_mobile', 'options'))  { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('products_intro_img_mobile', 'options'), 'full') ?>);
    <?php } else { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('products_intro_img', 'options'), 'full') ?>);
    <?php } ?>
    }
  }

  @media only screen and (min-width: 769px) {
    .products-intro {
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('products_intro_img', 'options'), 'full') ?>);
    }
</style>
