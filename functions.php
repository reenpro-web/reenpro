<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);


if (function_exists('acf_add_options_page')) {


  acf_add_options_page(array(
    'page_title' => 'Global Options',
    'menu_title' => 'Global Options',
    'menu_slug' => 'global-options',
    'capability' => 'edit_posts',
    'redirect' => false,
    'icon_url' => false,

  ));

  acf_add_options_page(array(
    'page_title' => 'Header',
    'menu_title' => 'Header',
    'menu_slug' => 'global-options-header',
    'capability' => 'edit_posts',
    'parent_slug' => 'global-options',
    'position' => false,
    'icon_url' => false,
  ));

  acf_add_options_page(array(
    'page_title' => 'Footer',
    'menu_title' => 'Footer',
    'menu_slug' => 'global-options-footer',
    'capability' => 'edit_posts',
    'parent_slug' => 'global-options',
    'position' => false,
    'icon_url' => false,
  ));

  acf_add_options_page(array(
    'page_title' => 'Įranga',
    'menu_title' => 'Įranga',
    'menu_slug' => 'global-options-products',
    'capability' => 'edit_posts',
    'parent_slug' => 'global-options',
    'position' => false,
    'icon_url' => false,
  ));

}

add_action('after_setup_theme', 'wpdocs_theme_setup');
function wpdocs_theme_setup()
{
  add_image_size('blog_card', 410, 242, true);
  add_image_size('home_logos', 338, 82, true);
  add_image_size('about-cards-new', 540, 960, true);
  add_image_size('projects-cards', 768, 400, true);
  add_image_size('projects-cards-mobile', 329, 329, true);
  add_image_size('projects-cards-small', 369, 299, true);
  add_image_size('docks-cards', 369, 396, true);
  add_image_size('docks-donation', 768, 362, true);
  add_image_size('calc-img', 468, 264, true);
  add_image_size('gallery_img', 635, 500, true);

}


// Register additional menus

if (!function_exists('mytheme_register_nav_menu')) {

  function mytheme_register_nav_menu()
  {
    register_nav_menus(array(
      'footer_1' => __('CMS Menu', 'reenpro'),
      'footer_2' => __('CMS Menu 2', 'reenpro'),
    ));
  }

  add_action('after_setup_theme', 'mytheme_register_nav_menu', 0);
}


function fetch_project_items()
{
  $category = $_GET['category'];
  $args = array(
    'post_type' => 'projects',
    'post_status' => 'publish',
    'posts_per_page' => -1, // Fetch all posts
    'orderby' => 'date',
    'order' => 'DESC',
  );

  if ($category !== '0') {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'projects_category',
        'field' => 'term_id',
        'terms' => $category,
      ),
    );
  }

  $query = new WP_Query($args); ?>
  <?php if ($query->have_posts()) {
  ob_start();
  $projectCounter = 0;
  while ($query->have_posts()) : $query->the_post();
    if ($projectCounter >= 6) {
      $hiddenClass = 'd-none';
    }
    ?>
    <div class="projects-wrapper mb-50 mb-md-80  project-item cat-0 cat-<?php echo $category; ?>  <?php echo $hiddenClass; ?>">
      <?php get_template_part('ajax-data/projects-slider', null, ['postNo' => $projectCounter]); ?>
    </div>
    <?php $projectCounter++; endwhile;
  wp_reset_postdata();
  $response = ob_get_clean();
} else {
  $response = 'No project items found';
} ?>

  <?php echo $response;
  die();
}

add_action('wp_ajax_fetch_project_items', 'fetch_project_items');
add_action('wp_ajax_nopriv_fetch_project_items', 'fetch_project_items');


