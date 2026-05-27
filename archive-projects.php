<div class="projects-intro d-flex">
  <div class="container mt-auto mb-auto">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-7 col-xl-5  text-center">
        <?php if (get_field('projects_intro_heading', 'options')) { ?>
          <h1
            class="projects-intro__heading c-white h3 mb-40 mb-md-30"><?php the_field('projects_intro_heading', 'options'); ?></h1>
        <?php } ?>
        <?php if (get_field('projects_intro_text', 'options')) { ?>
          <div
            class="projects-intro__text fs-md-20 c-white"><?php the_field('projects_intro_text', 'options'); ?></div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<div class="projects-list pt-50 pt-md-120 mb-150">
  <div class="container">
    <div class="row justify-content-center mb-60 mb-md-90">
      <div class="col-12 col-md-10 col-lg-7 col-xl-5  text-center">
        <?php if (get_field('projects_about_heading', 'options')) { ?>
          <h3 class="projects-list__heading mb-20"><?php the_field('projects_about_heading', 'options'); ?></h3>
        <?php } ?>
        <?php if (get_field('projects_about_text', 'options')) { ?>
          <div
            class="projects-list__text"><?php the_field('projects_about_text', 'options'); ?></div>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="container container--no-right">


    <div class="row justify-content-center mb-40">
      <div class="col-12 col-lg-10 col-xl-7 text-center  projects-categories">
        <?php
        $taxonomies = get_object_taxonomies('projects');
        $terms = get_terms(array(
          'taxonomy' => 'projects_category',
          'hide_empty' => true,
        ));
        ?>
        <div class="mb-20 mb-lg-40 d-flex flex-wrap flex-xl-nowrap justify-content-center align-items-center " id="categoriesButtons">
          <div class="d-inline-block mr-md-10 ml-md-10 text-center">
            <div class="projects-category active" data-cat="0" data-slide="0">Visi projektai</div>
          </div>
          <?php foreach ($terms as $index => $term) { ?>
            <div class="d-inline-block mr-md-10 ml-md-10 text-center">
              <div class="projects-category" data-cat="<?php echo $term->term_id ?>"
                   data-slug="<?php echo $term->slug ?>"
                   data-slide="<?php echo $index + 1; ?>">
                <?php echo $term->name; ?>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <?php get_template_part('includes/projects-cards'); ?>
  </div>
</div>

<?php get_template_part('includes/main-form'); ?>



<style>
  @media only screen and (max-width: 768px) {
    .projects-intro {
    <?php if (get_field('projects_intro_img_mobile', 'options'))  { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('projects_intro_img_mobile', 'options'), 'full') ?>);
    <?php } else { ?>
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('projects_intro_img', 'options'), 'full') ?>);
    <?php } ?>
    }
  }

  @media only screen and (min-width: 769px) {
    .projects-intro {
      background-image: url(<?php echo wp_get_attachment_image_url(get_field('projects_intro_img', 'options'), 'full') ?>);
    }
</style>
