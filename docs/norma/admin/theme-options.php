<?php
define('COLORPICKER_WP', 'WP');			// inner WP color picker
define('COLORPICKER_OTHER', 'OTHER');	// third part color picker
define('COLORPICKER', COLORPICKER_WP);

/*-----------------------------------------------------------------------------------*/
/* Admin Interface
/*-----------------------------------------------------------------------------------*/
add_action('admin_menu', 'theme_options_add_admin');
function theme_options_add_admin() {

    global $query_string;
   
	// In this case menu item "Theme Options" add in root admin menu level
	//$tt_page = add_menu_page(__('Theme Options', 'wpspace'), __('Theme Options', 'wpspace'), 'edit_theme_options', 'theme_options', 'theme_options_page');

	// In this case menu item "Theme Options" add in admin menu 'Appearance'
	$tt_page = add_theme_page(__('Theme Options', 'wpspace'), __('Theme Options', 'wpspace'), 'edit_theme_options', 'theme_options', 'theme_options_page');

	add_action("admin_print_styles-$tt_page", 'theme_options_load_styles');
	add_action("admin_print_scripts-$tt_page", 'theme_options_load_scripts');
} 


/*-----------------------------------------------------------------------------------*/
/* Load required styles for Options Page
/*-----------------------------------------------------------------------------------*/
function theme_options_load_styles() {
	wp_enqueue_style('theme-options', get_template_directory_uri().'/admin/theme-options.css');
	if (COLORPICKER == COLORPICKER_WP)
		wp_enqueue_style('wp-color-picker');
	else
		wp_enqueue_style('color-picker', get_template_directory_uri().'/admin/colorpicker.css');
	$color = get_user_option('admin_color');
	if ($color == "fresh")
		wp_enqueue_style('theme-options-fresh', get_template_directory_uri().'/admin/theme-options-fresh.css');
}


/*-----------------------------------------------------------------------------------*/
/* Load required javascripts for Options Page
/*-----------------------------------------------------------------------------------*/
function theme_options_load_scripts() {
	
	wp_enqueue_media();
	wp_enqueue_script('ajaxupload', get_template_directory_uri().'/admin/js/ajaxupload.js', array('jquery'));
    
	wp_enqueue_script('jquery-ui-core');
	wp_register_script('jquery-input-mask', get_template_directory_uri().'/admin/js/jquery.maskedinput-1.2.2.js', array( 'jquery' ));
	wp_enqueue_script('jquery-input-mask');
	if (COLORPICKER == COLORPICKER_WP)
		wp_enqueue_script('wp-color-picker');
	else
		wp_enqueue_script('color-picker', get_template_directory_uri().'/admin/js/colorpicker.js', array('jquery'));
}