//function dynamic_values($tag, $unused)
//{
//
//
//  if ($tag['name'] === 'taxonomy-select') {
//    $args = array(
//      'orderby' => 'name',
//      'order'   => 'ASC',
//      'hide_empty' => true,
//    );
//
//    $custom_taxonomies = get_terms(array(
//      'taxonomy' => 'projects_category',
//      'hide_empty' => true,
//    ));
//
//    if (!is_wp_error($custom_taxonomies)) {
//      foreach ($custom_taxonomies as $custom_taxonomy) {
//        $tag['raw_values'][] = $custom_taxonomy->name;
//        $tag['values'][] = $custom_taxonomy->term_id;
//        $tag['labels'][] = $custom_taxonomy->name;
//      }
//    }
//  }
//
//  if ($tag['name'] === 'post-select') {
//    $args = array(
//      'numberposts'   => -1,
//      'post_type'     => 'projects',
//      'orderby'       => 'title',
//      'order'         => 'ASC',
//    );
//
//    $custom_posts = get_posts($args);
//
//    if ($custom_posts) {
//      foreach ($custom_posts as $custom_post) {
//        $tag['raw_values'][] = $custom_post->post_title;
//        $tag['values'][] = $custom_post->ID;
//        $tag['labels'][] = $custom_post->post_title;
//      }
//    }
//  }
//
//  return $tag;
//}
//
//add_filter('wpcf7_form_tag', 'dynamic_values', 10, 2);


//add_filter('wpcf7_form_elements', 'imp_wpcf7_form_elements');
//function imp_wpcf7_form_elements($content)
//{
//  $str_pos = strpos($content, ' name="post-select"'); //name='yourfield name'
//  if ($str_pos !== false) {
//    $options = get_posts(array(
//      'numberposts'   => -1,
//      'post_type'     => 'projects',
//      'orderby'       => 'title',
//      'order'         => 'ASC',
//    ));
//    $additional_attributes = '';
//    foreach ($options as $option) {
//      $additional_attributes .= '<option value="' . $option->post_title . '" data-post-id="' . $option->ID . '">' . $option->post_title . '</option>';
//    }
//    $content = substr_replace($content, $additional_attributes, $str_pos + 6, 0);
//  }
//  return $content;
//}


//add_filter( 'wpcf7_form_elements', 'imp_wpcf7_form_elements' );
//function imp_wpcf7_form_elements( $content ) {
//  $str_pos = strpos( $content, 'name="your-name"' );
//  if ( $str_pos !== false ) {
//    $content = substr_replace( $content, ' data-attr="custom" data-msg="Foo Bar 1" ', $str_pos, 0 );
//  }
//  return $content;
//}

function enqueue_theme_scripts() {
    wp_enqueue_script('infinite-scroll', get_template_directory_uri() . '/js/infinite-scroll.js', array('jquery'), null, true);
    wp_localize_script('infinite-scroll', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
	 wp_enqueue_script(
        'jquery-forms-alph-sort',
        get_stylesheet_directory_uri() . '/js/jquery-forms-alph-sort.js',
        array('jquery'),
        null,
        true 
    );
	 wp_enqueue_script(
        'edit-contact-forms.js',
        get_stylesheet_directory_uri() . '/js/edit-contact-forms.js',
        array('jquery'),
        null,
        true 
    );
	wp_enqueue_script(
        'edit-modal-contact-forms.js',
        get_stylesheet_directory_uri() . '/js/edit-modal-contact-forms.js',
        array('jquery'),
        null,
        true 
    );
  	wp_enqueue_script( 'slick-js',
    'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
    array('jquery'),
    '1.8.1',
    true
  	);
	wp_enqueue_script(
	  'main-page-banner-slick.js',
	  get_stylesheet_directory_uri() . '/js/main-page-banner-slick.js',
	  array('jquery','slick-js','sage/js'),
	  null,
	  true
	);
	wp_enqueue_script(
	  'scroll-to-form.js',
	  get_stylesheet_directory_uri() . '/js/scroll-to-form.js',
	  array('jquery','slick-js','sage/js'),
	  null,
	  true
	);
	wp_enqueue_script(
	  'open-bess-form.js',
	  get_stylesheet_directory_uri() . '/js/open-bess-form.js',
	  array('jquery','slick-js','sage/js'),
	  null,
	  true
	);
}
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');


add_filter('wp_nav_menu_objects', 'mlnc_wp_nav_menu_objects', 10, 2);

function mlnc_wp_nav_menu_objects($items, $args) {
  // loop
  foreach ($items as $item) {
    // vars
    $your_field = get_field('menu_img', $item);

    // append field
    if ($your_field) {
      $image_tag = '<img src="' . esc_url($your_field) . '" alt="' . esc_attr($item->title) . '" />';
      $item->title = $image_tag . '<span>' . $item->title . '</span>';
    }
  }
  // return
  return $items;
}




//custom admin logo

function my_login_logo()
{ ?>
  <style type="text/css">
    #login h1 a, .login h1 a {
      background-size: 100%;
      width: 100%;
      background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/dist/images/logo-color.svg");
    }
  </style>
<?php }

