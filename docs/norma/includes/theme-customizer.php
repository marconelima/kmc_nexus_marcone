<?php
// Redefine colors in styles
function getThemeCustomStyles() {
	$custom_css = "";
	$font = get_custom_option('theme_font');
	$fonts = getFontsList(false);
	if (isset($fonts[$font])) {
		$custom_css .= "
		body, button, input, select, textarea,
		.tp-caption {
			font-family: '".$font."', ".$fonts[$font]['family'].";
		}
		";
	}
	$tc = get_custom_option('theme_color');
	$hsb = Hex2HSB($tc);
	$hsb['s'] = round($hsb['s']*0.5);
	$hsb['b'] = min(100, round($hsb['b']*1.2));
	$tc_light = HSB2Hex($hsb);
	$custom_css .= "
	/* Main styles*/
	.image_wrapper .image_link:hover,
	.image_wrapper .image_zoom:hover {
		background-color:{$tc};
	}
	.post_info a:hover {
		color:{$tc} !important;
	}
	a, a:hover, a:visited {
		color: {$tc};
	}
	.post_views a:hover,
	.post_comments a:hover {
		color:{$tc} !important;
	}
	.post_comments a:hover .comments_number {
		color:{$tc} !important;
	}
	.post_views a:hover [class^=\"icon-\"]:before,
	.post_views a:hover [class*=\" icon-\"]:before,
	.post_comments a:hover [class^=\"icon-\"]:before,
	.post_comments a:hover [class*=\" icon-\"]:before {
		color:{$tc} !important;
	}
	#header_top_inner .login_or_register a:hover {
		color:{$tc};
	}
	#header_top_inner .social:hover [class^=\"icon-\"]:before,
	#header_top_inner .social:hover [class*=\" icon-\"]:before {
		color:{$tc};
	}
	#header_top_inner .header_icons .search_link [class^=\"icon-\"]:before,
	#header_top_inner .header_icons .search_link [class*=\" icon-\"]:before {
		color:{$tc};
	}
	#header_middle_inner .logo_default a:hover {
		color:{$tc};
	}
		#header_middle_inner .logo_norma_top {
			background-color:{$tc};
		}
		#header_middle_inner .logo_norma_top:before {
			background-color:{$tc};
		}
		#header_middle_inner .logo_norma_top:after {
			background-color:{$tc};
		}
	#header_middle_inner #mainmenu > li > a:hover,
	#header_middle_inner #mainmenu > li.sfHover > a {
		border-bottom-color:{$tc};
	}
	#header_middle_inner #mainmenu > li ul {
		background: {$tc};
	}
	.breadcrumbs li a:hover {
		color: {$tc};
	}
	#content .more-link:hover {
		color: {$tc};
	}
	.content_blog .post_title a:hover {
		color: {$tc};
	}
	.content_blog .post_format_quote .post_content:before {
		color:{$tc};
	}
	.content_blog .post_format_quote .post_content a:hover {
		color:{$tc};
	}
	.content_blog #portfolio_iso_filters a.current,
	.content_blog #portfolio_iso_filters a:hover {
		color:{$tc};
	}
	#nav_pages li a:hover,
	.nav_pages_parts a:hover,
	.nav_comments a:hover {
		color: {$tc};
	}
	.sc_slider_flex .flex-direction-nav li:before {
		background-color: {$tc};
	}
	.sc_slider_flex .flex-control-nav a.flex-active,
	.sc_slider_flex .flex-control-nav a:hover {
		background-color:{$tc};
	}
	.post_info_1 .post_format {	
		background-color:{$tc}; 
	}
	.blog_style_b2 .title_area {
		border-left-color: {$tc};
	}
	.blog_style_b3 .post_title:after,
	.content_blog.post_single .subtitle_area .post_subtitle:after,
	.content_blog.post_single #comments #reply-title:after {
		border-bottom-color: {$tc};
	}
	.blog_style_p1 .title_area .post_categories a:hover {
		color: {$tc};
	}
	.blog_style_p2 .title_area .post_categories a:hover,
	.blog_style_p3 .title_area .post_categories a:hover,
	.blog_style_p4 .title_area .post_categories a:hover {
		color: {$tc};
	}
	.content_blog .post_social .social:hover [class^=\"icon-\"]:before,
	.content_blog .post_social .social:hover [class*=\" icon-\"]:before {
		color:{$tc};
	}
	.content_blog .post_author_details .extra_wrap h3 a:hover {
		color:{$tc};
	}
	.content_blog.post_single #related_posts .related_posts_item .title_area a:hover {
		color:{$tc};
	}
	.content_blog.post_single #comments .comment_title_area .comment_reply a:hover {
		color: {$tc};
	}
	.content_blog.post_single #comments .comment_title_area .comment_title a:hover {
		color: {$tc};
	}
	.content_blog.post_single #commentform #submit:hover {
		color:{$tc};
	}
	.blog_style_p1.post_single #related_posts .post_info a:hover {
		color:{$tc} !important;
	}
	.blog_style_p1.post_single .post_details .post_url a {
		color:{$tc} !important;
	}
	.content_blog article.page_404 .post_content .post_subtitle {
		color:{$tc};
	}
	.content_blog article.page_404 .post_content .search_form_link:hover .icon-search:before {
		color:{$tc};
	}
	#sidebar_main .widget .widget_title:after {
		border-bottom-color: {$tc};
	}
	#sidebar_main .widget ul li:hover:before,
	#advert_sidebar_inner .widget ul li:hover:before {
		background:{$tc};
		border-color:{$tc};
	}
	#sidebar_main .widget ul li a:hover,
	#advert_sidebar_inner .widget ul li a:hover {
		color:{$tc};
	}
	#sidebar_main .widget.widget_tag_cloud a:hover,
	#advert_sidebar_inner .widget.widget_tag_cloud a:hover {
		border-color:{$tc};
		background-color:{$tc};
	}
	#sidebar_main .widget.widget_calendar table tbody a:hover,
	#advert_sidebar_inner .widget.widget_calendar table tbody a:hover {
		color:{$tc};
	}
	#sidebar_main .widget.widget_calendar table tfoot a:hover,
	#advert_sidebar_inner .widget.widget_calendar table tfoot a:hover {
		color:{$tc};
	}
	#sidebar_main .widget .post_title a:hover,
	#advert_sidebar_inner .widget .post_title a:hover {
		color:{$tc};
	}
	#sidebar_main .widget .post_author a:hover,
	#advert_sidebar_inner .widget .post_author a:hover {
		color:{$tc};
	}
	#sidebar_main .sc_contact_form .button a,
	#advert_sidebar_inner .sc_contact_form .button a {
		background-color:{$tc};
	}
	#sidebar_main .widget_contacts .widget_inner a:hover,
	#advert_sidebar_inner .widget_contacts .widget_inner a:hover {
		color:{$tc};
	}
	#sidebar_main .widget_social a:hover [class^=\"icon-\"]:before,
	#advert_sidebar_inner .widget_social a:hover [class*=\" icon-\"]:before {
		color:{$tc};
	}
	#sidebar_main .widget_qrcode_vcard .personal_data a:hover,
	#advert_sidebar_inner .widget_qrcode_vcard .personal_data a:hover {
		color:{$tc};
	}
	#advert_sidebar_inner .widget.widget_text {
		border-right-color:{$tc};
	}
	#footer_sidebar_inner .widget .widget_title:after {
		border-bottom-color: {$tc};
	}
	#footer_sidebar_inner .widget ul li:hover:before {
		background:{$tc};
		border-color:{$tc};
	}
	#footer_sidebar_inner .widget ul li a:hover {
		color:{$tc};
	}
	#footer_sidebar_inner .widget.widget_tag_cloud a:hover {
		border-color:{$tc};
		background-color:{$tc};
	}
	#footer_sidebar_inner .widget .post_title a:hover {
		color:{$tc};
	}
	#footer_sidebar_inner .widget .post_author a:hover {
		color:{$tc};
	}
	#footer_sidebar_inner .widget.widget_popular_posts .tabs a:hover:after,
	#footer_sidebar_inner .widget.widget_popular_posts .tabs a.current:after {
		border-bottom-color: {$tc};
	}
	#footer_sidebar_inner .sc_contact_form .button a {
		background-color:{$tc};
	}
	#footer_sidebar_inner .widget_contacts .widget_inner a:hover {
		color:{$tc};
	}
	#footer_sidebar_inner .widget_social a:hover [class^=\"icon-\"]:before {
		color:{$tc};
	}
	#footer_sidebar_inner .widget_qrcode_vcard a:hover {
		color:{$tc};
	}
	.popup_form .popup_title {
		border-bottom-color:{$tc};
	}
	.popup_form .popup_title .popup_arrow:after {
		border-color: transparent transparent {$tc} transparent;
	}
	.popup_form .popup_field.popup_button a {
		background-color:{$tc};
	}
	.popup_form .popup_body .result.sc_infobox_style_error {
		color:{$tc};
	}
	.popup_form .popup_field input.error_fields_class {
		border-color:{$tc};
	}
	
	/* Shortcodes */
	.sc_title:after {
		border-bottom-color: {$tc};
	}
	.sc_title_bubble_right .sc_title_bubble_icon {
		background-color:{$tc};
	}
	.sc_title_bubble_down .sc_title_bubble_icon {
		background-color:{$tc};
	}
	blockquote.sc_quote {
		border-left-color: {$tc};
	}
	blockquote.sc_quote cite a:hover {
		color:{$tc};
	}
	.sc_dropcaps.sc_dropcaps_style_2 span.sc_dropcap {
		background-color: {$tc};
	}
	ul.sc_list.sc_list_style_mark li span.sc_list_icon,
	ul.sc_list li.sc_list_style_mark span.sc_list_icon {
		background: {$tc};
	}
	.sc_accordion .sc_accordion_item .sc_accordion_title a:hover {
		color:{$tc};
	}
	.sc_accordion .sc_accordion_item .sc_accordion_title a.current {
		color:{$tc};
	}
	.sc_accordion .sc_accordion_item .sc_accordion_title a:hover span:before,
	.sc_accordion .sc_accordion_item .sc_accordion_title a:hover span:after,
	.sc_accordion .sc_accordion_item .sc_accordion_title a.current span:before {
		background: {$tc};
	}
	.sc_toggles .sc_toggles_item .sc_toggles_title a:hover {
		color:{$tc};
	}
	.sc_toggles .sc_toggles_item .sc_toggles_title a.current {
		color:{$tc};
	}
	.sc_toggles .sc_toggles_item .sc_toggles_title a:hover span:before,
	.sc_toggles .sc_toggles_item .sc_toggles_title a:hover span:after,
	.sc_toggles .sc_toggles_item .sc_toggles_title a.current span:before {
		background: {$tc};
	}
	.sc_skills .sc_skills_item .sc_skills_level {
		background:{$tc};
	}
	.sc_team .sc_team_item_social a:hover [class^=\"icon-\"]:before,
	.sc_team .sc_team_item_social a:hover [class*=\" icon-\"]:before {
		color:{$tc};
	}
	.sc_contact_form .button a {
		background-color:{$tc};
	}
	.sc_blogger .sc_blogger_title a:hover {
		color:{$tc};
	}
	.sc_blogger.style_date .date_month {
		background-color:{$tc};
	}
	.sc_blogger.sc_blogger_slider .es-nav span:hover {
		background:{$tc};
		border-color:{$tc};
	}
	#custom_options .co_options #co_bg_images_list a.current,
	#custom_options .co_options #co_bg_pattern_list a.current {
		background-color:{$tc};
	}
	.tp-caption.big_red {
		color:{$tc};
	}
	.tp-caption.bg_red {
		  background-color:{$tc};
	}
	.tp-caption.norma-top {
		background-color:{$tc};
	}
	.tp-caption.norma-top:before {
		background-color:{$tc};
	}
	.tp-caption.norma-top:after {
		background-color:{$tc};
	}
	.tp-caption a.button-red {
		border:1px solid {$tc};
		background: {$tc};
		background: -webkit-gradient(linear, 0 0, 0 100%, from({$tc_light}), to({$tc}));
		background: -webkit-linear-gradient({$tc_light} 0%, {$tc} 100%);
		background: -moz-linear-gradient({$tc_light} 0%, {$tc} 100%);
		background: -ms-linear-gradient({$tc_light} 0%, {$tc} 100%);
		background: -o-linear-gradient({$tc_light} 0%, {$tc} 100%);
		background: linear-gradient({$tc_light} 0%, {$tc} 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$tc_light}', endColorstr='{$tc}',GradientType=0 );
		text-shadow:{$tc} 1px 1px;
	}
	.tp-caption a.button-red:hover {
		background: {$tc};
	}
	";
	return $custom_css;
}
?>