<?php
/**
 * Template Name: CMS puslapis
 */
?>

<div class="cms-intro d-flex">
  <div class="container mt-auto mb-auto">
    <div class="row">
      <div class="col-12">
        <div class="h3 mb-0 c-white text-center cms-intro__heading"><?php the_title() ?></div>
      </div>
    </div>
  </div>
</div>

<div class="pt-50 pt-md-120 pb-50 pb-md-150">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8">
        <!--        <h1 class="mb-40 h2 text-center">--><?php //the_title() ?><!--</h1>-->
        <div class="mb-40"><?php the_content(); ?></div>
      </div>
    </div>
  </div>
</div>
<style>
  @media only screen and (max-width: 768px) {
    .cms-intro {
    <?php if (get_field('cms_img_mobile', 'options'))  { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('cms_img_mobile', 'options'), 'full') ?>);
    <?php } else { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('cms_img', 'options'), 'full') ?>);
    <?php } ?>
    }
  }

  @media only screen and (min-width: 769px) {
    .cms-intro {
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('cms_img', 'options'), 'full') ?>);
    }
</style>