add_action('admin_head', 'theme_options_admin_head');
/*-----------------------------------------------------------------------------------*/
/* Prepare javascripts for Options Page
/*-----------------------------------------------------------------------------------*/
function theme_options_admin_head() { 
	$ajax_nonce = wp_create_nonce('ajax_nonce');
	$ajax_url = admin_url('admin-ajax.php');
?>
    
	<script type="text/javascript" language="javascript">
        jQuery(document).ready(function(){

           	jQuery('.opt_group .opt_content.closed').hide();
            jQuery('.opt_group h3.toggle').click(function(){
            	jQuery(this).next().toggleClass('closed').slideToggle();
            });
            
            <?php
            global $theme_options;
            
            // Assing Color Pickers
            foreach($theme_options as $option){ 
                if ($option['type'] == 'color' || $option['type'] == 'typography' || $option['type'] == 'border'){
                    if ($option['type'] == 'typography' || $option['type'] == 'border'){
                        $option_id = $option['id'];
                        $temp_color = get_theme_option($option_id);
                        $option_id = $option['id'] . '_color';
                        $color = $temp_color['color'];
                    } else {
                        $option_id = $option['id'];
                        $color = get_theme_option($option_id);
                    }
					if (COLORPICKER == COLORPICKER_WP) {
                    ?>
						jQuery('#<?php echo $option_id; ?>').wpColorPicker();
						jQuery('.wp-picker-clear').css('width', '80px');
					<?php
					} else {
					?>
						jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '<?php echo $color; ?>');    
						jQuery('#<?php echo $option_id; ?>_picker').ColorPicker({
							color: '<?php echo $color; ?>',
							onShow: function (colpkr) {
								jQuery(colpkr).fadeIn(500);
								return false;
							},
							onHide: function (colpkr) {
								jQuery(colpkr).fadeOut(500);
								return false;
							},
							onChange: function (hsb, hex, rgb) {
								//jQuery(this).css('border','1px solid red');
								jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '#' + hex);
								jQuery('#<?php echo $option_id; ?>_picker').next('input').attr('value','#' + hex);
								
							}
						});
            <?php 
					}
                } 
            } 
            ?>

			var i = 0;
			jQuery('#of-nav li a').attr('id', function() {
			   i++;
			   return 'item'+i;
			});
	
			var flip = 0;
					
			jQuery('#expand_options').click(function(){
				if(flip == 0){
					flip = 1;
					jQuery('#truethemes_container #of-nav').hide();
					jQuery('#truethemes_container #content').width(755);
					jQuery('#truethemes_container .group').add('#truethemes_container .group h2').show();
					jQuery(this).text('[-]');
				} else {
					flip = 0;
					jQuery('#truethemes_container #of-nav').show();
					jQuery('#truethemes_container #content').width(579);
					jQuery('#truethemes_container .group').add('#truethemes_container .group h2').hide();
					jQuery('#truethemes_container .group:first').show();
					jQuery('#truethemes_container #of-nav li').removeClass('current');
					jQuery('#truethemes_container #of-nav li:first').addClass('current');
					jQuery(this).text('[+]');
				}
			});
				
			jQuery('.group').hide();
			jQuery('.group:first').fadeIn();
					
			jQuery('.group .collapsed').each(function(){
				jQuery(this).find('input:checked').parent().parent().parent().nextAll().each( 
					function(){
						if (jQuery(this).hasClass('last')) {
							jQuery(this).removeClass('hidden');
							return false;
						}
						jQuery(this).filter('.hidden').removeClass('hidden');
					});
			});
						
			jQuery('.group .collapsed input:checkbox').click(unhideHidden);
			
			function unhideHidden(){
				if (jQuery(this).attr('checked')) {
					jQuery(this).parent().parent().parent().nextAll().removeClass('hidden');
				}
				else {
					jQuery(this).parent().parent().parent().nextAll().each( 
						function(){
							if (jQuery(this).filter('.last').length) {
								jQuery(this).addClass('hidden');
								return false;
							}
							jQuery(this).addClass('hidden');
						});
						
				}
			}
			
			jQuery('.of-radio-img-img').click(function(){
				jQuery(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
				jQuery(this).addClass('of-radio-img-selected');
				
			});
			jQuery('.of-radio-icon-icon').click(function(){
				jQuery(this).parent().parent().find('.of-radio-icon-icon').removeClass('of-radio-icon-selected');
				jQuery(this).addClass('of-radio-icon-selected');
				
			});
			//jQuery('.of-radio-img-label').hide();
			//jQuery('.of-radio-img-img').show();
			//jQuery('.of-radio-img-radio').hide();
			jQuery('#of-nav li:first').addClass('current');
			jQuery('#of-nav li a').click(function(evt){
			
					jQuery('#of-nav li').removeClass('current');
					jQuery(this).parent().addClass('current');
					
					var clicked_group = jQuery(this).attr('href');
	 
					jQuery('.group').hide();
					
					jQuery(clicked_group).fadeIn();
	
					evt.preventDefault();
					
				});
			
			if('<?php if(isset($_REQUEST['reset'])) { echo $_REQUEST['reset']; } else { echo 'false';} ?>' == 'true'){
				
				var reset_popup = jQuery('#of-popup-reset');
				reset_popup.fadeIn();
				window.setTimeout(function(){
					   reset_popup.fadeOut();                        
					}, 2000);
					//alert(response);
				
			}
						
			//Update Message popup
			jQuery.fn.center = function () {
				this.animate({"top":( jQuery(window).height() - this.height() - 200 ) / 2+jQuery(window).scrollTop() + "px"},100);
				this.css("left", 250 );
				return this;
			}
		
			
			jQuery('#of-popup-save').center();
			jQuery('#of-popup-reset').center();
			jQuery(window).scroll(function() { 
			
				jQuery('#of-popup-save').center();
				jQuery('#of-popup-reset').center();
			
			});
				
			
			// WP Media manager	
			var media_frame = null;
			jQuery('.image_media_button').on('click', function(e){
				var clickedObject = jQuery(this);
				var clickedID = jQuery(this).attr('id');	
				if ( media_frame ) {
					media_frame.open();
					return;
				}
				media_frame = wp.media.frames.media_frame = wp.media({
					title: jQuery( this ).data( 'uploader-title' ),
					button: {
						text: jQuery( this ).data( 'uploader-button' ),
					},
					multiple: false
				});
				media_frame.on( 'select', function() {
					attachment = media_frame.state().get('selection').first().toJSON();
					var buildReturn = '';
					if ((pos = attachment.url.lastIndexOf('.'))>=0) {
						var ext = attachment.url.substr(pos+1);
						buildReturn = '<a class="of-uploaded-image" target="_blank" href="' + attachment.url + '">';
						if ('jpg,png,gif'.indexOf(ext)>=0) {
							buildReturn += '<img class="hide of-option-image" id="image_'+clickedID+'" src="'+attachment.url+'" alt="" />';
						} else {
							buildReturn += '<span id="image_'+clickedID+'">'+attachment.url.substr(attachment.url.lastIndexOf('/')+1)+'</span>';
						}
						buildReturn += '</a>';
					}
					jQuery("#image_" + clickedID).remove();	
					if (buildReturn!='') {
						clickedObject.parent().after(buildReturn);
					}
					jQuery('img#image_'+clickedID).fadeIn();
					clickedObject.next('span').fadeIn();
					clickedObject.parent().prev('input').val(attachment.url);
				});
				media_frame.open();
				e.preventDefault();
				return false;
			});
			
			//AJAX Upload
			jQuery('.image_upload_button').each(function(){
				var clickedObject = jQuery(this);
				var clickedID = jQuery(this).attr('id');	
				new AjaxUpload(clickedID, {
					  action: '<?php echo $ajax_url; ?>',
					  name: clickedID, // File upload name
					  data: { // Additional data to send
							action: 'theme_options_ajax_post_action',
							nonce: '<?php echo $ajax_nonce; ?>',
							type: 'upload',
							data: clickedID 
							},
					  autoSubmit: true, // Submit file after selection
					  responseType: false,
					  onChange: function(file, extension){},
					  onSubmit: function(file, extension){
							clickedObject.text('<?php _e('Uploading', 'wpspace'); ?>'); // change button text, when user selects file	
							this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
							interval = window.setInterval(function(){
								var text = clickedObject.text();
								if (text.length < 13){	clickedObject.text(text + '.'); }
								else { clickedObject.text('<?php _e('Uploading', 'wpspace'); ?>'); } 
							}, 200);
					  },
					  onComplete: function(file, response) {
					   
						window.clearInterval(interval);
						clickedObject.text('<?php _e('Upload Image', 'wpspace'); ?>');	
						this.enable(); // enable upload button
						
						// If there was an error
						if(response.search('<?php _e('Upload Error', 'wpspace'); ?>') > -1){
							var buildReturn = '<span class="upload-error">' + response + '</span>';
							jQuery(".upload-error").remove();
							clickedObject.parent().after(buildReturn);
						
						} else {
							var buildReturn = '';
							
							if ((pos = response.lastIndexOf('.'))>=0) {
								var ext = response.substr(pos+1);
								buildReturn = '<a class="of-uploaded-image" target="_blank" href="' + response + '">';
								if ('jpg,png,gif'.indexOf(ext)>=0) {
									buildReturn += '<img class="hide of-option-image" id="image_'+clickedID+'" src="'+response+'" alt="" />';
								} else {
									buildReturn += '<span id="image_'+clickedID+'">'+response.substr(response.lastIndexOf('/')+1)+'</span>';
								}
								buildReturn += '</a>';
							}
							jQuery(".upload-error").remove();
							jQuery("#image_" + clickedID).remove();	
							if (buildReturn!='') {
								clickedObject.parent().after(buildReturn);
							}
							jQuery('img#image_'+clickedID).fadeIn();
							clickedObject.next('span').fadeIn();
							clickedObject.parent().prev('input').val(response);
						}
					}
				});
			});
				
			//AJAX Remove (clear option value)
			jQuery('.image_reset_button').click(function(){
			
					var clickedObject = jQuery(this);
					var clickedID = jQuery(this).attr('id');
					var theID = jQuery(this).attr('title');	
	
					var ajax_url = '<?php echo $ajax_url; ?>';
				
					var data = {
						action: 'theme_options_ajax_post_action',
						nonce: '<?php echo $ajax_nonce; ?>',
						type: 'image_reset',
						data: theID
					};
					
					jQuery.post(ajax_url, data, function(response) {
						var image_to_remove = jQuery('#image_' + theID);
						var button_to_hide = jQuery('#reset_' + theID);
						image_to_remove.fadeOut(500, function() { jQuery(this).remove(); });
						button_to_hide.fadeOut();
						clickedObject.parent().prev('input').val('');
					});
					
					return false; 
			});
							
				
			//Save all options
			jQuery('#ofform #button-save').click(function(){
				
					function newValues() {
					  var serializedValues = jQuery("#ofform").serialize();
					  return serializedValues;
					}
					//jQuery(":checkbox, :radio").click(newValues);
					//jQuery("select").change(newValues);
					jQuery('.ajax-loading-img').fadeIn();
					var serializedReturn = newValues();
	
					var ajax_url = '<?php echo $ajax_url; ?>';
				
					 //var data = {data : serializedReturn};
					var data = {
						<?php if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'theme_options') { ?>
						type: 'options',
						<?php } ?>
						action: 'theme_options_ajax_post_action',
						nonce: '<?php echo $ajax_nonce; ?>',
						data: serializedReturn
					};
					
					jQuery.post(ajax_url, data, function(response) {
						var success = jQuery('#of-popup-save');
						var loading = jQuery('.ajax-loading-img');
						loading.fadeOut();  
						success.fadeIn();
						window.setTimeout(function(){
						   success.fadeOut(); 
						}, 2000);
					});
					
					return false; 
			});   	 	
	
	
							
				
			//Reset options
			jQuery('#ofform #button-reset').click(function(){
					jQuery('.ajax-loading-img').fadeIn();
					
					if (!confirm('<?php _e('You really want reset all options to default values ?', 'wpspace'); ?>')) return;
					 
					var ajax_url = '<?php echo $ajax_url; ?>';
				
					 //var data = {data: serializedReturn};
					var data = {
						<?php if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'theme_options') { ?>
						type: 'reset',
						<?php } ?>
						action: 'theme_options_ajax_post_action',
						nonce: '<?php echo $ajax_nonce; ?>'
					};
					
					jQuery.post(ajax_url, data, function(response) {
						var success = jQuery('#of-popup-reset');
						var loading = jQuery('.ajax-loading-img');
						loading.fadeOut();  
						success.fadeIn();
						window.setTimeout(function(){
						   success.fadeOut(); 
						   window.location.href = (pos=window.location.href.indexOf('&rnd='))>0 ? window.location.href.substring(0, pos) : window.location.href + '&rnd=' + Math.random();
						}, 2000);
					});
					
					return false; 
			});
			
			
			// Increment buttons
			jQuery('#ofform').on('click', '.of-increment-add', function() {
				var inc_area = jQuery(this).siblings('.of-increment-area').eq(0);
				var inc_item = null;
				var max_num = 0;
				inc_area.find('.of-increment-item').each(function() {
					var cur_item = jQuery(this);
					if (inc_item == null) 
						inc_item = cur_item;
					var num = Number(cur_item.find('input[type="hidden"]').eq(0).val());
					if (num > max_num)
						max_num = num;
				});
				var clonedObj = inc_item.clone();
				clonedObj.find('input[type="text"]').val('');
				clonedObj.find('input[type="hidden"]').val(max_num+1);
				inc_area.append(clonedObj);
			});
			jQuery('#ofform').on('click', '.of-increment-del', function() {
				if (jQuery(this).parents('.of-increment-item').parent().find('.of-increment-item').length>1)
					jQuery(this).parents('.of-increment-item').eq(0).remove();
				else
					alert("<?php _e("You can't delete last item! To disable it - just clear value in field.", 'wpspace'); ?>");
			});
		});
	</script>
