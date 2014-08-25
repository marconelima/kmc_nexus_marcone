<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'footer_most_popular_load_widgets' );

/**
 * Register our widget.
 */
function footer_most_popular_load_widgets() {
	register_widget('wpspace_popular_posts_widget');
}

/**
 * Recent_blogposts Widget class.
 */
class wpspace_popular_posts_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function wpspace_popular_posts_widget() {
		/* Widget settings. */
		$widget_ops = array('classname' => 'widget_popular_posts', 'description' => __('The most popular and most commented blog posts', 'wpspace'));

		/* Widget control settings. */
		$control_ops = array('width' => 200, 'height' => 250, 'id_base' => 'wpspace-popular-posts-widget');

		/* Create the widget. */
		$this->WP_Widget('wpspace-popular-posts-widget', __('WP Space - Most Popular & Commented Posts', 'wpspace'), $widget_ops, $control_ops);
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget($args, $instance) {
		extract($args);

		global $wp_query, $post;

		/* Our variables from the widget settings. */
		$title = array(
			apply_filters('widget_title', isset($instance['title_popular']) ? $instance['title_popular'] : ''),
			apply_filters('widget_title', isset($instance['title_commented']) ? $instance['title_commented'] : '')
		);
		$number = isset($instance['number']) ? (int) $instance['number'] : '';
		$show_date = isset($instance['show_date']) && (int) $instance['show_date'] > 0 ? true : false;
		$show_image = isset($instance['show_image']) && (int) $instance['show_image'] > 0 ? true : false;
		$show_author = isset($instance['show_author']) && (int) $instance['show_author'] > 0 ? true : false;
		$show_counters = isset($instance['show_counters']) && (int) $instance['show_counters'] > 0 ? true : false;

		$mult = min(2, max(1, get_theme_option("retina_ready")));
		
		$output = $tabs = '';

		for ($i=0; $i<2; $i++) {

			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'post_password' => '',
				'posts_per_page' => $number*2,
				'ignore_sticky_posts' => 1,
				'order' => 'DESC',
			);
			if ($i==0) {		// Most popular
				$args['meta_key'] = 'post_views_count';
				$args['orderby'] = 'meta_value_num';
			} else {			// Most commented
				$args['orderby'] = 'comment_count';
			}
			$ex = get_theme_option('blog_exclude_cats');
			if (!empty($ex)) {
				$args['category__not_in'] = explode(',', $ex);
			}
			query_posts($args); 
			
			/* Loop posts */
			if (have_posts()) {
				$tabs .= '<a href="#' . $i . '"><span>'.$title[$i].'</span></a>';
				$output .= '
					<div class="tab_content" id="' . $i . '">
				';
				$post_number = 0;
				while (have_posts()) {
					the_post();
	
					if ($post->post_date > date('Y-m-d 23:59:59') && $post->post_date_gmt > date('Y-m-d 23:59:59')) continue;
					
					$post_number++;
			
					$post_id = get_the_ID();
					$post_title = $post->post_title;
					$post_link = get_permalink();
					
					$output .= '
						<div class="post_item' . ($post_number==1 ? ' first' : '') . '">
							<h4 class="post_title"><a href="' . $post_link . '">' . $post_title . '</a></h4>
					';
					if ($show_author) {
						$post_author_id   = $post->post_author;
						$post_author_name = get_the_author_meta('display_name', $post_author_id);
						$post_author_url  = get_author_posts_url($post_author_id, '');
						$output .= '
										<div class="post_author">' . __('By:', 'wpspace') . ' <a href="' . $post_author_url . '">' . $post_author_name . '</a></div>
						';
					}
					if ($show_date || $show_counters) {
						$output .= '
										<div class="post_info">
						';
					}
					if ($show_date) {
						$post_date = date(get_option('date_format'), strtotime($post->post_date));
						$output .= '
											<span class="post_date">' . $post_date . '</span>
						';
						if ($show_counters) {
							$output .= '
											<span class="post_info_delimiter"></span>
							';
						}
					}
					if ($show_counters) {
						if ($i==0) {
							$post_counters = getPostViews($post_id);
							$post_comments_link = $post_link;
						} else {
							$post_counters = get_comments_number();
							$post_comments_link = get_comments_link( $post_id );
						}
						$output .= '
											<span class="post_comments"><a href="'.$post_comments_link.'"><span class="icon-' . ($i==0 ? 'eye' : 'comment') . '"></span><span class="post_comments_number">' . $post_counters . '</span></a></span>
						';
					}
					if ($show_date || $show_counters) {
						$output .= '
										</div>
						';
					}
					$output .= '
						</div>
					';
					if ($post_number >= $number) break;
				}
				$output .= '
					</div>
				';
			}
		}


