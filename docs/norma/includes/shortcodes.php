<?php
/**
 * Theme Shortcodes Functions
*/


/* ==================================================================================================
   ==                                       ADMIN SETUP                                            ==
   ================================================================================================== */

add_filter('the_excerpt', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');		// Enable shortcodes in widgets

// Clear paragraph tags around shortcodes
add_filter('the_content', 'shortcode_empty_paragraph_fix');
function shortcode_empty_paragraph_fix($content) {   
	$array = array (
		'<p>[' => '[', 
		'<br />[' => '[', 
		'<br/>[' => '[', 
		'<br>[' => '[', 
		']</p>' => ']', 
		']<br />' => ']',
		']<br/>' => ']',
		']<br>' => ']'
	);
	$content = strtr($content, $array);
	return $content;
}

// Show shortcodes list in admin editor
add_action('media_buttons','add_sc_select', 11);
function add_sc_select(){

	$shortcodes_list = '<select id="sc_select"><option value="">&nbsp;'.__('*Select Shortcode*', 'wpspace').'&nbsp;</option>';

	$shortcodes_list .= '<option value="'
		. "[title type='1']".__('Title text here', 'wpspace')."[/title]"
		. '">'.__('Title', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[line style='solid' top='10' bottom='10' width='100%' height='1' color='']"
		. '">'.__('Line', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[infobox style='regular' static='1']".__('Highlight text here', 'wpspace')."[/infobox]"
		. '">'.__('Infobox', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[button style='grey' size='medium' link='#']".__('Button caption', 'wpspace')."[/button]"
		. '">'.__('Button', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="' 
		. "[image src='' width='190' height='145' title='' align='left']" 
		. '">'.__('Image', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[highlight color='white' backcolor='#ff0000']".__('Highlighted text here', 'wpspace')."[/highlight]"
		. '">'.__('Highlight', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[quote style='1' cite='' title='']".__('Quoted text here', 'wpspace')."[/quote]"
		. '">'.__('Quote', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[tooltip title='Tooltip title']".__('Marked text here', 'wpspace')."[/tooltip]"
		. '">'.__('Tooltip', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[dropcaps style='1']".__('Dropcaps paragraph text here', 'wpspace')."[/dropcaps]"
		. '">'.__('Dropcaps', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[audio url='' controls='1' width='100%' height='60']"
		. '">'.__('Audio', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[video url='' width='480' height='270']"
		. '">'.__('Video', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="' 
		. "[section style='']".__('Section inner text here', 'wpspace')."[/section]" 
		. '">'.__('Section', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[columns count='2']"
		. "<br />[column_item]".__('Item inner text here', 'wpspace')."[/column_item]"
		. "<br />[column_item]".__('Item inner text here', 'wpspace')."[/column_item]"
		. "<br />[/columns]<br />"
		. '">'.__('Columns', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="' 
		. "[list style='regular']"
		. "<br />[list_item]".__('List Item inner text here', 'wpspace')."[/list_item]"
		. "<br />[list_item]".__('List Item inner text here', 'wpspace')."[/list_item]"
		. "<br />[list_item]".__('List Item inner text here', 'wpspace')."[/list_item]"
		. "<br />[/list]<br />"
		. '">'.__('List', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[tabs tab_names='Tab 1|Tab 2|Tab 3' style='1' initial='1']"
		. "<br />[tab]".__('Tab inner text here', 'wpspace')."[/tab]"
		. "<br />[tab]".__('Tab inner text here', 'wpspace')."[/tab]"
		. "<br />[tab]".__('Tab inner text here', 'wpspace')."[/tab]"
		. "<br />[/tabs]<br />"
		. '">'.__('Tabs', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[accordion initial='1']"
		. "<br />[accordion_item title='".__('Title', 'wpspace')."']".__('Item inner text here', 'wpspace')."[/accordion_item]"
		. "<br />[accordion_item title='".__('Title', 'wpspace')."']".__('Item inner text here', 'wpspace')."[/accordion_item]"
		. "<br />[accordion_item title='".__('Title', 'wpspace')."']".__('Item inner text here', 'wpspace')."[/accordion_item]"
		. "<br />[/accordion]<br />"
		. '">'.__('Accordion', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[toggles initial='1']"
		. "<br />[toggles_item title='".__('Title', 'wpspace')."']".__('Item inner text here', 'wpspace')."[/toggles_item]"
		. "<br />[toggles_item title='".__('Title', 'wpspace')."']".__('Item inner text here', 'wpspace')."[/toggles_item]"
		. "<br />[toggles_item title='".__('Title', 'wpspace')."']".__('Item inner text here', 'wpspace')."[/toggles_item]"
		. "<br />[/toggles]<br />"
		. '">'.__('Toggles', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[table]<br />"
		. __('Paste here table content, generated on one of many public internet resources, for example: http://www.impressivewebs.com/html-table-code-generator/ or http://html-tables.com/', 'wpspace')
		. "<br />[/table]<br />"
		. '">'.__('Table', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		."[googlemap address='' latlng='' zoom='16' width='400' height='240']"
		.'">'.__('Google Map', 'wpspace').'</option>';	
	$shortcodes_list .= '<option value="'
		."[contact_form title='".__('Contact Form', 'wpspace')."' description='']"
		.'">'.__('Contact form', 'wpspace').'</option>';	
	$shortcodes_list .= '<option value="'."[hide selector='']"
		.'">'.__('Hide block', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[skills]"
		. "<br />[skills_item title='".__('Title', 'wpspace')."' level='50%' color='#ff5555']"
		. "<br />[skills_item title='".__('Title', 'wpspace')."' level='50%' color='#ff5555']"
		. "<br />[skills_item title='".__('Title', 'wpspace')."' level='50%' color='#ff5555']"
		. "<br />[/skills]<br />"
		. '">'.__('Skills', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[team]"
		. "<br />[team_item user='".__('User name', 'wpspace')."']"
		. "<br />[team_item user='".__('User name', 'wpspace')."']"
		. "<br />[team_item user='".__('User name', 'wpspace')."']"
		. "<br />[/team]<br />"
		. '">'.__('Team', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[blogger ids='' cat='' orderby='date' order='desc' count='3' descr='200' style='bubble_right' border='0' slider='0' dir='horizontal']"
		. '">'.__('Blogger', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[testimonials user='' email='' name='' position='' photo='']Testimonials text[/testimonials]"
		. '">'.__('Testimonials', 'wpspace').'</option>';
	$shortcodes_list .= '<option value="'
		. "[slider engine='flex' cat='' count='5' width='100%' height='250']"
		. '">'.__('Slider', 'wpspace').'</option>';
	$shortcodes_list .= '</select>';
	echo $shortcodes_list;
}



// Shortcodes list select handler
add_action('admin_head', 'button_js');
function button_js() {
	echo '
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#sc_select").change(function() {
				send_to_editor(jQuery("#sc_select :selected").val());
        		return false;
			});
		});
	</script>';
}	






/* ==================================================================================================
   ==                                       USERS SHORTCODES                                       ==
   ================================================================================================== */



// ---------------------------------- [title] ---------------------------------------


add_shortcode('title', 'sc_title');

/*
[title id="unique_id" style='underline|bubble_right|bubble_down' icon='' type="1-6"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/title]
*/
function sc_title($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"type" => "1",
		"style" => "underline",
		"icon" => "",
		"bubble_color" => "",
		"weight" => "",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$type = min(6, max(1, $type));
	$style = str_replace('-', '_', $style);
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($weight ? 'font-weight:' . $weight .';' : '');
	return '<h' . $type . ($id ? ' id="' . $id . '"' : '')
		. ($style=='underline' ? ' class="sc_title"' : 
		  (my_strpos($style, 'bubble')!==false ? ' class="sc_title_bubble sc_title_'.$style.'"' : '')).($s!='' ? ' style="'.$s.'"' : '').'>'. (my_substr($style, 0, 6)=='bubble' ? '<span class="sc_title_bubble_icon '.($icon!='' ? ' icon-'.$icon : '').'"' . ($bubble_color!='' ? ' style="background-color:'.$bubble_color.'"' : '') . '></span>' : '') . do_shortcode($content) . '</h' . $type . '>';
}

// ---------------------------------- [/title] ---------------------------------------



// ---------------------------------- [line] ---------------------------------------


add_shortcode('line', 'sc_line');

/*
[line id="unique_id" style="none|solid|dashed|dotted|double|groove|ridge|inset|outset" top="margin_in_pixels" bottom="margin_in_pixels" width="width_in_pixels_or_percent" height="line_thickness_in_pixels" color="line_color's_name_or_#rrggbb"]
*/
function sc_line($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "solid",
		"color" => "",
		"width" => "-1",
		"height" => "-1",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$ed = my_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);
	$s = ($width >= 0 ? 'width:' . $width . $ed . ';' : '')
		.($height >= 0 ? 'border-top-width:' . $height . 'px;' : '')
		.($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($style != '' ? 'border-top-style:' . $style . ';' : '')
		.($color != '' ? 'border-top-color:' . $color . ';' : '');
	return '<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_line' . ($style != '' ? ' sc_line_style_' . $style : '') . '"'.($s!='' ? ' style="'.$s.'"' : '').'></div>';
}

// ---------------------------------- [/line] ---------------------------------------



// ---------------------------------- [infobox] ---------------------------------------


add_shortcode('infobox', 'sc_infobox');

/*
[infobox id="unique_id" style="regular|info|success|error|result" static="0|1"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/infobox]
*/
function sc_infobox($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "regular",
		"static" => "1",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($static==0 ? 'cursor:pointer' : '');
	return '
		<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_infobox sc_infobox_style_' . $style . ($static==0 ? ' sc_infobox_closeable' : '') . '"'.($s!='' ? ' style="'.$s.'"' : '').'>
			' . do_shortcode($content) . '
		</div>
		';
}

// ---------------------------------- [/infobox] ---------------------------------------



// ---------------------------------- [button] ---------------------------------------


add_shortcode('button', 'sc_button');

/*
[button id="unique_id" style="grey|red|green|blue" size="small|medium|large" link='#' target='']Button caption[/button]
*/
function sc_button($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "grey",
		"size" => "medium",
		"link" => "",
		"target" => "",
		"align" => "",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	return empty($link) ? '' : '<a href="' . $link . '"' . (!empty($target) ? ' target="' . $target . '"' : '') . ($id ? ' id="' . $id . '"' : '') . ' class="sc_button sc_button_style_' . $style . ' sc_button_size_' . $size . ($align ? ' align'.$align : '') . '"'.($s!='' ? ' style="'.$s.'"' : '').'>' . do_shortcode($content) . '</a>';
}

// ---------------------------------- [/button] ---------------------------------------



// ---------------------------------- [highlight] ---------------------------------------


add_shortcode('highlight', 'sc_highlight');

/*
[highlight id="unique_id" color="fore_color's_name_or_#rrggbb" backcolor="back_color's_name_or_#rrggbb" style="custom_style"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/highlight]
*/
function sc_highlight($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"color" => "",
		"backcolor" => "",
		"style" => ""
    ), $atts));
	$s = ($color != '' ? 'color:' . $color . ';' : '')
		.($backcolor != '' ? 'background-color:' . $backcolor . ';' : '')
		.($style != '' ? $style : '');
	return '<span' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_highlight"'.($s!='' ? ' style="'.$s.'"' : '').'>' . do_shortcode($content) . '</span>';
}

// ---------------------------------- [/highlight] ---------------------------------------





// ---------------------------------- [image] ---------------------------------------


add_shortcode('image', 'sc_image');

/*
[image id="unique_id" src="image_url" width="width_in_pixels" height="height_in_pixels" title="image's_title" align="left|right"]
*/
function sc_image($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"src" => "",
		"title" => "",
		"align" => "",
		"width" => "-1",
		"height" => "-1"
    ), $atts));
	$s = ($width > 0 ? 'width:' . $width . 'px;' : '')
		.($height > 0 ? 'height:' . $height . 'px;' : '')
		.($align != '' ? 'float:' . $align . ';' : '');
	return '
		<figure' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_image ' . ($align ? ' sc_image_align_' . $align : '') . '"'.($s!='' ? ' style="'.$s.'"' : '').'>
			<img src="' . $src . '" border="0" alt="" />
			' . (trim($title) ? '<figcaption><span>' . $title . '</span></figcaption>' : '') . '
		</figure>
	';
}

// ---------------------------------- [/image] ---------------------------------------





// ---------------------------------- [quote] ---------------------------------------


add_shortcode('quote', 'sc_quote');

/*
[quote id="unique_id" style="1|2" cite="url" title=""]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/quote]
*/
function sc_quote($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "1",
		"title" => "",
		"cite" => ""
    ), $atts));
	$cite_param = $cite != '' ? ' cite="' . $cite . '"' : '';
	$title = $title=='' ? $cite : $title;
	$style = min(2, max(1, $style));
	return ($style == 1 ? '<blockquote' : '<q' ) . ($id ? ' id="' . $id . '"' : '') . $cite_param . ' class="sc_quote sc_quote_style_' . $style . '"' . '>' . do_shortcode($content) . ($style == 1 ? ($cite!='' ? '<cite><a href="'.$cite.'">'.$title.'</a></cite>' : ($title!='' ? '<cite>'.$title.'</cite>' : '')).'</blockquote>' : '</q>');
}

// ---------------------------------- [/quote] ---------------------------------------





// ---------------------------------- [tooltip] ---------------------------------------


add_shortcode('tooltip', 'sc_tooltip');

/*
[tooltip id="unique_id" title="Tooltip text here"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/tooltip]
*/
function sc_tooltip($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"title" => ""
    ), $atts));
	return '<span' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_tooltip_parent">' . do_shortcode($content) . '<span class="sc_tooltip">' . $title . '</span></span>';
}

// ---------------------------------- [/tooltip] ---------------------------------------


						


// ---------------------------------- [dropcaps] ---------------------------------------

add_shortcode('dropcaps', 'sc_dropcaps');

//[dropcaps id="unique_id" style="1-3"]paragraph text[/dropcaps]
function sc_dropcaps($atts, $content=null){
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "1"
    ), $atts));
	$style = min(3, max(1, $style));
	return '<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_dropcaps sc_dropcaps_style_' . $style . '">' 
		. do_shortcode('<span class="sc_dropcap">' . my_substr($content, 0, 1) . '</span>' . my_substr($content, 1))
		. '</div>';
}
// ---------------------------------- [/dropcaps] ---------------------------------------



// ---------------------------------- [audio] ---------------------------------------

add_shortcode("audio", "sc_audio");
						
//[audio id="unique_id" url="http://webglogic.com/audio/AirReview-Landmarks-02-ChasingCorporate.mp3" controls="0|1"]
function sc_audio($atts, $content = null) {
	extract(shortcode_atts(array(
		"id" => "",
		"src" => '',
		"url" => '',
		"controls" => "",
		"width" => '400',
		"height" => '60',
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	$width = max(10, (int) $width);
	$height = max(10, (int) $height);
	return '<audio' . ($id ? ' id="' . $id . '"' : '') . ' src="' . ($src!='' ? $src : $url) . '" class="sc_audio" ' . ($controls == 1 ? ' controls="controls"' : '') . ' width="' . $width . '" height="' . $height .'"'.($s!='' ? ' style="'.$s.'"' : '').'></audio>';
}

// ---------------------------------- [/audio] ---------------------------------------
						


// ---------------------------------- [video] ---------------------------------------

add_shortcode("video", "sc_video");

//[video id="unique_id" url="http://player.vimeo.com/video/20245032?title=0&amp;byline=0&amp;portrait=0" width="" height=""]
function sc_video($atts, $content = null) {
	extract(shortcode_atts(array(
		"id" => "",
		"url" => '',
		"src" => '',
		"width" => '790',
		"height" => '391',
		"top" => "",
		"bottom" => ""
	), $atts));
	$width = max(10, (int) $width);
	$height = max(10, (int) $height);
	$url = getVideoPlayerURL($src!='' ? $src : $url);
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	return '<iframe' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_video" src="' . $url . '" width="' . $width . '" height="' . $height . '"'.($s!='' ? ' style="'.$s.'"' : '').' frameborder="0" webkitAllowFullScreen="webkitAllowFullScreen" mozallowfullscreen="mozallowfullscreen" allowFullScreen="allowFullScreen"></iframe>';
}
// ---------------------------------- [/video] ---------------------------------------



// ---------------------------------- [section] ---------------------------------------


add_shortcode('section', 'sc_section');

/*
[section id="unique_id" style="class_name"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/section]
*/
function sc_section($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"class" => "",
		"style" => "",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.$style;
	return '
		<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_section' . ($class ? $class : '') . '"'.($s!='' ? ' style="'.$s.'"' : '').'>
			' . do_shortcode($content) . '
		</div>
	';
}

// ---------------------------------- [/section] ---------------------------------------




// ---------------------------------- [columns] ---------------------------------------


add_shortcode('columns', 'sc_columns');

/*
[columns id="unique_id" count="number"]
	[column_item id="unique_id" span="2 - number_columns"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta, odio arcu vut natoque dolor ut, enim etiam vut augue. Ac augue amet quis integer ut dictumst? Elit, augue vut egestas! Tristique phasellus cursus egestas a nec a! Sociis et? Augue velit natoque, amet, augue. Vel eu diam, facilisis arcu.[/column_item]
	[column_item]A pulvinar ut, parturient enim porta ut sed, mus amet nunc, in. Magna eros hac montes, et velit. Odio aliquam phasellus enim platea amet. Turpis dictumst ultrices, rhoncus aenean pulvinar? Mus sed rhoncus et cras egestas, non etiam a? Montes? Ac aliquam in nec nisi amet eros! Facilisis! Scelerisque in.[/column_item]
	[column_item]Duis sociis, elit odio dapibus nec, dignissim purus est magna integer eu porta sagittis ut, pid rhoncus facilisis porttitor porta, et, urna parturient mid augue a, in sit arcu augue, sit lectus, natoque montes odio, enim. Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus, vut enim habitasse cum magna.[/column_item]
	[column_item]Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus, vut enim habitasse cum magna. Duis sociis, elit odio dapibus nec, dignissim purus est magna integer eu porta sagittis ut, pid rhoncus facilisis porttitor porta, et, urna parturient mid augue a, in sit arcu augue, sit lectus, natoque montes odio, enim.[/column_item]
[/columns]
*/
$sc_columns_counter = 0;
$sc_columns_after_span2 = $sc_columns_after_span3 = $sc_columns_after_span4 = false;
function sc_columns($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"count" => "2",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	global $sc_columns_counter, $sc_columns_after_span2, $sc_columns_after_span3, $sc_columns_after_span4;
	$sc_columns_counter = 1;
	$sc_columns_after_span2 = $sc_columns_after_span3 = $sc_columns_after_span4 = false;
	$count = max(1, min(5, (int) $count));
	return '
		<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_columns sc_columns_count_' . $count . '"'.($s!='' ? ' style="'.$s.'"' : '').'>
			' . do_shortcode($content).'
		</div>
	';
}


add_shortcode('column_item', 'sc_column_item');

//[column_item]
function sc_column_item($atts, $content=null) {
	extract(shortcode_atts( array(
		"id" => "",
		"span" => "1"
	), $atts));
	global $sc_columns_counter, $sc_columns_after_span2, $sc_columns_after_span3, $sc_columns_after_span4;
	$span = max(1, min(4, (int) $span));
	$output = '
		<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_column_item sc_column_item_'.$sc_columns_counter 
					. ($sc_columns_counter % 2 == 1 ? ' odd' : ' even') 
					. ($sc_columns_counter == 1 ? ' first' : '') 
					. ($span > 1 ? ' span_'.$span : '') 
					. ($sc_columns_after_span2 ? ' after_span_2' : '') 
					. ($sc_columns_after_span3 ? ' after_span_3' : '') 
					. ($sc_columns_after_span4 ? ' after_span_4' : '') 
					. '">
			' . do_shortcode($content) . '
		</div>
	';
	$sc_columns_counter += $span;
	$sc_columns_after_span2 = $span==2;
	$sc_columns_after_span3 = $span==3;
	$sc_columns_after_span4 = $span==4;
	return $output;
}

// ---------------------------------- [/columns] ---------------------------------------



// ---------------------------------- [list] ---------------------------------------

add_shortcode('list', 'sc_list');

/*
[list id="unique_id" style="regular|check|mark|error"]
	[list_item id="unique_id" title="title_of_element"]Et adipiscing integer.[/list_item]
	[list_item]A pulvinar ut, parturient enim porta ut sed, mus amet nunc, in.[/list_item]
	[list_item]Duis sociis, elit odio dapibus nec, dignissim purus est magna integer.[/list_item]
	[list_item]Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus.[/list_item]
[/list]
*/
$sc_list_counter = 0;
function sc_list($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "default",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	global $sc_list_counter;
	$sc_list_counter = 0;
	if (trim($style) == '') $style = 'default';
	return '
		<ul' . ($id ? ' id="' . $id . '"' : '') . ($style!='default' ? ' class="sc_list sc_list_style_' . $style . '"' : '').($s!='' ? ' style="'.$s.'"' : '') . '>
			' . do_shortcode($content) . '
		</ul>
		';
}


add_shortcode('list_item', 'sc_list_item');

//[list_item]
function sc_list_item($atts, $content=null) {
	extract(shortcode_atts( array(
		"id" => "",
		"style" => "default",
		"title" => ""
	), $atts));
	global $sc_list_counter;
	$sc_list_counter++;
	if (trim($style) == '') $style = 'default';
	return '
		<li' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_list_item' . ($sc_list_counter % 2 == 1 ? ' odd' : ' even') . ($sc_list_counter == 1 ? ' first' : ''). ($style!='default' ? ' sc_list_style_' . $style . '"' : '') . '"' . ($title ? ' title="' . $title . '"' : '') . '><span class="sc_list_icon"></span>
			' . do_shortcode($content) 
			. '
		</li>
	';
}

// ---------------------------------- [/list] ---------------------------------------








// ---------------------------------- [tabs] ---------------------------------------

add_shortcode("tabs", "sc_tabs");

/*
[tabs id="unique_id" tab_names="Planning|Development|Support" style="1|2" initial="1 - num_tabs"]
	[tab]Randomised words which don't look even slightly believable. If you are going to use a passage. You need to be sure there isn't anything embarrassing hidden in the middle of text established fact that a reader will be istracted by the readable content of a page when looking at its layout.[/tab]
	[tab]Fact reader will be distracted by the <a href="#" class="main_link">readable content</a> of a page when. Looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content here, content here, making it look like readable English will uncover many web sites still in their infancy. Various versions have evolved over. There are many variations of passages of Lorem Ipsum available, but the majority.[/tab]
	[tab]Distracted by the  readable content  of a page when. Looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content here, content here, making it look like readable English will uncover many web sites still in their infancy. Various versions have  evolved over.  There are many variations of passages of Lorem Ipsum available.[/tab]
[/tabs]
*/
$sc_tab_counter = 0;
function sc_tabs($atts, $content = null) {
    extract(shortcode_atts(array(
		"id" => "",
		"tab_names" => "",
		"style" => "1",
		"initial" => "1",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	global $sc_tab_counter;
	$sc_tab_counter = 0;
	$title_chunks = explode("|", $tab_names);
	$style = max(1, min(3, (int) $style));
	$initial = max(1, min(count($title_chunks), (int) $initial));
	$tabs_output = '
		<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_tabs sc_tabs_style_' . $style . '"'.($s!='' ? ' style="'.$s.'"' : '') .'>
			<div class="tab_names">';
	$titles_output = '';
	for ($i = 0; $i < count($title_chunks); $i++) {
		$classes = array('tab_name');
		if ($i == 0) $classes[] = 'first';
		else if ($i == count($title_chunks) - 1) $classes[] = 'last';
		$class_str = join(' ', $classes);
		$titles_output .= '<a href="#">' . $title_chunks[$i] . '</a>';
	}

	$tabs_output .= $titles_output.'
			</div>
			' . do_shortcode($content) . '
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery(\'div' . ($id ? '#' . $id : '') . '.sc_tabs_style_' . $style. '\').tabs(\'div.content\', 
						{
							tabs: \'.tab_names > a\',
							initialIndex : ' . ($initial - 1) . '
						}
					);
				});
			</script>
		</div>
	';
	return $tabs_output;
}


add_shortcode("tab", "sc_tab");

//[tab id="tab_id"]
function sc_tab($atts, $content = null) {
    extract(shortcode_atts(array(
		"id" => ""
    ), $atts));
	global $sc_tab_counter;
	$sc_tab_counter++;
	return '
			<div' . ($id ? ' id="' . $id . '"' : '') . ' class="content' . ($sc_tab_counter % 2 == 1 ? ' odd' : ' even') . ($sc_tab_counter == 1 ? ' first' : '') . '">
				' . do_shortcode($content) . '
			</div>
	';
}

// ---------------------------------- [/tabs] ---------------------------------------



// ---------------------------------- [accordion] ---------------------------------------


add_shortcode('accordion', 'sc_accordion');

/*
[accordion id="unique_id" initial="1 - num_elements"]
	[accordion_item title="Et adipiscing integer, scelerisque pid"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta, odio arcu vut natoque dolor ut, enim etiam vut augue. Ac augue amet quis integer ut dictumst? Elit, augue vut egestas! Tristique phasellus cursus egestas a nec a! Sociis et? Augue velit natoque, amet, augue. Vel eu diam, facilisis arcu.[/accordion_item]
	[accordion_item title="A pulvinar ut, parturient enim porta ut sed"]A pulvinar ut, parturient enim porta ut sed, mus amet nunc, in. Magna eros hac montes, et velit. Odio aliquam phasellus enim platea amet. Turpis dictumst ultrices, rhoncus aenean pulvinar? Mus sed rhoncus et cras egestas, non etiam a? Montes? Ac aliquam in nec nisi amet eros! Facilisis! Scelerisque in.[/accordion_item]
	[accordion_item title="Duis sociis, elit odio dapibus nec"]Duis sociis, elit odio dapibus nec, dignissim purus est magna integer eu porta sagittis ut, pid rhoncus facilisis porttitor porta, et, urna parturient mid augue a, in sit arcu augue, sit lectus, natoque montes odio, enim. Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus, vut enim habitasse cum magna.[/accordion_item]
	[accordion_item title="Nec purus, cras tincidunt rhoncus"]Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus, vut enim habitasse cum magna. Duis sociis, elit odio dapibus nec, dignissim purus est magna integer eu porta sagittis ut, pid rhoncus facilisis porttitor porta, et, urna parturient mid augue a, in sit arcu augue, sit lectus, natoque montes odio, enim.[/accordion_item]
[/accordion]
*/
$sc_accordion_counter = 0;
function sc_accordion($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"initial" => "1",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	global $sc_accordion_counter;
	$sc_accordion_counter = 0;
	$initial = max(0, (int) $initial);
	return '
		<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_accordion"'.($s!='' ? ' style="'.$s.'"' : '') .'>
			' . do_shortcode($content) . '
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery(\'div' . ($id ? '#' . $id : '') . '.sc_accordion\').tabs(\'div.sc_accordion_item > div.sc_accordion_content\', {
					tabs: \'.sc_accordion_title > a\',
					effect : \'slide\',
					currentClose: true
					' . ($initial>0 ? ', initialIndex : ' . ($initial-1) : '') . '
				});
			});
		</script>		
	';
}


add_shortcode('accordion_item', 'sc_accordion_item');

//[accordion_item]
function sc_accordion_item($atts, $content=null) {
	extract(shortcode_atts( array(
		"id" => "",
		"title" => ""
	), $atts));
	global $sc_accordion_counter;
	$sc_accordion_counter++;
	return '
		<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_accordion_item' . ($sc_accordion_counter % 2 == 1 ? ' odd' : ' even') . ($sc_accordion_counter == 1 ? ' first' : '') . '">
			<h4 class="sc_accordion_title"><a href="#"><span class="sc_accordion_icon"></span>'	. $title . '</a></h4>
			<div class="sc_accordion_content">
				' . do_shortcode($content) . '
			</div>
		</div>
	';
}

// ---------------------------------- [/accordion] ---------------------------------------



// ---------------------------------- [toggles] ---------------------------------------


add_shortcode('toggles', 'sc_toggles');

/*
[toggles id="unique_id" initial="1 - num_elements"]
	[toggles_item title="Et adipiscing integer, scelerisque pid"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta, odio arcu vut natoque dolor ut, enim etiam vut augue. Ac augue amet quis integer ut dictumst? Elit, augue vut egestas! Tristique phasellus cursus egestas a nec a! Sociis et? Augue velit natoque, amet, augue. Vel eu diam, facilisis arcu.[/toggles_item]
	[toggles_item title="A pulvinar ut, parturient enim porta ut sed"]A pulvinar ut, parturient enim porta ut sed, mus amet nunc, in. Magna eros hac montes, et velit. Odio aliquam phasellus enim platea amet. Turpis dictumst ultrices, rhoncus aenean pulvinar? Mus sed rhoncus et cras egestas, non etiam a? Montes? Ac aliquam in nec nisi amet eros! Facilisis! Scelerisque in.[/toggles_item]
	[toggles_item title="Duis sociis, elit odio dapibus nec"]Duis sociis, elit odio dapibus nec, dignissim purus est magna integer eu porta sagittis ut, pid rhoncus facilisis porttitor porta, et, urna parturient mid augue a, in sit arcu augue, sit lectus, natoque montes odio, enim. Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus, vut enim habitasse cum magna.[/toggles_item]
	[toggles_item title="Nec purus, cras tincidunt rhoncus"]Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus, vut enim habitasse cum magna. Duis sociis, elit odio dapibus nec, dignissim purus est magna integer eu porta sagittis ut, pid rhoncus facilisis porttitor porta, et, urna parturient mid augue a, in sit arcu augue, sit lectus, natoque montes odio, enim.[/toggles_item]
[/toggles]
*/
$sc_toggle_counter = 0;
function sc_toggles($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"initial" => "0",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	global $sc_toggle_counter;
	$sc_toggle_counter = 0;
	$initial = max(0, (int) $initial);
	return '
		<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_toggles"'.($s!='' ? ' style="'.$s.'"' : '') .'>
			'
			. do_shortcode($content)
			. '
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery(\'div' . ($id ? '#' . $id : '') . '.sc_toggles\').tabs(\'div.sc_toggles_item > div.sc_toggles_content\', {
					tabs: \'.sc_toggles_title > a\',
					effect : \'slide\',
					currentClose: true,
					anotherClose: false
					' . ($initial>0 ? ', initialIndex : ' . ($initial-1) : '') . '
				});
			});
		</script>		
	';
}


add_shortcode('toggles_item', 'sc_toggles_item');

//[toggles_item]
function sc_toggles_item($atts, $content=null) {
	extract(shortcode_atts( array(
		"id" => "",
		"title" => ""
	), $atts));
	global $sc_toggle_counter;
	$sc_toggle_counter++;
	return '
		<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_toggles_item' . ($sc_toggle_counter % 2 == 1 ? ' odd' : ' even') . ($sc_toggle_counter == 1 ? ' first' : '') . '">
			<h4 class="sc_toggles_title"><a href="#"><span class="sc_toggles_icon"></span>' . $title . '</a></h4>
			<div class="sc_toggles_content">
				' . do_shortcode($content) . '
			</div>
		</div>
	';
}

// ---------------------------------- [/toggles] ---------------------------------------



// ---------------------------------- [table] ---------------------------------------


add_shortcode('table', 'sc_table');

/*
[table id="unique_id" style="regular"]
Table content, generated on one of many public internet resources, for example: http://www.impressivewebs.com/html-table-code-generator/
[/table]
*/
function sc_table($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "regular",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	$content = str_replace(
				array('<p><table', 'table></p>', '><br />'),
				array('<table', 'table>', '>'),
				html_entity_decode($content, ENT_COMPAT, 'UTF-8'));
	return '
		<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_table sc_table_style_' . $style . '"'.($s!='' ? ' style="'.$s.'"' : '') .'>
			' . do_shortcode($content) . '
		</div>
	';
}

// ---------------------------------- [/table] ---------------------------------------



// ---------------------------------- [Google maps] ---------------------------------------

add_shortcode("googlemap", "sc_google_map");

//[googlemap id="unique_id" address="your_address" width="width_in_pixels_or_percent" height="height_in_pixels"]
function sc_google_map($atts, $content = null) {
	extract(shortcode_atts(array(
		"id" => "sc_googlemap",
		"width" => "100%",
		"height" => "170",
		"address" => "",
		"latlng" => "",
		"zoom" => 16,
		"top" => "",
		"bottom" => ""
    ), $atts));

	$ed = my_substr($width, -1)=='%' ? '%' : 'px';
	if ((int) $width < 100 && $ed != '%') $width='100%';
	if ((int) $height < 50) $height='100';
	$width = (int) str_replace('%', '', $width);
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($width >= 0 ? 'width:' . $width . $ed . ';' : '')
		.($height >= 0 ? 'height:' . $height . 'px;' : '');

	wp_enqueue_script( 'googlemap', 'http://maps.google.com/maps/api/js?sensor=false', array(), '1.0.0', true );
	wp_enqueue_script( 'googlemap_init', get_template_directory_uri().'/js/googlemap_init.js', array(), '1.0.0', true );
	return '
	    <script type="text/javascript">
	    	jQuery(document).ready(function(){
				googlemap_init(jQuery("#' . $id . '").get(0), {address: "' . $address . '", latlng: "' . $latlng . '", zoom: '.$zoom.'});
	    	});
		</script>
		<div id="' . $id . '" class="sc_googlemap"'.($s!='' ? ' style="'.$s.'"' : '') .'></div>
	';
}
// ---------------------------------- [/Google maps] ---------------------------------------





// ---------------------------------- [Contact form] ---------------------------------------

add_shortcode("contact_form", "sc_contact_form");

//[contact_form id="unique_id" title="Contact Form" description="Mauris aliquam habitasse magna a arcu eu mus sociis? Enim nunc? Integer facilisis, et eu dictumst, adipiscing tempor ultricies, lundium urna lacus quis."]
function sc_contact_form($atts, $content = null) {
	extract(shortcode_atts(array(
		"id" => "",
		"title" => "",
		"description" => "",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	wp_enqueue_script( 'contact_form', get_template_directory_uri().'/js/contact-form.js', array('jquery'), '1.0.0', true );
	global $ajax_nonce, $ajax_url;
	return '
			<div ' . ($id ? ' id="' . $id . '"' : '') . 'class="sc_contact_form"'.($s!='' ? ' style="'.$s.'"' : '') .'>
				'
				. ($title ? '<h3 class="title">' . $title . '</h3>' : '')
				. ($description ? '<span class="description">' . $description . '</span>' : '')
				. 
				'
				<form' . ($id ? ' id="' . $id . '"' : '') . ' method="post" action="' . $ajax_url . '">
					<div class="field field_name">
						<input type="text" id="sc_contact_form_username" name="username" placeholder="' . __('Your Name*', 'wpspace') . '">
                    </div>
					<div class="field field_email">
						<input type="text" id="sc_contact_form_email" name="email" placeholder="' . __('Your Email*', 'wpspace') . '">
                    </div>
					<div class="field field_message">
						<textarea id="sc_contact_form_message" name="message" placeholder="' . __('Your Message*', 'wpspace') . '"></textarea>
                    </div>
					<div class="button">
						<a href="#" class="enter"><span>' . __('Submit', 'wpspace') . '</span></a>
                    </div>
					<div class="result sc_infobox"></div>
				</form>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery(".sc_contact_form .enter").click(function(e){
							userSubmitForm(jQuery(this).parents("form"), "' . $ajax_url . '", "' . $ajax_nonce . '");
							e.preventDefault();
							return false;
						});
					});
				</script>
			</div>
	';
}
// ---------------------------------- [/Contact form] ---------------------------------------



// ---------------------------------- [hide] ---------------------------------------


add_shortcode('hide', 'sc_hide');

/*
[hide selector="unique_id"]
*/
function sc_hide($atts, $content=null){	
    extract(shortcode_atts(array(
		"selector" => ""
    ), $atts));
	$selector = trim(chop($selector));
	return $selector == '' ? '' : '
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("' . $selector . '").hide();
			});
		</script>		
	';
}
// ---------------------------------- [/hide] ---------------------------------------



// ---------------------------------- [skills] ---------------------------------------


add_shortcode('skills', 'sc_skills');

/*
[skills id="unique_id"]
	[skills_item title="Scelerisque pid" level="50%"]
	[skills_item title="Scelerisque pid" level="50%"]
	[skills_item title="Scelerisque pid" level="50%"]
[/skills]
*/
$sc_skills_counter = 0;
function sc_skills($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	global $sc_skills_counter;
	$sc_skills_counter = 0;
	return '
		<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_skills"'.($s!='' ? ' style="'.$s.'"' : '') .'>
			'
			. do_shortcode($content)
			. '
		</div>
	';
}


add_shortcode('skills_item', 'sc_skills_item');

//[skills_item]
function sc_skills_item($atts, $content=null) {
	extract(shortcode_atts( array(
		"id" => "",
		"title" => "",
		"level" => "",
		"color" => ""
	), $atts));
	global $sc_skills_counter;
	$sc_skills_counter++;
	return '<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_skills_item' . ($sc_skills_counter % 2 == 1 ? ' odd' : ' even') . ($sc_skills_counter == 1 ? ' first' : '') . '">'
		. '<div class="sc_skills_progressbar">'
			. '<span class="sc_skills_progress" style="width:' . (my_substr($level, -1)=='%' ? $level : $level.'%') . '">'
				. '<span class="sc_skills_caption">' . $title . '</span>'
			. '</span>' 
			. '<span class="sc_skills_level"' . ($color ? ' style="background-color:' . $color . '"' : '') . '>' . $level . '</span>'
		. '</div>'
		. '</div>';
}

// ---------------------------------- [/skills] ---------------------------------------



// ---------------------------------- [team] ---------------------------------------


add_shortcode('team', 'sc_team');

/*
[team id="unique_id" style="normal|big"]
	[team_item user="user_login"]
[/team]
*/
$sc_team_counter = 0;
function sc_team($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "normal",
		"top" => "",
		"bottom" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	global $sc_team_counter;
	$sc_team_counter = 0;
	return '
		<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_team ' . ($style=='big' ? 'sc_team_big' : 'sc_team_normal') . '"'.($s!='' ? ' style="'.$s.'"' : '') .'>
			'
			. do_shortcode($content)
			. '
		</div>
	';
}


add_shortcode('team_item', 'sc_team_item');

//[team_item]
function sc_team_item($atts, $content=null) {
	extract(shortcode_atts( array(
		"id" => "",
		"user" => ""
	), $atts));
	global $sc_team_counter;
	$sc_team_counter++;
	if (($user = get_user_by('login', $user)) != false) {
		$meta = get_user_meta($user->ID);
		return '<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_team_item sc_team_item_' . $sc_team_counter . ($sc_team_counter % 2 == 1 ? ' odd' : ' even') . ($sc_team_counter == 1 ? ' first' : '') . '">'
				. '<div class="sc_team_item_avatar">' . get_avatar($user->data->user_email, 370) . '</div>'
				. '<h2 class="sc_team_item_title">' . $user->data->display_name . '</h2>'
				. '<div class="sc_team_item_position">' . (isset($meta['user_position'][0]) ? $meta['user_position'][0] : '') . '</div>'
				. '<div class="sc_team_item_description">' . (isset($meta['description'][0]) ? nl2br($meta['description'][0]) : '') . '</div>'
				. '<div class="sc_team_item_social">' . showUserSocialLinks(array('author_id'=>$user->ID, 'echo'=>false)) . '</div>'
			. '</div>';
	}
	return '';
}

// ---------------------------------- [/team] ---------------------------------------



// ---------------------------------- [testimonials] ---------------------------------------


add_shortcode('testimonials', 'sc_testimonials');

/*
[testimonials id="unique_id" user="user_login" style="callout|flat"]Testimonials text[/testimonials]
or
[testimonials id="unique_id" email="" name="" position="" photo="photo_url"]Testimonials text[/testimonials]
*/
function sc_testimonials($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"user" => "",
		"name" => "",
		"position" => "",
		"photo" => "",
		"email" => "",
		"style" => "callout",
		"top" => "",
		"bottom" => ""
	), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	$mult = min(2, max(1, get_theme_option("retina_ready")));
	if (!empty($user) && ($author = get_user_by('login', $user)) != false) {
		$meta = get_user_meta($author->ID);
		$name = $author->data->display_name;
		$position = $meta['user_position'][0];
		$photo = get_avatar($author->data->user_email, 45*$mult);
	} else
		$photo = getResizedImageTag($photo, 45*$mult, 45*$mult);
	return '<div' . ($id ? ' id="' . $id . '"' : '') . ' class="sc_testimonials sc_testimonials_style_'.$style.'"' . ($s!='' ? ' style="'.$s.'"' : '') . '>'
				. '<div class="sc_testimonials_content">' . ($style=='callout' ? '<span class="icon-quote"></span>' : '') . do_shortcode($content) . '</div>'
				. '<div class="sc_testimonials_extra"><div class="sc_testimonials_extra_inner"></div></div>'
				. '<div class="sc_testimonials_user">'
					. '<div class="sc_testimonials_avatar_wrapper"><div class="sc_testimonials_avatar image_wrapper pic_wrapper">' . $photo . '</div></div>'
					. '<h4 class="sc_testimonials_title">' . $name . '</h4>'
					. '<div class="sc_testimonials_position">' . $position . '</div>'
				. '</div>'
			. '</div>';
}