add_action('login_enqueue_scripts', 'my_login_logo');

function my_login_logo_url()
{
  return home_url();
}

add_filter('login_headerurl', 'my_login_logo_url');



//add_action('wpcf7_posted_data', 'modify_cf7_posted_data');
//
//function modify_cf7_posted_data($posted_data) {
//  if (isset($posted_data['radio'])) {
//    $posted_data['radio'] = sanitize_field($posted_data['radio']);
//  }
//
//  if (isset($posted_data['your-name'])) {
//    $posted_data['your-name'] = sanitize_field($posted_data['your-name']);
//  }
//
//  if (isset($posted_data['your-tel'])) {
//    $posted_data['your-tel'] = sanitize_field($posted_data['your-tel']);
//  }
//
//  if (isset($posted_data['your-city'])) {
//    $posted_data['your-city'] = sanitize_field($posted_data['your-city']);
//  }
//
//  if (isset($posted_data['sprendimas'])) {
//    $posted_data['sprendimas'] = sanitize_field($posted_data['sprendimas']);
//  }
//
//  if (isset($posted_data['your-power'])) {
//    $posted_data['your-power'] = sanitize_field($posted_data['your-power']);
//  }
//
//  if (isset($posted_data['your-address'])) {
//    $posted_data['your-address'] = sanitize_field($posted_data['your-address']);
//  }
//
//  if (isset($posted_data['apva'])) {
//    $posted_data['apva'] = sanitize_field($posted_data['apva']);
//  }
//
//  if (isset($posted_data['your-textarea'])) {
//    $posted_data['your-textarea'] = sanitize_field($posted_data['your-textarea']);
//  }
//
//  if (isset($posted_data['acceptance-71'])) {
//    $posted_data['acceptance-71'] = sanitize_field($posted_data['acceptance-71']);
//  }
//
//  return $posted_data;
//}
//
//function sanitize_field($field_value) {
//  $replace_mapping = array(
//    'ą' => 'a',
//    'č' => 'c',
//    'ė' => 'e',
//    'ę' => 'e',
//    'š' => 's',
//    'į' => 'i',
//    'ų' => 'u',
//    'ū' => 'u',
//    'ž' => 'z',
//    ',' => ' ',
//    '.' => ' '
//  );
//
//  return str_replace(array_keys($replace_mapping), array_values($replace_mapping), $field_value);
//}
//
//

function rename_posts_menu_to_naujienos() {
    global $menu, $submenu;

    $menu[5][0] = 'Naujienos';

    if (isset($submenu['edit.php'])) {
        $submenu['edit.php'][5][0] = 'Visos naujienos';
        $submenu['edit.php'][10][0] = 'Pridėti naują';
        $submenu['edit.php'][15][0] = 'Kategorijos';
        $submenu['edit.php'][16][0] = 'Tagai';
    }
}
add_action('admin_menu', 'rename_posts_menu_to_naujienos');


