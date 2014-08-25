<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'wpspace_contact_form_load_widgets' );

/**
 * Register our widget.
 */
function wpspace_contact_form_load_widgets() {
	register_widget('wpspace_contact_form_widget');
}

/**
 * Widget class.
 */
class wpspace_contact_form_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function wpspace_contact_form_widget() {
		/* Widget settings. */
		$widget_ops = array('classname' => 'widget_contact_form', 'description' => __('Contact form', 'wpspace'));

		/* Widget control settings. */
		$control_ops = array('width' => 200, 'height' => 250, 'id_base' => 'wpspace-contact-form-widget');

		/* Create the widget. */
		$this->WP_Widget('wpspace-contact-form-widget', __('WP Space - Contact form', 'wpspace'), $widget_ops, $control_ops);
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget($args, $instance) {
		extract($args);

		wp_enqueue_script( 'contact_form', get_template_directory_uri().'/js/contact-form.js', array('jquery'), '1.0.0', true );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');

		/* Before widget (defined by themes). */			
		echo $before_widget;		

		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;		
		
		global $ajax_nonce, $ajax_url;
		?>
		<div class="sc_contact_form">
			<form method="post" action="<?php echo $ajax_url; ?>">
				<div class="field"><input type="text" id="sc_contact_form_username" name="username" placeholder="<?php _e('Your name*', 'wpspace'); ?>" /></div>
				<div class="field"><input type="text" id="sc_contact_form_email" name="email" placeholder="<?php _e('Your email*', 'wpspace'); ?>" /></div>
				<div class="field message"><textarea id="sc_contact_form_message" name="message" placeholder="<?php _e('Your message*', 'wpspace'); ?>"></textarea></div>
				<div class="button"><a href="#"><span><?php _e('Send', 'wpspace'); ?></span></a></div>
				<div class="result sc_infobox"></div>
			</form>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery(".sc_contact_form .button a").click(function(e){
					userSubmitForm(jQuery(this).parents('form'), '<?php echo $ajax_url; ?>', '<?php echo $ajax_nonce; ?>');
					e.preventDefault();
					return false;
				});
			});
		</script>
		<?php
		
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

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance) {

		/* Set up some default widget settings. */
		$defaults = array('title' => '', 'description' => __('The contact form', 'wpspace'));
		$instance = wp_parse_args((array) $instance, $defaults); 
		$title = isset($instance['title']) ? $instance['title'] : '';
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpspace'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" style="width:100%;" />
		</p>
	<?php
	}
}
?>