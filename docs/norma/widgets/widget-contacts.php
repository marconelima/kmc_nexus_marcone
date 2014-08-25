<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'wpspace_contacts_load_widgets' );

/**
 * Register our widget.
 */
function wpspace_contacts_load_widgets() {
	register_widget( 'wpspace_contacts_widget' );
}

/**
 * flickr Widget class.
 */
class wpspace_contacts_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function wpspace_contacts_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_contacts', 'description' => __('Show your contacts', 'wpspace') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'wpspace-contacts-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'wpspace-contacts-widget', __('WP Space - Contacts', 'wpspace'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$address = get_theme_option('contacts_address');
		$phone = get_theme_option('contacts_phone');
		$fax = get_theme_option('contacts_fax');
		$email = get_theme_option('contacts_email');
		$site = get_theme_option('contacts_site');
		
		
		/* Before widget (defined by themes). */			
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;
		
		?>
		<div class="widget_inner">
			<?php if (!empty($address)) { ?><div class="contacts_address"><?php echo $address; ?></div><?php } ?>
			<?php if (!empty($phone)) { ?><div class="contacts_phone"><span class="icon-phone"></span><?php echo $phone; ?></div><?php } ?>
			<?php if (!empty($fax)) { ?><div class="contacts_fax"><span class="icon-print"></span><?php echo $fax; ?></div><?php } ?>
			<?php if (!empty($email)) { ?><div class="contacts_email"><span class="icon-mail"></span><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></div><?php } ?>
			<?php if (!empty($site)) { ?><div class="contacts_site"><span class="icon-globe"></span><a href="<?php echo $site; ?>" target="_blank"><?php echo $site; ?></a></div><?php } ?>
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
		$defaults = array( 'title' => '', 'description' => __('Show contacts', 'wpspace') );
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