function custom_external_link_metabox() {
    add_meta_box(
        'external_media_link_metabox',
        'Nuoroda į išorinį žiniasklaidos puslapį (Įdėjus nuorodą, šis įrašas taps išoriniu)',
        'render_external_link_metabox',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'custom_external_link_metabox');

function render_external_link_metabox($post) {
    $external_link = get_post_meta($post->ID, '_external_media_link', true);
    wp_nonce_field('external_link_nonce_action', 'external_link_nonce');
    ?>
    <input type="text" id="external_media_link" name="external_media_link"
           value="<?php echo esc_attr($external_link); ?>"
           style="width: 100%;">
    <?php
}

function save_external_link_metabox($post_id) {
    if (!isset($_POST['external_link_nonce']) || !wp_verify_nonce($_POST['external_link_nonce'], 'external_link_nonce_action')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['external_media_link'])) {
        update_post_meta($post_id, '_external_media_link', sanitize_text_field($_POST['external_media_link']));
    }
}
add_action('save_post', 'save_external_link_metabox');

function redirect_to_external_link() {
    if (is_single() && get_post_type() === 'post') {
        global $post;
        $external_link = get_post_meta($post->ID, '_external_media_link', true);
        if (!empty($external_link)) {
            wp_redirect(esc_url($external_link), 301);
            exit;
        }
    }
}
add_action('template_redirect', 'redirect_to_external_link');

function auto_assign_post_tags($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $external_link = get_post_meta($post_id, '_external_media_link', true);

    $current_tags = wp_get_post_tags($post_id, ['fields' => 'slugs']);

    if (!empty($external_link)) {
        if (in_array('musu-naujienos', $current_tags)) {
            wp_remove_object_terms($post_id, 'musu-naujienos', 'post_tag');
        }
        wp_set_post_tags($post_id, 'ziniasklaidoje', true);
    } else {
        if (in_array('ziniasklaidoje', $current_tags)) {
            wp_remove_object_terms($post_id, 'ziniasklaidoje', 'post_tag');
        }
        wp_set_post_tags($post_id, 'musu-naujienos', true);
    }
}
add_action('save_post', 'auto_assign_post_tags');


function load_more_posts_home() {
    $posts_per_load = isset($_POST['posts_per_load']) ? intval($_POST['posts_per_load']) : 3;
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $max_posts = isset($_POST['max_posts']) ? intval($_POST['max_posts']) : 0;

    // Check if offset exceeds max_posts
    if ($max_posts > 0 && $offset >= $max_posts) {
        echo json_encode(['success' => false, 'message' => 'Max posts limit reached']);
        wp_die();
    }

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_per_load,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) : $query->the_post();
            $external_link = get_post_meta(get_the_ID(), '_external_media_link', true);
            $post_link = $external_link ? esc_url($external_link) : get_permalink();
            $target = $external_link ? ' target="_blank" rel="noopener"' : '';
            ?>
            <a href="<?php echo $post_link; ?>"<?php echo $target; ?> class="single-post-row col-12 news-post-wrapper text-decoration-none">
                <div class="row post-item border-bottom pb-4 mb-4 align-items-start">
                    <div class="col-md-3 col-12 mb-3 mb-md-0 position-relative">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', ['class' => 'img-fluid rounded fixed-ratio-image']); ?>
                        <?php endif; ?>
                        <div class="post-image-overlay"></div>
                        <div class="post-tag position-absolute top-0 start-0 text-white px-2 py-1 small">
                            <?php 
                            $tags = get_the_tags();
                            if ($tags) {
                                echo esc_html($tags[0]->name);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-9 col-12">
                        <h5 class="post-title mb-2"><?php the_title(); ?></h5>
                        <p class="post-date text-muted small"><?php echo get_the_date('Y-m-d'); ?></p>
                        <div class="post-excerpt text-truncate-2"><?php echo wp_trim_words(get_the_excerpt(), 50, '...'); ?></div>
                        <span class="news-more-btn btn btn-primary button--purple">
                            <?php _e('Plačiau'); ?>
                        </span>
                    </div>
                </div>
            </a>
            <?php 
        endwhile;
        wp_reset_postdata();

        $content = ob_get_clean();

        // Check if this load reaches max_posts
        $total_loaded = $offset + $posts_per_load;
        $reached_max = $max_posts > 0 && $total_loaded >= $max_posts;

        echo json_encode([
            'success' => true,
            'content' => $content,
            'reached_max' => $reached_max
        ]);
    } else {
        echo json_encode(['success' => false]);
    }

    wp_die();
}

