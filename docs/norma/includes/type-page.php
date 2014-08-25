<?php
//remove_post_type_support( 'page', 'comments' );
add_post_type_support( 'page', array('excerpt', 'comments') );

$meta_box_page = array(
	'id' => 'my-meta-box',
	'title' => __('Page Options', 'wpspace'),
	'page' => 'page',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array( "name" => __('Page custom parameters', 'wpspace'),
			"std" => __('In this section you can set up custom parameters for this page', 'wpspace'),
			"type" => "info"),
		array( "name" => __('Featured icon',  'wpspace'),
			"desc" => __("Select icon to present this page", 'wpspace'),
			"id" => "page_icon",
			"std" => "",
			"type" => "icons",
			"options" => getIconsList()),
	)
);
add_action('admin_menu', 'wpspace_add_box_page');

// Add meta box
function wpspace_add_box_page() {
    global $meta_box_page;
    
    add_meta_box($meta_box_page['id'], $meta_box_page['title'], 'show_meta_box_page', $meta_box_page['page'], $meta_box_page['context'], $meta_box_page['priority']);
}

// Callback function to show fields in meta box
function show_meta_box_page() {
    global $meta_box_page, $post, $theme_options;

	$custom_options = get_post_meta($post->ID, 'post_custom_options', true);
    
	wp_enqueue_script( '_admin', get_template_directory_uri() . '/js/_admin.js', array('jquery'), '1.0.0', true );	
	?>
    
    <script type="text/javascript">
		jQuery(document).ready(function() {
			initIconsSelector();
		});
	</script>
    
    <?php

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_page_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    
    ?>
   	<p class="custom_descr"><a href="#" class="custom_parameters_link"><?php _e('Show/Hide custom parameters', 'wpspace'); ?></a></p>

    <table class="form-table"><thead class="post_meta">
    <?php

    foreach ($meta_box_page['fields'] as $field) {
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

	echo '</thead><tbody class="post_settings">';

	foreach ($theme_options as $option) { 
		if (!isset($option['override']) || !in_array('page', explode(',', $option['override']))) continue;
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

    echo '</tbody></table>';
}

add_action('save_post', 'wpspace_save_data_page');

// Save data from meta box
function wpspace_save_data_page($post_id) {
    global $meta_box_page, $theme_options;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    
    // verify nonce
    if (!isset($_POST['meta_box_page_nonce']) || !wp_verify_nonce($_POST['meta_box_page_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
	$custom_options = array();
	
    foreach ($meta_box_page['fields'] as $field) {
		if (!isset($field['id'])) continue;
        $new = isset($_POST[$field['id']]) ? $_POST[$field['id']] : '';
		$custom_options[$field['id']] = $new ? $new : 'default';
    }

	foreach ($theme_options as $option) { 
		if (!isset($option['override']) || !in_array('page', explode(',', $option['override']))) continue;
		if (!isset($option['id'])) continue;
		$id = get_option_name($option['id']);
        $new = isset($_POST[$id]) ? $_POST[$id] : '';
		$custom_options[$id] = $new ? $new : 'default';
	}
	
	update_post_meta($post_id, 'post_custom_options', $custom_options);
}
?>