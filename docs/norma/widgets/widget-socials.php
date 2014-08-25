<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'wpspace_social_load_widgets' );

/**
 * Register our widget.
 */
function wpspace_social_load_widgets() {
	register_widget( 'wpspace_social_widget' );
}

/**
 * flickr Widget class.
 */
class wpspace_social_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function wpspace_social_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_social', 'description' => __('Show your social links', 'wpspace') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'wpspace-social-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'wpspace-social-widget', __('WP Space - Social links', 'wpspace'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );

		/* Before widget (defined by themes). */			
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;
		
		?>
		<div class="widget_inner">
        	<?php
				global $theme_options, $shortname;
				foreach ($theme_options as $s) {
					if (!isset($s['id']) || my_substr($s['id'], my_strlen($shortname)+1, 12)!='social_links') continue;
					if (empty($s['val'])) continue;
					$soc = my_substr($s['id'], my_strlen($shortname)+1+13);
					$tmp = explode('|', $s['val']);
					?>
					<a class="social_links social_<?php echo $soc; ?>" href="<?php echo $tmp[0]; ?>"><span class="icon-<?php echo $soc; ?>"></span></a>
					<?php 
				}
			?>
		</div>

		<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'description' => __('Show social', 'wpspace') );
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		$title = isset($instance['title']) ? $instance['title'] : '';
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpspace'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}
?>