<?php 
}



/*-----------------------------------------------------------------------------------*/
/* Build the Options Page
/*-----------------------------------------------------------------------------------*/
function theme_options_page(){
?>
<div class="wrap" id="truethemes_container">
	<div id="of-popup-save" class="of-save-popup">
		<div class="of-save-save"><?php _e('Options Updated', 'wpspace'); ?></div>
	</div>
	<div id="of-popup-reset" class="of-save-popup">
		<div class="of-save-reset"><?php _e('Options Reset', 'wpspace'); ?></div>
	</div>
	<form action="" enctype="multipart/form-data" id="ofform">
		<div id="header">
			<div class="logo">
				<h2><?php _e('Theme Options', 'wpspace'); ?></h2>
			</div>
			<div class="icon-option"> </div>
			<div class="clear"></div>
		</div>
		<?php $option_page = theme_options_render(); ?>
		<div id="main">
			<div id="of-nav">
				<ul>
					<?php echo $option_page[1]; ?>
				</ul>
			</div>
			<div id="content"><?php echo $option_page[0]; ?></div>
			<div class="clear"></div>
		</div>
		<div class="save_bar_top">
			<img style="display:none;" src="<?php echo get_template_directory_uri() ?>/admin/images/wpspin_light.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="<?php _e('Working...', 'wpspace'); ?>" />
			<input type="button" id="button-save" value="<?php _e('Save All Options', 'wpspace'); ?>" class="button-primary" />
			<span class="submit-footer-reset">
			<input type="button" id="button-reset" value="<?php _e('Reset Options', 'wpspace'); ?>" class="button submit-button reset-button" onclick="return confirm('<?php _e('CAUTION: Any and all settings will be lost! Click OK to reset.', 'wpspace'); ?>');" />
			</span>
		</div>
	</form>
<?php  if (!empty($update_message)) echo $update_message; ?>
<div style="clear:both;"></div>
</div>
<!--wrap-->
<?php
}



