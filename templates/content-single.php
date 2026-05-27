<?php while (have_posts()) : the_post(); ?>
    <article <?php post_class(); ?>>
        <header>
            <?php 
            $post_featured_image = has_post_thumbnail()
                ? get_the_post_thumbnail_url(get_the_ID(), "full")
                : ""; 
            ?>
            <div class="single-post-intro" style="background-image: url('<?php echo esc_url($post_featured_image); ?>'); 
                <?php echo $post_featured_image ? "background-size: cover; background-position: center;" : ""; ?>">
                
                <div id = "single-post-intro-container" class="container">
                    <div>
                        <?php 
                        $tags = get_the_tags();
                        if ($tags) : ?>
                            <div class="single-post-tag position-absolute top-0 start-0 text-white px-2 py-1 small">
                                <?php echo esc_html($tags[0]->name); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($news_heading = get_the_title()): ?>
                            <h1 class="single-post-heading c-white w-100">
                                <?php echo esc_html($news_heading); ?>
                            </h1>
                        <?php endif; ?>
                        
                        <p class="single-post-date small c-white">
                            <?php echo get_the_date("Y-m-d"); ?>
                        </p>
                        
                        <?php if (has_excerpt()): ?>
                            <div class="single-post-excerpt c-white">
                                <?php echo get_the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>
	

		<div id="the-content-container" class="container entry-content single-post-content pt-75 pb-80 pb-md-120">
			<?php 
			$content = get_the_content();
			$content = apply_filters('the_content', $content);

			libxml_use_internal_errors(true);
			$dom = new DOMDocument();
			$dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
			libxml_clear_errors();

			$xpath = new DOMXPath($dom);
			$headings = $xpath->query('//h2 | //h3 | //h4 | //h5 | //h6');

			if ($headings->length > 0) {
			echo '<h2 class="single-blog-post-table-heading">Turinys</h2>';
			echo '<div class="single-post-table-of-contents">';
				echo '<ul class="toc-list">';

				$used_ids = array();

				foreach ($headings as $heading) {
					$tagName = $heading->nodeName;
					$title = trim($heading->textContent);
					if (empty($title)) {
						continue;
					}

					$id = $heading->getAttribute('id');
					if (!$id) {
						$id = sanitize_title($title);
						$original_id = $id;
						$i = 1;
						while (in_array($id, $used_ids)) {
							$id = $original_id . '-' . $i;
							$i++;
						}
						$heading->setAttribute('id', $id);
						$used_ids[] = $id;
					} else {
						$used_ids[] = $id;
					}

					echo '<li class="toc-item toc-' . esc_attr($tagName) . '">';
						echo '<a href="#' . esc_attr($id) . '">' . esc_html($title) . '</a>';
					echo '</li>';
				}

				echo '</ul>';
			echo '</div>';
		}


			$body = $dom->getElementsByTagName('body')->item(0);
			$updated_content = '';
			foreach ($body->childNodes as $child) {
				$updated_content .= $dom->saveHTML($child);
			}
			echo $updated_content;
			?>
		</div>
		<?php if ( is_single() ) : ?>
			<script>
			document.addEventListener("DOMContentLoaded", function() {
				const tocLinks = document.querySelectorAll('.single-post-table-of-contents a');
				tocLinks.forEach(link => {
					link.addEventListener('click', function(e) {
						e.preventDefault();
						const targetId = this.getAttribute('href').substring(1);
						const target = document.getElementById(targetId);
						if (target) {
							const offset = 110;
							const targetPosition = target.getBoundingClientRect().top + window.pageYOffset;
							const finalPosition = targetPosition - offset;
							window.scrollTo({
								top: finalPosition,
								behavior: 'smooth'
							});
						}
					});
				});
			});
			</script>
		<?php endif; ?>
		
		<?php get_template_part('includes/main-form'); ?>
		
		<footer id = "single-post-footer-container" class="container single-post-footer pb-80 pb-md-120">
			<h3 class="mb-md-80 mb-40 h3">Kitos naujienos</h3>
				<div id="other-news-container" class="row gy-4" data-current-post-id="<?php echo get_the_ID(); ?>">
				<?php
				// Initial Query for 3 Posts
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => 3,
					'post__not_in' => array(get_the_ID()), // Exclude current post
					'orderby' => 'date',
					'order' => 'DESC'
				);

				$query = new WP_Query($args);

				if ($query->have_posts()) :
					while ($query->have_posts()) : $query->the_post();
						$external_link = get_post_meta(get_the_ID(), '_external_media_link', true);
						$post_link = $external_link ? esc_url($external_link) : get_permalink();
						$target = $external_link ? ' target="_blank" rel="noopener"' : '';
						?>
						<a href="<?php echo $post_link; ?>"<?php echo $target; ?> 
						   class="col-12 news-post-wrapper text-decoration-none"
						   data-post-id="<?php echo get_the_ID(); ?>">
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
									<h5 class="post-title mb-2">
										<?php the_title(); ?>
									</h5>
									<p class="post-date text-muted small">
										<?php echo get_the_date('Y-m-d'); ?>
									</p>
									<div class="post-excerpt text-truncate-2">
										<?php echo wp_trim_words(get_the_excerpt(), 50, '...'); ?>
									</div>
									<span class="news-more-btn btn btn-primary button--purple">
										<?php _e('Plačiau'); ?>
									</span>
								</div>
							</div>
						</a>
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
		</footer>

    </article>
<?php endwhile; ?>