		/* Restore main wp_query and current post data in the global var $post */
		wp_reset_query();
		wp_reset_postdata();

		
		if (!empty($output)) {
			/* Before widget (defined by themes). */			
			echo $before_widget;		
			
			/* Display the widget title if one was input (before and after defined by themes). */
			//echo $before_title . $title . $after_title;		
	
			echo '
				<div class="popular_and_commented_tabs">
					<div class="tabs">
						' . $tabs . '
					</div>
					' . $output . '
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery(\'.popular_and_commented_tabs\').tabs(\'div.tab_content\', {
								tabs: \'div.tabs a\',
								initialIndex: 0
							});
						});
					</script>
				</div>
			';
			
			/* After widget (defined by themes). */
			echo $after_widget;
		}
	}

	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		/* Strip tags for title and comments count to remove HTML (important for text inputs). */
		$instance['title_popular'] = strip_tags($new_instance['title_popular']);
		$instance['title_commented'] = strip_tags($new_instance['title_commented']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = (int) $new_instance['show_date'];
		$instance['show_author'] = (int) $new_instance['show_author'];
		$instance['show_counters'] = (int) $new_instance['show_counters'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance) {
 		/* Set up some default widget settings. */
		$defaults = array('title_popular' => '', 'title_commented' => '', 'number' => '4', 'show_date' => '1', 'show_image' => '1', 'show_author' => '1', 'show_counters' => '1', 'description' => __('The most popular & commented posts', 'wpspace'));
		$instance = wp_parse_args((array) $instance, $defaults); 
		$title_popular = isset($instance['title_popular']) ? $instance['title_popular'] : '';
		$title_commented = isset($instance['title_commented']) ? $instance['title_commented'] : '';
		$number = isset($instance['number']) ? $instance['number'] : '';
		$show_date = isset($instance['show_date']) ? $instance['show_date'] : '';
		$show_author = isset($instance['show_author']) ? $instance['show_author'] : '';
		$show_counters = isset($instance['show_counters']) ? $instance['show_counters'] : '';
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title_popular'); ?>"><?php _e('Most popular tab title:', 'wpspace'); ?></label>
			<input id="<?php echo $this->get_field_id('title_popular'); ?>" name="<?php echo $this->get_field_name('title_popular'); ?>" value="<?php echo $title_popular; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('title_commented'); ?>"><?php _e('Most commented tab title:', 'wpspace'); ?></label>
			<input id="<?php echo $this->get_field_id('title_commented'); ?>" name="<?php echo $this->get_field_name('title_commented'); ?>" value="<?php echo $title_commented; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number posts to show:', 'wpspace'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $number; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('show_author'); ?>_1"><?php _e('Show post author:', 'wpspace'); ?></label><br />
			<input type="radio" id="<?php echo $this->get_field_id('show_author'); ?>_1" name="<?php echo $this->get_field_name('show_author'); ?>" value="1" <?php echo $show_author==1 ? ' checked="checked"' : ''; ?> />
			<label for="<?php echo $this->get_field_id('show_author'); ?>_1"><?php _e('Show', 'wpspace'); ?></label>
			<input type="radio" id="<?php echo $this->get_field_id('show_author'); ?>_0" name="<?php echo $this->get_field_name('show_author'); ?>" value="0" <?php echo $show_author==0 ? ' checked="checked"' : ''; ?> />
			<label for="<?php echo $this->get_field_id('show_author'); ?>_0"><?php _e('Hide', 'wpspace'); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('show_date'); ?>_1"><?php _e('Show post date:', 'wpspace'); ?></label><br />
			<input type="radio" id="<?php echo $this->get_field_id('show_date'); ?>_1" name="<?php echo $this->get_field_name('show_date'); ?>" value="1" <?php echo $show_date==1 ? ' checked="checked"' : ''; ?> />
			<label for="<?php echo $this->get_field_id('show_date'); ?>_1"><?php _e('Show', 'wpspace'); ?></label>
			<input type="radio" id="<?php echo $this->get_field_id('show_date'); ?>_0" name="<?php echo $this->get_field_name('show_date'); ?>" value="0" <?php echo $show_date==0 ? ' checked="checked"' : ''; ?> />
			<label for="<?php echo $this->get_field_id('show_date'); ?>_0"><?php _e('Hide', 'wpspace'); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('show_counters'); ?>_1"><?php _e('Show post counters:', 'wpspace'); ?></label><br />
			<input type="radio" id="<?php echo $this->get_field_id('show_counters'); ?>_1" name="<?php echo $this->get_field_name('show_counters'); ?>" value="1" <?php echo $show_counters==1 ? ' checked="checked"' : ''; ?> />
			<label for="<?php echo $this->get_field_id('show_counters'); ?>_1"><?php _e('Show', 'wpspace'); ?></label>
			<input type="radio" id="<?php echo $this->get_field_id('show_counters'); ?>_0" name="<?php echo $this->get_field_name('show_counters'); ?>" value="0" <?php echo $show_counters==0 ? ' checked="checked"' : ''; ?> />
			<label for="<?php echo $this->get_field_id('show_counters'); ?>_0"><?php _e('Hide', 'wpspace'); ?></label>
		</p>

	<?php
	}
}

?>