/*-----------------------------------------------------------------------------------*/
/* Theme options page renderer
/*-----------------------------------------------------------------------------------*/

function theme_options_render() {
    
	global $theme_options;

	$menu = '';
	$output = '';
	$group_opened = false;
	$heading_opened = false;

	foreach ($theme_options as $value) {
	
		if (in_array($value['type'], array('group', 'groupend', 'heading')) && $group_opened) {
			$output .= '</div></div>';
			$group_opened = false;
		}
		
		if ($value['type'] == 'group') {
			$output .= '<div class="opt_group"'.(isset($value['std']) ? ' id="'.$value['std'].'"' : '').'>';
			$output .= '<h3 class="toggle">'.$value['name'].'</h3><div class="opt_content'.(isset($value['closed']) && $value['closed'] ? ' closed' : '').'">';
			$group_opened = true;
		}  

		//Start Heading
		if ( !in_array( $value['type'], array("heading", "hidden", "group", "groupend") ) ) { 
			$class = ''; if(isset( $value['class'] )) { $class = $value['class']; }
			$output .= '<div class="section section-'.str_replace(array('list', 'range'), array('select', 'select'), $value['type']).' '. $class .'">'."\n";
			$output .= '<h3 class="heading">'. $value['name'] .'</h3>'."\n";
			$output .= '<div class="option">'."\n" . '<div class="controls">'."\n";
		} 
		//End Heading

		if (isset($value['enable'])) {
			$tmp = explode('|', $value['val']);
			$value['val'] = $tmp[0];
			if (isset($tmp[1]))
				$value['enable'] = $tmp[1];
		}
		

		switch ( $value['type'] ) {
		
		
		
		case 'hidden':
			$output .= '<input class="of-input" name="'. $value['id'] .'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. htmlspecialchars($value['val']) . '" />';
		break;
		
		
		
		case 'text':
			$inc = isset($value['increment']) && $value['increment'];
			if ($inc) {
				$arr = explode(',', $value['val']);
				$output .= '<div class="of-increment-area">';
			} else
				$arr = array($value['val']);
			for ($i=0; $i<count($arr); $i++) {
				$sb = explode('|',$arr[$i]);
				if (count($sb)==1) $sb[1] = $i+1;
				$output .= ($inc ? '<div class="of-increment-item"><input type="hidden" name="'. $value['id'] . '_numbers[]" value="'.$sb[1].'" />' : '').'<input class="of-input' . ($inc ? ' of-incremented' : '') . '" name="'. $value['id'] . ($inc ? '[]' : '') .'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. htmlspecialchars($sb[0]) . '" />' . ($inc ? '<a href="#" class="of-increment-button of-increment-del">-</a></div>' : '');
			}
			if ($inc) {
				$output .= '</div><a href="#" class="of-increment-button of-increment-add">'. __('+ Add item', 'wpspace') .'</a>';
			}
		break;
		
		
		
		
		
		
		case 'select':
			$multiple = isset($value['multiple']) && $value['multiple'];
			$output .= '<select class="of-input" name="'. $value['id'] .($multiple ? '[]' : '') .'" id="'. $value['id'] .'"' . (isset($value['size']) ? ' size="' . $value['size'] . '"' : '') . ($multiple ? ' multiple="multiple"' : '') . '>';
			foreach ($value['options'] as $k => $option) {
				if (is_array($option)) 
					$title = isset($option['name']) ? $option['name'] : (isset($option['title']) ? $option['title'] : $k);
				else
					$title = $option;
				$output .= '<option'. (($multiple ? in_array($k, explode(',', $value['val'])) : $value['val'] == $k) ? ' selected="selected"' : '') . ' value="' . $k . '">' . htmlspecialchars($title) . '</option>';
			}
			$output .= '</select>';
		break;


		
		
		
		
		
		
		case 'checklist':
			$multiple = isset($value['multiple']) && $value['multiple'];
			$i = 0;
			$id = $value['id'];
			$output .= '<ul class="checklist">';
			foreach ($value['options'] as $k => $val) {
				$i++;
				$output .='<li>';
				$output .='<input type="' . ($multiple ? 'checkbox' : 'radio') . '" value="'.$k.'" name="'.$id.($multiple ? '[]' : '').'" id="'.$id.$i.'"'.(in_array($k, explode(',', $value['val'])) ? ' checked="checked"' : '').'><label for="'.$id.$i.'">'.$val.'</label>';
				$output .='</li>';
			}
			$output .= '</ul>';
		break;
		
		
		
		
		
		case 'list':
			$output .= '<select class="of-input" name="'. $value['id'] .'" id="'. $value['id'] .'">';
			foreach ($value['options'] as $option) {
				$output .= '<option'. ($value['val'] == $option ? ' selected="selected"' : '') . ' value="' . $option . '">' . htmlspecialchars($option) . '</option>';
			}
			$output .= '</select>';
		break;



		
		case 'range':
			$output .= '<select class="of-input" name="'. $value['id'].'" id="'.$value['id'].'">';
			for ($i = $value['from']; $i <= $value['to']; $i++) { 
				$output .= '<option value="'. $i .'" ' . ($value['val'] == $i ? ' selected="selected"' : '') . '>'. $i .'</option>'; 
			}
			$output .= '</select>';
		break;
		


		
		
		case 'fontsize':
			$output .= '<select class="of-typography of-typography-size" name="'. $value['id'].'" id="'. $value['id'].'_size">';
			for ($i = 9; $i < 71; $i++) { 
				$output .= '<option value="'. $i .'" ' . ($value['val'] == $i ? ' selected="selected"' : '') . '>'. $i .'px</option>'; 
			}
			$output .= '</select>';
		break;
		
		
		
		
		
		
		
		
		case 'textarea':
			$cols = isset($value['cols']) && $value['cols'] > 10 ? $value['cols'] : '40';
			$rows = isset($value['cols']) && $value['rows'] > 1 ? $value['rows'] : '8';
			$output .= '<textarea class="of-input" name="'. $value['id'] .'" id="'. $value['id'] .'" cols="'. $cols .'" rows="' . $rows . '">' . htmlspecialchars($value['val']) . '</textarea>';
		break;
		
		
		
		
		
		
		
		
		case "radio":
			foreach ($value['options'] as $key => $option) { 
				$output .= '<input class="of-input of-radio" type="radio" name="'. $value['id'] .'" value="'. $key .'" '. ($value['val'] == $key ? ' checked="checked"' : '') .' id="' . $value['id'] . '_' . $key . '" /><label for="' . $value['id'] . '_' . $key . '">' . $option . '</label>' . (isset($value['style']) && $value['style']=='vertical' ? '<br />' : '');
			}
		break;
		
		
		
		
		
		
		
		
		case "checkbox": 
			$output .= '<input type="checkbox" class="checkbox of-input" name="'.  $value['id'] .'" id="'. $value['id'] .'" value="true" ' . ($value['val'] == 'true' ? ' checked="checked"' : '') .' /><label for="' . $value['id'] . '">' . $value['name'] . '</label>';
		break;
	
		
		
		
		
		
		
		case "upload":
			$output .= theme_options_uploader_function($value['id'], $value['val'], null);
		break;
		
		
		
		case "mediamanager":
			$output .= theme_options_uploader_function($value['id'], $value['val'], 'media');
		break;
		
		
		
		
		case "upload_min":
			$output .= theme_options_uploader_function($value['id'], $value['val'], 'min');
		break;






		case "color":
			if (COLORPICKER == COLORPICKER_WP) {
				$output .= '<input class="of-color colorSelector" name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. $value['val'] .'" />';
			} else {
				$output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div></div></div>';
				$output .= '<input class="of-color" name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. $value['val'] .'" />';
			}
		break;   
		
		
		
		
		 
		
		case "images":
			$i = 0;
			foreach ($value['options'] as $key => $option) { 
				$i++;
				$checked = '';
				$selected = '';
				if ($value['val'] == $key || ($i == 1  && $value['val'] == '')) { $checked = ' checked'; $selected = 'of-radio-img-selected'; }
				$output .= '<span>';
				$output .= '<input type="radio" id="of-radio-img-' . $value['id'] . $i . '" class="checkbox of-radio-img-radio" value="'.$key.'" name="'. $value['id'].'" '.$checked.' />';
				//$output .= '<div class="of-radio-img-label">'. $key .'</div>';
				$output .= '<img src="'.$option.'" alt="" class="of-radio-img-img '. $selected .'" onClick="document.getElementById(\'of-radio-img-'. $value['id'] . $i.'\').checked = true;" />';
				$output .= '</span>';
			}
		break; 
		
		
		
		
		
		 
		
		case "icons":
			$i = 0;
			if (isset($value['css']) && $value['css']!='' && file_exists($value['css'])) {
				$value['options'] = parseIconsClasses($value['css']);
			}
			$output .= '</div>';
			foreach ($value['options'] as $option) { 
				$i++;
				$checked = '';
				$selected = '';
				if ($value['val'] == $option || ($i == 1  && $value['val'] == '')) { $checked = ' checked'; $selected = 'of-radio-icon-selected'; }
				$output .= '<span>';
				$output .= '<input type="radio" id="of-radio-icon-' . $value['id'] . $i . '" class="checkbox of-radio-icon-radio" value="'.$option.'" name="'. $value['id'].'" '.$checked.' />';
				$output .= '<span class="of-radio-icon-icon '. $option . ' ' . $selected .'" onClick="document.getElementById(\'of-radio-icon-'. $value['id'] . $i.'\').checked = true;"></span>';
				$output .= '</span>';
			}
			$output .= '<div>';
		break; 
		
		
		
		
		
		case "info":
			$default = $value['std'];
			$output .= '<div class="info">'.$default.'</div>';
		break;
		
		
		
		
	
	                                 
		
		case "heading":
			if ($heading_opened){
			   $output .= '</div>'."\n";
			}
			$jquery_click_hook = "of-option-" . str_replace(" ", "-", preg_replace("[^A-Za-z0-9]", "", my_strtolower($value['name']) ));
			$menu .= '<li><a title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'">'.  $value['name'] .'</a></li>';
			$output .= '<div class="group" id="'. $jquery_click_hook  .'"><h2>'.$value['name'].'</h2>'."\n";
			$heading_opened = true;
		break;                                  
		} 




		if ( !in_array( $value['type'], array("heading", "hidden", "group", "groupend") ) ) { 
			//$output .= $value['type']!='checklist' ? '<br/>' : '';
			if (!isset($value['desc'])) { $descr = ''; } 
			else { $descr = $value['desc']; } 
			if (isset($value['enable'])) { 
				$output .= '<input type="checkbox" class="checkbox of-enable of-input" name="'.  $value['id'] .'_enable" id="'. $value['id'] .'_enable" value="1" ' . ($value['enable'] == '1' ? ' checked="checked"' : '') .' />';
			} 
			$output .= '</div><div class="explain">'. $descr .'</div>'."\n";
			$output .= '<div class="clear"> </div></div></div>'."\n";
		}
	}

	if ($group_opened) {
		$output .= '</div></div>';
	}
	
	if ($heading_opened) {
	    $output .= '</div>';
	}
    return array($output,$menu);
}