// ---------------------------------- [/testimonials] ---------------------------------------





// ---------------------------------- [blogger] ---------------------------------------


add_shortcode('blogger', 'sc_blogger');

/*
[blogger id="unique_id" ids="comma_separated_list" cat="category_id" orderby="date|views|comments" order="asc|desc" count="5" descr="0" dir="horizontal|vertical" style="date|underline|image_large|image_medium|image_small|bubble_right|bubble_down|accordion" border="0" slider="0"]
*/
$sc_blogger_counter = 0;
function sc_blogger($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "bubble_right",
		"bubble_color" => "",
		"ids" => "",
		"cat" => "",
		"count" => "3",
		"offset" => "",
		"orderby" => "date",
		"order" => "desc",
		"descr" => "0",
		"readmore" => "1",
		"dir" => "horizontal",
		"border" => "0",
		"slider" => "0",
		"top" => "",
		"bottom" => ""
    ), $atts));
	
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '');
	
	global $sc_blogger_counter, $post;
	$sc_blogger_counter = 0;

	if (!in_array($style, array('date','underline','image_large','image_medium','image_small','bubble_right','bubble_down', 'accordion')))
		$style='bubble_right';	
	if (!empty($ids)) {
		$posts = explode(',', $ids);
		$count = count($posts);
	}
	if ($style=='accordion')
		$dir = 'vertical';
	
	$useSlider = $dir!='vertical' && $slider > 0 && $slider < $count && in_array($style, array('image_large','image_medium'));
	
	$output = '
		<div' . ($id ? ' id="' . $id . '"' : '') 
			. ' class="sc_blogger'
				. ' sc_blogger_' . ($dir=='vertical' ? 'vertical' : 'horizontal')
				. ' style_' . $style
				. ($style=='accordion' ? ' sc_accordion' : '')
				. ($dir!='vertical' && !$useSlider ? ' sc_columns sc_columns_count_'.$count : '')
				. ($useSlider  ? ' sc_blogger_slider' : '')
				. '"'
			. ($s!='' ? ' style="'.$s.'"' : '')
		. '>';
	if ($useSlider) {
		$output .= '
			<div class="sc_blogger_slider_wrapper">
				<ul class="slides">
				'; 
	}

	$mult = min(2, max(1, get_theme_option("retina_ready")));
	$counters = get_theme_option("blog_counters");

	$args = array(
		'post_type' => array('post', 'page'),
		'post_status' => 'publish',
		'posts_per_page' => $count,
		'ignore_sticky_posts' => 1,
		'order' => $order=='asc' ? 'asc' : 'desc',
		'orderby' => 'date',
	);
	if ($orderby=='views') {					// Most popular
		$args['meta_key'] = 'post_views_count';
		$args['orderby'] = 'meta_value_num';
	} else if ($orderby=='comments') {			// Most commented
		$args['orderby'] = 'comment_count';
	}
	if (!empty($ids)) {
		$args['post__in'] = $posts;
	} else if (!empty($cat)) {
		if ($cat > 0) 
			$args['cat'] = (int) $cat;
		else
			$args['category_name'] = $cat;
	}
	if ($offset > 0 && empty($ids)) {
		$args['offset'] = $offset;
	}
	$query = new WP_Query( $args );
	while ( $query->have_posts() ) { 
		$query->the_post();
		$post_id = get_the_ID();
		$post_title = get_the_title();
		//$post_excerpt = getShortString(str_replace('[...]', '', get_the_excerpt()), $descr, $readmore>0 ? '' : '...');
		$post_excerpt = getShortString(trim(chop($post->post_excerpt))!='' ? trim(chop($post->post_excerpt)) : strip_tags($post->post_content), $descr, $readmore>0 ? '' : '...');
		$post_link = get_permalink();
		$post_comments_link = $counters=='comments' ? get_comments_link( $post_id ) : $post_link;
		$post_comments = get_comments_number();
		$post_views = getPostViews($post_id);
		$post_date = get_the_date();
		$post_title_tag = $style == 'underline' ? 'h2' : 'h4';
		if (my_strpos($style, 'bubble')!==false) {
			$post_custom_options = get_post_meta($post_id, 'post_custom_options', true);
			$post_icon = isset($post_custom_options['page_icon']) ? $post_custom_options['page_icon'] : get_post_meta($post_id, 'page_icon', true);
			$post_title_tag = 'h1';
		} else if ($style=='image_small')
			$post_thumb = getResizedImageTag($post_id, 121*$mult, 74*$mult);
		else if ($style=='image_medium')
			$post_thumb = getResizedImageTag($post_id, 260*$mult, 160*$mult);
		else if ($style=='image_large')
			$post_thumb = getResizedImageTag($post_id, 360*$mult, 222*$mult);
		$post_attachment = wp_get_attachment_url(get_post_thumbnail_id($post_id));
		$sc_blogger_counter++;
		if ($useSlider) $output .= '<li>';
		$output .= '
			<div class="sc_blogger_item'
				. ($style == 'date' ? ' sc_blogger_item_date' : '')
				. ($style == 'image_small' ? '  sc_blogger_item_image_left' : '')
				. ($style == 'accordion' ? ' sc_accordion_item' : '')
				. ($dir!='vertical' && ($slider==0 || $slider>=$count) ? ' sc_column_item sc_column_item_'.$sc_blogger_counter : '')
				. ($border == 1 ? ' sc_blogger_item_bordered' : '')
				. ($sc_blogger_counter % 2 == 1 ? ' odd' : ' even') 
				. ($sc_blogger_counter == 1 ? ' first' : '') 
				. '">
			';
		if ($style == 'date' ) {
			$output .= '
				<div class="date_area">
					<div class="date_month">' . date('M', strtotime($post_date)) . '</div>
					<div class="date_day">' . date('d', strtotime($post_date)) . '</div>
				</div>
				';
		} else if (my_strpos($style, 'image')!==false) {
			$output .= '
				<div class="pic_wrapper image_wrapper">
					' . $post_thumb;
			if ($style=='image_medium' || $style=='image_large') {
				$output .= '
					<span class="image_overlay"></span>
					<a href="'.$post_link.'" class="image_link"><span class="icon-link"></span></a>
					<a href="'.$post_attachment.'" class="image_zoom prettyPhoto"><span class="icon-search"></span></a>
					';
			}
			$output .= '
				</div>
				<div class="post_wrapper">
					<div class="title_area">
						' . ($counters=='none' ? '' : '
						<span class="post_comments">
							<a href="'.$post_comments_link.'">
							<span class="icon-'.($orderby=='comments' || $counters=='comments' ? 'comment' : 'eye').'"></span>
							<span class="post_comments_number">'.($orderby=='comments' || $counters=='comments' ? $post_comments : $post_views).'</span>
							</a>
						</span>
						');
		}
		$output .= '
						<' . $post_title_tag 
							. ' class="sc_blogger_title'
							. ($style=='underline' ? ' sc_title' : '')
							. ($style=='accordion' ? ' sc_accordion_title' : '')

							. (my_strpos($style, 'bubble')!==false ? ' sc_title_bubble sc_title_'.$style : '')
							. '"><a href="' . $post_link . '">'
							. (my_substr($style, 0, 6)=='bubble' 
								? '<span class="sc_title_bubble_icon '.($post_icon!='' ? ' '.$post_icon : '').'"'.($bubble_color!='' ? ' style="background-color:'.$bubble_color.'"' : '').'></span>' 
								: '')
							. ($style=='accordion' ? '<span class="sc_accordion_icon"></span>' : '') 
							. $post_title 
							. '</a></' . $post_title_tag . '>
						';
		if (my_strpos($style, 'image')!==false ) {
			$output .= '
					</div>
					<div class="post_info">
						<span class="post_date">' . $post_date . '</span>
					</div>
					';
		}
		if ($descr > 0) {
			$output .= '<div class="post_content' . ($style=='accordion' ? ' sc_accordion_content' : '') . '">'.$post_excerpt
				. ($readmore > 0 ? '&nbsp;<a href="' . $post_link . '" class="readmore">&raquo;</a>' : '')
				. '</div>';
		}
		if (my_strpos($style, 'image')!==false ) {
			$output .= '
						</div>
						';
		}
		$output .= '
				</div>
				';
		if ($useSlider) $output .= '</li>';
	}
	wp_reset_postdata();

	if ($useSlider) {
		$output .= '
				</ul>
			</div>
			';
	}
	$output .= '
		</div>
	';
	if ($useSlider) {
		//wp_enqueue_script('modernizr', get_template_directory_uri().'/js/modernizr.custom.17475.js', array(), '1.1.0', false);
		wp_enqueue_script('elastislide', get_template_directory_uri().'/js/jquery.elastislide.js', array('jquery'), '1.1.0', true);
		$output .= '
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("' . ($id ? '#' . $id : '') . '.sc_blogger_slider").elastislide({
						minItems: '.$slider.',
						margin: 26,
						border: 0,
						imageW: ' . ($style=='image_medium' ? 272 : 372) . '
					});
				});
			</script>
		';
	} else if ($style=='accordion') {
		$output .= '
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery(\'div' . ($id ? '#' . $id : '') . '.sc_blogger.sc_accordion\').tabs(\'div.sc_accordion_item > div.sc_accordion_content\', {
						tabs: \'.sc_accordion_title > a\',
						effect : \'slide\',
						currentClose: true
					});
				});
			</script>
		';
	}
	if ($border == 1) {
		$output .= '
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var maxHeight = 0;
					for (var i=0; i<2; i++) {
						jQuery(\'.sc_blogger_item_bordered\').each(function(){
							if (i > 0) {
								if (maxHeight>0) jQuery(this).height(maxHeight);
							} else if (jQuery(this).height() > maxHeight)
								maxHeight = jQuery(this).height();
						});
					}
				});
			</script>
		';
	}
	return $output;
}
// ---------------------------------- [/blogger] ---------------------------------------





