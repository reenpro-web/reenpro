<?php
/* Template Name: Įrangos kategorija */

$iranga_background_image = get_field('iranga_background_image'); 
$iranga_description = get_field('iranga_description');
$iranga_heading = get_field('iranga_heading');
?>


<div class="iranga-intro mb-120"
     style="background-image: url('<?php echo esc_url($iranga_background_image); ?>'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-md-10 col-xl-5 mb-20 mb-lg-30 text-center">
        <?php if ($iranga_heading): ?>
            <h1 class="iranga-heading c-white mb-30 text-center">
                <?php echo esc_html($iranga_heading); ?>
            </h1>
        <?php endif; ?>
        <?php if ($iranga_description): ?>
            <div class="iranga-description c-white">
                <?php echo wp_kses_post($iranga_description); ?>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php if( have_rows('iranga_repeater') ): ?>
  <div class="iranga-list py-5 mb-120">
    <div class="container">
      <div class="row">
        <?php while( have_rows('iranga_repeater') ): the_row();
          $image       = get_sub_field('iranga_image');
          $title       = get_sub_field('iranga_title');
          $description = get_sub_field('iranga_description');
          $url         = get_sub_field('iranga_url');
        ?>
          <div class="col-12 col-md-6 col-lg-4 mb-4">
            <?php if ( $url ): ?>
              <a href="<?php echo esc_url($url); ?>"
                 class="iranga-card d-block h-100 text-decoration-none">
            <?php endif; ?>

              <div class="iranga-image-card shadow-sm">
                <?php if ( $image ): ?>
                  <img src="<?php echo esc_url($image); ?>"
                       class="iranga-image">
                <?php endif; ?>

                <div class="iranga-card-body">
                  <?php if ( $title ): ?>
                    <h5 class="iranga-card-title">
                      <?php echo esc_html($title); ?>
                    </h5>
                  <?php endif; ?>

                  <?php if ( $description ): ?>
                    <p class="iranga-card-text">
                      <?php echo wp_kses_post( wp_trim_words( $description, 20, '…' ) ); ?>
                    </p>
                  <?php endif; ?>
				  <span class="iranga-more-btn btn btn-primary">
				    <?php _e('Plačiau'); ?>
				  </span>
                </div>
              </div>

            <?php if ( $url ): ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
<?php endif; ?>
