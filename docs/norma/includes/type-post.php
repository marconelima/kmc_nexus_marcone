<?php
add_post_type_support( 'post', array('excerpt', 'post-formats') );

$meta_box_post = array(
	'id' => 'post-meta-box',
	'title' => __('Post Options', 'wpspace'),
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array( "name" => __('Post custom parameters', 'wpspace'),
			"std" => __('In this section you can set up custom parameters for this post', 'wpspace'),
			"type" => "info"),
		array( "name" => __('Featured icon',  'wpspace'),
			"desc" => __("Select icon to present this post", 'wpspace'),
			"id" => "page_icon",
			"std" => "",
			"type" => "icons",
			"options" => getIconsList()),
		array( "name" => __('Portfolio item additional parameters', 'wpspace'),
			"std" => __('Portfolio project details', 'wpspace'),
			"class" => "portfolio_meta",
			"type" => "info"),
		array( "name" => __('Project URL',  'wpspace'),
			"desc" => __("URL for portfolio project item", 'wpspace'),
			"id" => "portfolio_url",
			"class" => "portfolio_meta",
			"std" => "",
			"type" => "text"),
		array( "name" => __('Project date',  'wpspace'),
			"desc" => __("Release date for portfolio project item", 'wpspace'),
			"id" => "portfolio_date",
			"class" => "portfolio_meta",
			"std" => "",
			"type" => "text"),
		array( "name" => __('Project customer name',  'wpspace'),
			"desc" => __("Customer name for portfolio project item", 'wpspace'),
			"id" => "portfolio_customer",
			"class" => "portfolio_meta",
			"std" => "",
			"type" => "text"),
		array( "name" => __('Project customer url',  'wpspace'),
			"desc" => __("Customer URL for portfolio project item", 'wpspace'),
			"id" => "portfolio_customer_url",
			"class" => "portfolio_meta",
			"std" => "",
			"type" => "text"),
	)
);
add_action('admin_menu', 'add_meta_box_post');

// Add meta box
function add_meta_box_post() {
    global $meta_box_post;
    add_meta_box($meta_box_post['id'], $meta_box_post['title'], 'show_meta_box_post', $meta_box_post['page'], $meta_box_post['context'], $meta_box_post['priority']);
}

// Callback function to show fields in meta box
function show_meta_box_post() {
    global $meta_box_post, $post, $theme_options;
	
	$ajax_nonce = wp_create_nonce('ajax_nonce');
	$ajax_url = admin_url('admin-ajax.php');
	
	$custom_options = get_post_meta($post->ID, 'post_custom_options', true);

	wp_enqueue_script( '_admin', get_template_directory_uri() . '/js/_admin.js', array('jquery'), '1.0.0', true );	
	?>
    
    <script type="text/javascript">
		// AJAX fields
		ajax_url 	= "<?php echo $ajax_url; ?>";
		ajax_nonce 	= "<?php echo $ajax_nonce; ?>";
		jQuery(document).ready(function() {
			initPostDetails();
			initIconsSelector();
		});
	</script>
    
    <?php
    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_post_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	?>
   	<p class="custom_descr"><a href="#" class="custom_parameters_link"><?php _e('Show/Hide custom parameters', 'wpspace'); ?></a></p>

	<table class="form-table">

    <?php
    foreach ($meta_box_post['fields'] as $field) {
        // get current post meta data
        $meta = isset($field['id']) ? (isset($custom_options[$field['id']]) ? $custom_options[$field['id']] : get_post_meta($post->ID, $field['id'], true)) : '';
        
        echo '
			<tr class="custom_parameters_section' . (isset($field['class']) ? ' ' . $field['class'] : '') . '">
                <th style="width:20%">'
				. ($field['type']=='info' 
					? '<h4 class="custom_subtitle">' . $field['name']. '</h4>'
					: '<label for="'.(isset($field['id']) ? $field['id'] : '').'"><strong>'.$field['name'].'</strong></label>')
				.'</th>
                <td>
		';

		show_custom_field($field, $meta);

        echo '
				<td>
            </tr>
		';      
		//WP_Internal_Pointers::pointer_wp350_media();
		//WP_Internal_Pointers::pointer_wp340_choose_image_from_library();
    }

	foreach ($theme_options as $option) { 
		if (!isset($option['override']) || !in_array('post', explode(',', $option['override']))) continue;
		$id = isset($option['id']) ? get_option_name($option['id']) : '';
        $meta = isset($custom_options[$id]) ? $custom_options[$id] : get_post_meta($post->ID, $id, true);
		?>
		<tr class="custom_parameters_section<?php echo isset($option['class']) ? ' ' . $option['class'] : ''; ?>">  
			<th>
				<?php if ($option['type']=='info') { ?>
					<h4 class="custom_subtitle"><?php echo $option['name']; ?></h4>
				<?php } else { ?>
					<label for="<?php echo $id; ?>"><?php echo $option['name']; ?></label>  
				<?php } ?>
			</th>
			<td>
				<?php if ($option['type']=='info') { ?>
					<p class="custom_descr"><?php echo $option['std']; ?></p>
				<?php } else if (isset($option['options'])) { ?>
					<select size="1" name="<?php echo $id; ?>" id="<?php echo $id; ?>" style="width:150px;">
						<option value="default">Inherit</option>
						<?php echo getOptionsFromArray($option['options'], $meta); ?>
					</select>
					<p class="custom_descr"><?php echo $option['desc']; ?></p>
				<?php } else { ?>
					<input type="text" name="<?php echo $id; ?>" id="<?php echo $id; ?>" style="width:150px;" value="<?php echo $meta=='default' ? '' : $meta; ?>" />
				<?php } ?>
			</td>
		</tr>  
		<?php  
	}
    
    echo '</table>';
}

add_action('save_post', 'save_meta_box_post');


// Save data from meta box
function save_meta_box_post($post_id) {
    global $meta_box_post, $theme_options;
    
    // verify nonce
    if (!isset($_POST['meta_box_post_nonce']) || !wp_verify_nonce($_POST['meta_box_post_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } else if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
    
	$custom_options = array();
	
    foreach ($meta_box_post['fields'] as $field) {
		if (!isset($field['id'])) continue;
        $new = isset($_POST[$field['id']]) ? $_POST[$field['id']] : '';
		$custom_options[$field['id']] = $new ? $new : 'default';
    }

	foreach ($theme_options as $option) { 
		if (!isset($option['override']) || !in_array('post', explode(',', $option['override']))) continue;
		if (!isset($option['id'])) continue;
		$id = get_option_name($option['id']);
        $new = isset($_POST[$id]) ? $_POST[$id] : '';
		$custom_options[$id] = $new ? $new : 'default';
	}
	
	update_post_meta($post_id, 'post_custom_options', $custom_options);
}
?>