/*-----------------------------------------------------------------------------------*/
/* Ajax Save Action handler
/*-----------------------------------------------------------------------------------*/

add_action('wp_ajax_theme_options_ajax_post_action', 'theme_options_ajax_callback');

function theme_options_ajax_callback() {
	global $wpdb, $_REQUEST, $theme_options;
	
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ajax_nonce' ) )
		die();

	$save_type = $_POST['type'];

	if ($save_type == 'upload'){
		
		$clickedID = $_POST['data']; // Acts as the name
		$filename = $_FILES[$clickedID];
       	$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 
		
		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';    
		$uploaded_file = wp_handle_upload($filename, $override);
		 
		$upload_tracking[] = $clickedID;
		update_option( $clickedID , $uploaded_file['url'] );
				
		if (!empty($uploaded_file['error'])) {
			echo __('Upload Error:', 'wpspace') . ' ' . $uploaded_file['error'];
		} else {
			echo $uploaded_file['url']; 
		}

	} else if ($save_type == 'image_reset'){
		$id = $_POST['data']; // Acts as the name
		global $wpdb;
		$query = "DELETE FROM $wpdb->options WHERE option_name LIKE '$id'";
		$wpdb->query($query);

	} else if ($save_type == 'options' OR $save_type == 'reset') {
		if ($save_type == 'options') {
			$data = $_POST['data'];
			parse_str($data, $output);
		}
		//Pull options
		foreach ($theme_options as $option_array){
			if (isset($option_array['id'])) { // Non - Headings...
				$id = $option_array['id'];
				$type = $option_array['type'];
				if ($save_type == 'options') {
					$multiple = isset($option_array['multiple']) && $option_array['multiple'];
					if ($multiple && is_array($output[$id])) {
						sort($output[$id]);
					}
					$inc = isset($option_array['increment']) && $option_array['increment'];
					if ($inc && is_array($output[$id])) {
						foreach($output[$id] as $k=>$v)
							$output[$id][$k] .= '|' . $output[$id.'_numbers'][$k];
					}
					$new_value = isset($output[$id]) ? (($multiple || $inc) && is_array($output[$id]) ? implode(',', $output[$id]) : stripslashes($output[$id])) : ($type == 'checkbox' ? 'false' : '');
					if (isset($option_array['enable']))
						$new_value = $new_value . '|' . (isset($output[$id.'_enable']) ? 1 : 0); 
				} else {
					$new_value = $option_array['std'];
					if (isset($option_array['enable']))
						$new_value = $new_value . '|' . ($option_array['enable'] ? 1 : 0); 
				}
//				if ($type != 'upload_min' || $save_type == 'reset') {
					update_option($id, $new_value);
//				}
			}
		}	
	}
	die();
}