// ---------------------------------- [slider] ---------------------------------------


add_shortcode('slider', 'sc_slider');

/*
[slider id="unique_id" engine="revo|flex" alias="revolution_slider_alias" cat="category_id or slug" count="posts_number" ids="comma_separated_id_list" offset="" width="" height="" align="" top="" bottom=""]
*/
function sc_slider($atts, $content=null){	
    extract(shortcode_atts(array(
		"id" => "",
		"engine" => "flex",
		"alias" => "",
		"ids" => "",
		"cat" => "",
		"count" => "0",
		"offset" => "",
		"width" => "",
		"height" => "",
		"align" => "",
		"border" => "0",
		"top" => "",
		"bottom" => ""
    ), $atts));
	
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.(!empty($width) ? 'width:' . $width . (my_strpos($width, '%')!==false ? '' : 'px').';' : '')
		.(!empty($height) ? 'height:' . $height . (my_strpos($height, '%')!==false ? '' : 'px').';' : '')
		;
	
	$output = '
		<div' . ($id ? ' id="' . $id . '"' : '') 
			. ' class="sc_slider'
				. ' sc_slider_' . $engine
				. ($align ? ' align'.$align : '')
				. ($border ? ' sc_slider_border' : '')
				. '"'
			. ($s!='' ? ' style="'.$s.'"' : '')
		. '>';

	if ($engine=='revo') {
		if (is_plugin_active('revslider/revslider.php') && !empty($alias))
			$output .= do_shortcode('[rev_slider '.$alias.']');
		else
			$output = '';
	} else if ($engine=='flex') {
		
		$output .= '
				<ul class="slides">
				';

		global $post;
		$mult = min(2, max(1, get_theme_option("retina_ready")));

		if (!empty($ids)) {
			$posts = explode(',', $ids);
			$count = count($posts);
		}
	
		$args = array(
			'post_type' => array('post', 'page'),
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'ignore_sticky_posts' => 1,
			'order' => 'desc',
			'orderby' => 'date',
			'meta_key' => '_thumbnail_id',
			'meta_value' => false,
			'meta_compare' => '!='
		);
		if (!empty($ids)) {
			$args['post__in'] = $posts;
		} else if (!empty($cat)) {
			if ($cat > 0) 
				$args['cat'] = (int) $cat;
			else
				$args['category_name'] = $cat;
		}
		if ($offset > 0 && empty($ids)) {
			$args['offset'] = $offset;
		}
		$query = new WP_Query( $args );
		while ( $query->have_posts() ) { 
			$query->the_post();
			$post_id = get_the_ID();
			$post_link = get_permalink();
			$post_attachment = wp_get_attachment_url(get_post_thumbnail_id($post_id));
			$output .= '
				<li style="background-image:url(' . $post_attachment . ')">
					<a href="'. $post_link . '"></a>
				</li>
				';
		}
		wp_reset_postdata();
	
		$output .= '
				</ul>
		';
	
	} else
		$output = '';
	$output .= !empty($output) ? '</div>' : '';
	return $output;
}
?>