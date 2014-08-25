<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'wpspace_recent_posts_load_widgets' );

/**
 * Register our widget.
 */
function wpspace_recent_posts_load_widgets() {
	register_widget('wpspace_recent_posts_widget');
}

/**
 * Recent_blogposts Widget class.
 */
class wpspace_recent_posts_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function wpspace_recent_posts_widget() {
		/* Widget settings. */
		$widget_ops = array('classname' => 'widget_recent_posts', 'description' => __('The recent blog posts', 'wpspace'));

		/* Widget control settings. */
		$control_ops = array('width' => 200, 'height' => 250, 'id_base' => 'wpspace-recent-posts-widget');

		/* Create the widget. */
		$this->WP_Widget('wpspace-recent-posts-widget', __('WP Space - Recent Blog Posts', 'wpspace'), $widget_ops, $control_ops);
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget($args, $instance) {
		extract($args);

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		$number = isset($instance['number']) ? ($instance['number'] < 1 ? 4 : $instance['number']) : 4;
		$show_date = isset($instance['show_date']) && (int) $instance['show_date'] > 0 ? true : false;
		$show_image = isset($instance['show_image']) && (int) $instance['show_image'] > 0 ? true : false;
		$show_author = isset($instance['show_author']) && (int) $instance['show_author'] > 0 ? true : false;
		$show_comments = isset($instance['show_comments']) && (int) $instance['show_comments'] > 0 ? true : false;

		$mult = min(2, max(1, get_theme_option("retina_ready")));
		$counters = get_theme_option("blog_counters");

		/* Before widget (defined by themes). */			
		echo $before_widget;		

		$output = '';		
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) $output .= $before_title . $title . $after_title;		
		
		$args = array(
			'numberposts' => $number*2,
			'offset' => 0,
			'category' => 0,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_type' => 'post',
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'suppress_filters' => true 
    	);
		$ex = get_theme_option('blog_exclude_cats');
		if (!empty($ex)) {
			$args['category__not_in'] = explode(',', $ex);
		}

    	$recent_posts = wp_get_recent_posts($args);

		$post_number = 0;
		foreach ($recent_posts as $post) {
			if ($post['post_date'] > date('Y-m-d 23:59:59') && $post['post_date_gmt'] > date('Y-m-d 23:59:59')) continue;
			$post_id = $post['ID'];
			$post_title = $post['post_title'];
			$post_link = get_permalink($post_id);
			$output .= '
						<div class="post_item' . ($post_number==0 ? ' first' : '') . '">
						';
			if ($show_image) {
				$post_thumb = getResizedImageTag($post_id, 73*$mult, 44*$mult);
				if ($post_thumb) {
					$output .= '
							<div class="pic_wrapper image_wrapper">' . $post_thumb . '</div>
					';
				}
			}
			$output .= '
							<div class="post_wrapper">
								<h4 class="post_title"><a href="' . $post_link . '">' . $post_title . '</a></h4>
			';
			if ($show_author) {
				$post_author_id   = $post['post_author'];
				$post_author_name = get_the_author_meta('display_name', $post_author_id);
				$post_author_url  = get_author_posts_url($post_author_id, '');
				$output .= '
								<div class="post_author">' . __('By:', 'wpspace') . ' <a href="' . $post_author_url . '">' . $post_author_name . '</a></div>
				';
			}
			if ($show_date || $show_comments) {
				$output .= '
								<div class="post_info">
				';
			}
			if ($show_date) {
				$post_date = date(get_option('date_format'), strtotime($post['post_date']));
				$output .= '
									<span class="post_date">' . $post_date . '</span>
				';
				if ($show_comments) {
					$output .= '
									<span class="post_info_delimiter"></span>
					';
				}
			}
			if ($show_comments) {
				$post_comments = $counters=='comments' ? get_comments_number($post_id) : getPostViews($post_id);
				$post_comments_link = $counters=='comments' ? get_comments_link( $post_id ) : $post_link;
				$output .= '
									<span class="post_comments"><a href="'.$post_comments_link.'"><span class="icon-'.($counters=='comments' ? 'comment' : 'eye').'"></span><span class="post_comments_number">' . $post_comments . '</span></a></span>
				';
			}
			if ($show_date || $show_comments) {
				$output .= '
								</div>
				';
			}
			$output .= '
							</div>
						</div>
			';
			$post_number++;
			if ($post_number >= $number) break;
		}

		echo $output;
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		/* Strip tags for title and comments count to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = (int) $new_instance['show_date'];
		$instance['show_image'] = (int) $new_instance['show_image'];
		$instance['show_author'] = (int) $new_instance['show_author'];
		$instance['show_comments'] = (int) $new_instance['show_comments'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance) {

		/* Set up some default widget settings. */
		$defaults = array('title' => '', 'number' => '4', 'show_date' => '1', 'show_image' => '1', 'show_author' => '1', 'show_comments' => '1', 'description' => __('The recent blog posts', 'wpspace'));
		$instance = wp_parse_args((array) $instance, $defaults); 
		$title = isset($instance['title']) ? $instance['title'] : '';
		$number = isset($instance['number']) ? $instance['number'] : '';
		$show_date = isset($instance['show_date']) ? $instance['show_date'] : '';
		$show_image = isset($instance['show_image']) ? $instance['show_image'] : '';
		$show_author = isset($instance['show_author']) ? $instance['show_author'] : '';
		$show_comments = isset($instance['show_comments']) ? $instance['show_comments'] : '';
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpspace'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number posts:', 'wpspace'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $number; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('show_image'); ?>_1"><?php _e('Show post image:', 'wpspace'); ?></label><br />
			<input type="radio" id="<?php echo $this->get_field_id('show_image'); ?>_1" name="<?php echo $this->get_field_name('show_image'); ?>" value="1" <?php echo $show_image==1 ? ' checked="checked"' : ''; ?> />
			<label for="<?php echo $this->get_field_id('show_image'); ?>_1"><?php _e('Show', 'wpspace'); ?></label>
			<input type="radio" id="<?php echo $this->get_field_id('show_image'); ?>_0" name="<?php echo $this->get_field_name('show_image'); ?>" value="0" <?php echo $show_image==0 ? ' checked="checked"' : ''; ?> />
			<label for="<?php echo $this->get_field_id('show_image'); ?>_0"><?php _e('Hide', 'wpspace'); ?></label>
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
			<label for="<?php echo $this->get_field_id('show_comments'); ?>_1"><?php _e('Show post counters:', 'wpspace'); ?></label><br />
			<input type="radio" id="<?php echo $this->get_field_id('show_comments'); ?>_1" name="<?php echo $this->get_field_name('show_comments'); ?>" value="1" <?php echo $show_comments==1 ? ' checked="checked"' : ''; ?> />
			<label for="<?php echo $this->get_field_id('show_comments'); ?>_1"><?php _e('Show', 'wpspace'); ?></label>
			<input type="radio" id="<?php echo $this->get_field_id('show_comments'); ?>_0" name="<?php echo $this->get_field_name('show_comments'); ?>" value="0" <?php echo $show_comments==0 ? ' checked="checked"' : ''; ?> />
			<label for="<?php echo $this->get_field_id('show_comments'); ?>_0"><?php _e('Hide', 'wpspace'); ?></label>
		</p>
	<?php
	}
}
?>