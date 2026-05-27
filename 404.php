<div class="cms-intro cms-intro--404">
</div>

<div class="pt-120 pb-200">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-4 text-center">
        <div class="mb-40">
          <?php echo wp_get_attachment_image(get_field('404_title_image', 'options'), 'full'); ?>
<!--          <h1 class="mb-30 c-purple">--><?php //the_field('404_heading', 'option'); ?><!--</h1>-->
        </div>
        <h3 class="mb-10"><?php the_field('404_text', 'option'); ?></h3>
        <a  href="<?= esc_url(home_url('/')); ?>" class="not-found-link">
          <?php the_field('404_button', 'option'); ?> <i></i></a>
      </div>
    </div>
  </div>
</div>
<style>
  @media only screen and (max-width: 768px) {
    .cms-intro {
    <?php if (get_field('404_image_mobile', 'options'))  { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('404_image_mobile', 'options'), 'full') ?>);
    <?php } else { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('404_image', 'options'), 'full') ?>);
    <?php } ?>
    }
  }

  @media only screen and (min-width: 769px) {
    .cms-intro {
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('404_image', 'options'), 'full') ?>);
    }
</style>
