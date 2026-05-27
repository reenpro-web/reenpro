<?php
/* Template Name: Paslaugos */

$paslaugos_background_image = get_field('paslaugos_background_image'); 
$paslaugos_description = get_field('paslaugos_description');
$paslaugos_heading = get_field('paslaugos_heading');
?>


<div class="paslaugos-intro mb-120"
     style="background-image: url('<?php echo esc_url($paslaugos_background_image); ?>'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-md-10 col-xl-5 mb-20 mb-lg-30 text-center">
        <?php if ($paslaugos_heading): ?>
            <h1 class="paslaugos-heading c-white mb-30 text-center">
                <?php echo esc_html($paslaugos_heading); ?>
            </h1>
        <?php endif; ?>
        <?php if ($paslaugos_description): ?>
            <div class="paslaugos-description c-white">
                <?php echo wp_kses_post($paslaugos_description); ?>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php if( have_rows('paslaugos_repeater') ): ?>
  <div class="paslaugos-list py-5 mb-120">
    <div class="container">
      <div class="row">
        <?php while( have_rows('paslaugos_repeater') ): the_row();
          $image       = get_sub_field('paslauga_image');
          $title       = get_sub_field('paslauga_title');
          $description = get_sub_field('paslauga_description');
          $url         = get_sub_field('paslauga_url');
        ?>
          <div class="col-12 col-md-6 col-lg-4 mb-4">
            <?php if ( $url ): ?>
              <a href="<?php echo esc_url($url); ?>"
                 class="paslauga-card d-block h-100 text-decoration-none">
            <?php endif; ?>

              <div class="paslauga-image-card shadow-sm">
                <?php if ( $image ): ?>
                  <img src="<?php echo esc_url($image); ?>"
                       class="paslauga-image">
                <?php endif; ?>

                <div class="paslauga-card-body">
                  <?php if ( $title ): ?>
                    <h5 class="paslauga-card-title">
                      <?php echo esc_html($title); ?>
                    </h5>
                  <?php endif; ?>

                  <?php if ( $description ): ?>
                    <p class="paslauga-card-text">
                      <?php echo wp_kses_post( wp_trim_words( $description, 20, '…' ) ); ?>
                    </p>
                  <?php endif; ?>
				  <span class="paslauga-more-btn btn btn-primary">
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