add_action('wp_ajax_load_more_posts_home', 'load_more_posts_home');
add_action('wp_ajax_nopriv_load_more_posts_home', 'load_more_posts_home');

function load_more_posts_single() {
    $posts_per_load = isset($_POST['posts_per_load']) ? intval($_POST['posts_per_load']) : 3;
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $max_posts = isset($_POST['max_posts']) ? intval($_POST['max_posts']) : 0;
    $current_post_id = isset($_POST['current_post_id']) ? intval($_POST['current_post_id']) : 0;
    $loaded_posts = isset($_POST['loaded_posts']) ? array_map('intval', $_POST['loaded_posts']) : [];

    // Merge already loaded posts with the current post (to avoid duplicates)
    $exclude_posts = array_merge([$current_post_id], $loaded_posts);

    if ($max_posts > 0 && $offset >= $max_posts) {
        echo json_encode(['success' => false, 'message' => 'Max posts limit reached']);
        wp_die();
    }

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_load,
        'offset'         => $offset,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post__not_in'   => $exclude_posts, // Exclude already loaded posts
        'post_status'    => 'publish'
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        $post_ids = []; // Track new posts loaded in this request

        while ($query->have_posts()) : $query->the_post();
            $post_ids[] = get_the_ID(); // Store newly loaded post IDs

            $external_link = get_post_meta(get_the_ID(), '_external_media_link', true);
            $post_link = $external_link ? esc_url($external_link) : get_permalink();
            $target = $external_link ? ' target="_blank" rel="noopener"' : '';
            ?>
            <a href="<?php echo $post_link; ?>"<?php echo $target; ?> class="other-single-post-row col-12 news-post-wrapper text-decoration-none new-post">
                <div class="row post-item border-bottom pb-4 mb-4 align-items-start">
                    <!-- Image Section -->
                    <div class="col-md-3 col-12 mb-3 mb-md-0 position-relative">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', ['class' => 'img-fluid rounded fixed-ratio-image']); ?>
                        <?php endif; ?>
                        <div class="post-image-overlay"></div>
                        <div class="post-tag position-absolute top-0 start-0 text-white px-2 py-1 small">
                            <?php 
                                $tags = get_the_tags();
                                if ($tags) {
                                    echo esc_html($tags[0]->name);
                                }
                            ?>
                        </div>
                    </div>
                    <!-- Content Section -->
                    <div class="col-md-9 col-12">
                        <h5 class="post-title mb-2"><?php the_title(); ?></h5>
                        <p class="post-date text-muted small"><?php echo get_the_date('Y-m-d'); ?></p>
                        <div class="post-excerpt text-truncate-2"><?php echo wp_trim_words(get_the_excerpt(), 50, '...'); ?></div>
                        <span class="news-more-btn btn btn-primary button--purple"><?php _e('Plačiau'); ?></span>
                    </div>
                </div>
            </a>
            <?php
        endwhile;
        wp_reset_postdata();

        $content = ob_get_clean();
        $total_loaded = $offset + $posts_per_load;
        $reached_max = $max_posts > 0 && $total_loaded >= $max_posts;

        echo json_encode([
            'success' => true,
            'content' => $content,
            'post_ids' => $post_ids, // Send back the loaded post IDs
            'reached_max' => $reached_max
        ]);
    } else {
        echo json_encode(['success' => false]);
    }

    wp_die();
}

add_action('wp_ajax_load_more_posts_single', 'load_more_posts_single');
add_action('wp_ajax_nopriv_load_more_posts_single', 'load_more_posts_single');