/*-----------------------------------------------------------------------------------*/
/* File Uploader
/*-----------------------------------------------------------------------------------*/

function theme_options_uploader_function($id, $std, $mod){
    
	$uploader = '';
    $upload = $std;
	
	$uploader .= '<input class="of-input" name="'. $id .'" id="'. $id .'_upload" value="'. $std .'" type="' . ($mod == 'min' ? 'hidden' : 'text') . '" />';

	$uploader .= '<div class="upload_button_div">'
		. '<span class="button image_'.($mod == 'media' ? 'media' : 'upload').'_button" id="'.$id.'"'
			. ($mod == 'media' ? ' data-uploader-title="'.__('Select image', 'wpspace').'" data-uploader-button="'.__('Choose image', 'wpspace').'"' : '').'>'
		. __('Upload Image', 'wpspace')
		. '</span>';
	
	if (!empty($upload)) {$hide = '';} else { $hide = 'hide';}
	
	$uploader .= '<span class="button image_reset_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '">' . __('Remove', 'wpspace') . '</span>';
	$uploader .='</div>' . "\n";
    $uploader .= '<div class="clear"></div>' . "\n";
	if (!empty($upload)){
    	$uploader .= '<a class="of-uploaded-image" target="_blank" href="'. $upload . '">';
		$ext = pathinfo($upload, PATHINFO_EXTENSION);
		if (in_array(my_strtolower($ext), array('jpg', 'png', 'gif')))
	    	$uploader .= '<img class="of-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
		else {
			$fname = pathinfo($upload, PATHINFO_BASENAME);
	    	$uploader .= '<span id="image_'.$id.'">'.$fname.'</span>';
		}
    	$uploader .= '</a>';
		$uploader .= '<div class="clear"></div>' . "\n"; 
		}


	return $uploader;
}
?>