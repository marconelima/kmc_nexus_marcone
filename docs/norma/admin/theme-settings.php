<?php
global $shortname;
$shortname = 'wps';

// Prepare arrays 
$fonts = getFontsList(false);
$categories = getCategoriesList(false);
$sidebars = getSidebarsList(false);
$sliders = getSlidersList(false);
$positions = getSidebarsPositions(false);
$blog_styles = getBlogStylesList(false);
$blog_modes = getBlogModesList(false);
$yes_no = getYesNoList(false);

// Theme options arrays
$theme_options = array();

/*
###############################
#### General               #### 
###############################
*/
$theme_options[] = array( "name" => __('General', 'wpspace'),
			"type" => "heading");
			
$theme_options[] = array( "name" => __('Main menu', 'wpspace'),
			"desc" => __('Attach main menu to top of window then page scroll down', 'wpspace'),
			"id" => $shortname."_"."menu_position",
			"std" => "fixed",
			"type" => "select",
			"options" => array("fixed"=>__("Fix menu position", 'wpspace'), "none"=>__("Don't fix menu position", 'wpspace')));

$theme_options[] = array( "name" => __('Favicon', 'wpspace'),
			"desc" => __('Upload a 16px x 16px image that will represent your website\'s favicon.<br /><br /><em>To ensure cross-browser compatibility, we recommend converting the favicon into .ico format before uploading. (<a href="http://www.favicon.cc/">www.favicon.cc</a>)</em>', 'wpspace'),
			"id" => $shortname."_"."favicon",
			"std" => "",
			"type" => "upload");

$theme_options[] = array( "name" => __('Logo', 'wpspace'),
			"desc" => __('Upload your site logo. Image dimensions up to 200x100', 'wpspace'),
			"id" => $shortname."_"."logo",
			"std" => "",
			"type" => "upload");
			
$theme_options[] = array( "name" => __('Image dimensions', 'wpspace'),
			"desc" => __('What dimensions use for uploaded image: Original or "Retina ready" (twice enlarged)', 'wpspace'),
			"id" => $shortname."_"."retina_ready",
			"std" => "1",
			"type" => "select",
			"options" => array("1"=>__("Original", 'wpspace'), "2"=>__("Retina", 'wpspace')));
			
$theme_options[] = array( "name" => __('Responsive Layouts', 'wpspace'),
			"desc" => __('Do you want use responsive layouts on small screen or still use main layout?', 'wpspace'),
			"id" => $shortname."_"."responsive_layouts",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);
			
$theme_options[] = array( "name" => __('Show Login/Register section', 'wpspace'),
			"desc" => __('Do you want show Login/Register section in page header?', 'wpspace'),
			"id" => $shortname."_"."show_login",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Header "Call us" text',  'wpspace'),
			"desc" => __("Text for field 'Call us' in header area", 'wpspace'),
			"id" => $shortname . '_' . "header_call_us",
			"std" => "Call Us: +1 800 123-4567",
			"type" => "text");
			
$theme_options[] = array( "name" => __('Additional filters in admin panel', 'wpspace'),
			"desc" => __('Show additional filters (on post format and tags) in admin panel page "Posts"', 'wpspace'),
			"id" => $shortname."_"."admin_add_filters",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Footer copyright',  'wpspace'),
			"desc" => __("Copyright text to show in footer area (bottom of site)", 'wpspace'),
			"id" => $shortname . '_' . "footer_copyright",
			"std" => "WP Space &copy; 2013 All Rights Reserved ",
			"type" => "text");


/*
###############################
#### Customization         #### 
###############################
*/
$theme_options[] = array( "name" => __('Color and Background', 'wpspace'),
			"type" => "heading");
			
$theme_options[] = array( "name" => __('Show Theme customizer', 'wpspace'),
			"desc" => __('Show theme customizer', 'wpspace'),
			"id" => $shortname."_"."theme_customizer",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);
			
$theme_options[] = array( "name" => __('Theme font', 'wpspace'),
			"desc" => __('Select theme main font', 'wpspace'),
			"id" => $shortname."_"."theme_font",
			"std" => "Ubuntu",
			"type" => "select",
			"options" => $fonts);

$theme_options[] = array( "name" => __('Theme color',  'wpspace'),
			"desc" => __('Theme main color for each accented elements',  'wpspace'),
			"id" => $shortname . "_" . "theme_color",
			"std" => "#ff5555",
			"type" => "color");
			
$theme_options[] = array( "name" => __('Body style', 'wpspace'),
			"desc" => __('Use boxed or wide body style', 'wpspace'),
			"id" => $shortname."_"."body_style",
			"std" => "boxed",
			"type" => "select",
			"options" => array("boxed"=>__("Boxed", 'wpspace'), "wide"=>__("Wide", 'wpspace')));

$theme_options[] = array( "name" => __('Boxed Body parameters', 'wpspace'),
			"std" => __('This parameters only for fixed body style. Use only background image (if selected), else use background pattern', 'wpspace'),
			"type" => "info");

$theme_options[] = array( "name" => __('Background color',  'wpspace'),
			"desc" => __('Body background color',  'wpspace'),
			"id" => $shortname . "_" . "bg_color",
			"std" => "#bfbfbf",
			"type" => "color");

$theme_options[] = array( "name" => __('Background predefined pattern',  'wpspace'),
			"desc" => __('Select theme background pattern (first case - without pattern)',  'wpspace'),
			"id" => $shortname . "_" . "bg_pattern",
			"std" => "",
			"type" => "images",
			"options" => array(
				0 => get_template_directory_uri().'/images/spacer.png',
				1 => get_template_directory_uri().'/images/bg/pattern_1.png',
				2 => get_template_directory_uri().'/images/bg/pattern_2.png',
				3 => get_template_directory_uri().'/images/bg/pattern_3.png',
				4 => get_template_directory_uri().'/images/bg/pattern_4.png',
				5 => get_template_directory_uri().'/images/bg/pattern_5.png',
			));

$theme_options[] = array( "name" => __('Background custom pattern',  'wpspace'),
			"desc" => __('Select or upload background custom pattern',  'wpspace'),
			"id" => $shortname . "_" . "bg_custom_pattern",
			"std" => "",
			"type" => "mediamanager");

$theme_options[] = array( "name" => __('Background predefined image',  'wpspace'),
			"desc" => __('Select theme background image (first case - without image)',  'wpspace'),
			"id" => $shortname . "_" . "bg_image",
			"std" => "",
			"type" => "images",
			"options" => array(
				0 => get_template_directory_uri().'/images/spacer.png',
				1 => get_template_directory_uri().'/images/bg/image_1.jpg',
				2 => get_template_directory_uri().'/images/bg/image_2.jpg',
				3 => get_template_directory_uri().'/images/bg/image_3.jpg',
			));

$theme_options[] = array( "name" => __('Background image',  'wpspace'),
			"desc" => __('Select or upload background image',  'wpspace'),
			"id" => $shortname . "_" . "bg_custom_image",
			"std" => "",
			"type" => "mediamanager");

$theme_options[] = array( "name" => __('Background custom image position',  'wpspace'),
			"desc" => __('Select custom image position',  'wpspace'),
			"id" => $shortname . "_" . "bg_custom_image_position",
			"std" => "left_top",
			"type" => "select",
			"options" => array(
				'left_top' => "Left Top",
				'center_top' => "Center Top",
				'right_top' => "Right Top",
				'left_center' => "Left Center",
				'center_center' => "Center Center",
				'right_center' => "Right Center",
				'left_bottom' => "Left Bottom",
				'center_bottom' => "Center Bottom",
				'right_bottom' => "Right Bottom",
			));



/*
###############################
#### Main slider           #### 
###############################
*/
$theme_options[] = array( "name" => __('Slider', 'wpspace'),
			"type" => "heading");

$theme_options[] = array( "name" => __('Main slider parameters', 'wpspace'),
			"std" => __('Select parameters for main slider (you can override it in each category and page)', 'wpspace'),
			"override" => "category,page",
			"type" => "info");
			
$theme_options[] = array( "name" => __('Show Slider', 'wpspace'),
			"desc" => __('Do you want to show slider on each page (post)', 'wpspace'),
			"id" => $shortname."_"."slider_show",
			"override" => "category,page",
			"std" => "no",
			"type" => "radio",
			"options" => $yes_no);
			
$theme_options[] = array( "name" => __('Slider display', 'wpspace'),
			"desc" => __('How display slider: fixed width or fullscreen width', 'wpspace'),
			"id" => $shortname."_"."slider_display",
			"override" => "category,page",
			"std" => "none",
			"type" => "select",
			"options" => array("fixed"=>__("Fixed width", 'wpspace'), "fullscreen"=>__("Fullscreen", 'wpspace')));
			
$theme_options[] = array( "name" => __('Slider engine', 'wpspace'),
			"desc" => __('What engine use to show slider: Revolution slider (need to install additional plugin from theme package), Flex Slider or None (don\'t show slider)', 'wpspace'),
			"id" => $shortname."_"."slider_engine",
			"override" => "category,page",
			"std" => "flex",
			"type" => "select",
			"options" => $sliders);

$theme_options[] = array( "name" => __('Revolution Slider alias',  'wpspace'),
			"desc" => __("Slider alias (see in Revolution plugin settings)", 'wpspace'),
			"id" => $shortname . '_' . "slider_alias",
			"override" => "category,page",
			"std" => "",
			"type" => "text");

$theme_options[] = array( "name" => __('Flexslider: Category to show', 'wpspace'),
			"desc" => __('Select category to show in Flexslider (ignored for Revolution slider)', 'wpspace'),
			"id" => $shortname."_"."slider_category",
			"override" => "category,page",
			"std" => "",
			"type" => "select",
			"options" => $categories);

$theme_options[] = array( "name" => __('Flexslider: Number posts or comma separated posts list',  'wpspace'),
			"desc" => __("How many recent posts display in slider or comma separated list of posts ID (in this case selected category ignored)", 'wpspace'),
			"override" => "category,page",
			"id" => $shortname . '_' . "slider_posts",
			"std" => "",
			"type" => "text");


/*
###############################
####Sidebars               #### 
###############################
*/
$theme_options[] = array( "name" => __('Sidebars', 'wpspace'),
			"type" => "heading");

$theme_options[] = array( "name" => __('Custom sidebars',  'wpspace'),
			"desc" => __('Manage custom sidebars. You can use it with each category (page, post) independently',  'wpspace'),
			"id" => $shortname . "_" . "custom_sidebars",
			"std" => "",
			"increment" => true,
			"type" => "text");



/*
###############################
#### Blog                  #### 
###############################
*/
$theme_options[] = array( "name" => __('Blog', 'wpspace'),
			"type" => "heading");

$theme_options[] = array( "name" => __('General Blog parameters', 'wpspace'),
			"type" => "group");

$theme_options[] = array( "name" => __('General Blog parameters', 'wpspace'),
			"std" => __('Select excluded categories, substitute parameters, etc.', 'wpspace'),
			"type" => "info");

$theme_options[] = array( "name" => __('Exclude categories', 'wpspace'),
			"desc" => __('Select categories, which posts are exclude from blog page', 'wpspace'),
			"id" => $shortname."_"."blog_exclude_cats",
			"std" => "",
			"type" => "checklist",
			"multiple" => true,
			"options" => $categories);
/*
$theme_options[] = array( "name" => __('Exclude categories', 'wpspace'),
			"desc" => __('Select categories, which posts are exclude from blog page. You can select multiple categories with Ctrl+click and Shift+click (like Windows Explorer)', 'wpspace'),
			"id" => $shortname."_"."blog_exclude_cats",
			"std" => "",
			"type" => "select",
			"multiple" => true,
			"size" => 10,
			"options" => $categories);
*/

$theme_options[] = array( "name" => __('Blog counters', 'wpspace'),
			"desc" => __('Select counters, displayed near the post title', 'wpspace'),
			"id" => $shortname."_"."blog_counters",
			"std" => "views",
			"type" => "select",
			"options" => array('none'=>__('Don\'t show any counters', 'wpspace'), 'views' => __('Show views number', 'wpspace'), 'comments' => __('Show comments number', 'wpspace')));

$theme_options[] = array( "name" => __('Substitute standard Wordpress gallery', 'wpspace'),
			"desc" => __('Substitute standard Wordpress gallery with our theme-styled gallery', 'wpspace'),
			"id" => $shortname."_"."blog_substitute_gallery",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Substitute audio tag and shortcode', 'wpspace'),
			"desc" => __('Substitute audio tag and shortcode with our theme-styled gallery', 'wpspace'),
			"id" => $shortname."_"."blog_substitute_audio",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Substitute video tag and shortcode', 'wpspace'),
			"desc" => __('Substitute video tag and shortcode with our theme-styled gallery', 'wpspace'),
			"id" => $shortname."_"."blog_substitute_video",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Blog streampage parameters', 'wpspace'),
			"closed" => true,
			"type" => "group");

$theme_options[] = array( "name" => __('Blog streampage parameters', 'wpspace'),
			"std" => __('Select desired blog streampage parameters (you can override it in each category)', 'wpspace'),
			"override" => "category",
			"type" => "info");

$theme_options[] = array( "name" => __('Blog style', 'wpspace'),
			"desc" => __('Select desired blog style', 'wpspace'),
			"id" => $shortname."_"."blog_style",
			"override" => "category",
			"std" => "b1",
			"type" => "select",
			"options" => $blog_styles);

$theme_options[] = array( "name" => __('Blog mode', 'wpspace'),
			"desc" => __('Select desired blog mode', 'wpspace'),
			"id" => $shortname."_"."blog_mode",
			"override" => "category",
			"std" => "full",
			"type" => "select",
			"options" => $blog_modes);

$theme_options[] = array( "name" => __('Blog posts per page',  'wpspace'),
			"desc" => __('How many posts display on blog pages for selected style. If empty or 0 - inherit system wordpress settings',  'wpspace'),
			"id" => $shortname . "_" . "blog_posts_per_page",
			"override" => "category",
			"std" => "",
			"type" => "text");

$theme_options[] = array( "name" => __('Use Isotope slider for portfolio', 'wpspace'),
			"desc" => __('Use Isotope slider for change categories in portfolio.<br />Attention! Use Isotope slider only with small categories (up to 30-40 posts in portfolio category and nested)', 'wpspace'),
			"id" => $shortname."_"."portfolio_use_isotope",
			"override" => "category",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Show title & breadcrumbs area', 'wpspace'),
			"desc" => __('Show area with blog title and breadcrumbs line', 'wpspace'),
			"id" => $shortname."_"."blog_breadcrumbs",
			"override" => "category",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);
			
$theme_options[] = array( "name" => __('Show main sidebar',  'wpspace'),
			"desc" => __('Select main sidebar position on blog page',  'wpspace'),
			"id" => $shortname . '_' . 'blog_sidebar_position',
			"override" => "category",
			"std" => "right",
			"type" => "select",
			"options" => $positions);

$theme_options[] = array( "name" => __('Select main sidebar',  'wpspace'),
			"desc" => __('Select main sidebar for blog page',  'wpspace'),
			"id" => $shortname . "_" . "blog_sidebar_main",
			"override" => "category",
			"std" => "sidebar-main",
			"type" => "select",
			"options" => $sidebars);

$theme_options[] = array( "name" => __('Show advertisement sidebar', 'wpspace'),
			"desc" => __('Show advertisement sidebar before footer', 'wpspace'),
			"id" => $shortname."_"."blog_sidebar_advert_show",
			"override" => "category",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Select advertisement sidebar',  'wpspace'),
			"desc" => __('Select advertisement sidebar for blog page',  'wpspace'),
			"id" => $shortname . "_" . "blog_sidebar_advert",
			"override" => "category",
			"std" => "sidebar-advert-1",
			"type" => "select",
			"options" => $sidebars);

$theme_options[] = array( "name" => __('Show footer sidebar', 'wpspace'),
			"desc" => __('Show footer sidebar', 'wpspace'),
			"id" => $shortname."_"."blog_sidebar_footer_show",
			"override" => "category",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Select footer sidebar',  'wpspace'),
			"desc" => __('Select footer sidebar for blog page',  'wpspace'),
			"id" => $shortname . "_" . "blog_sidebar_footer",
			"override" => "category",
			"std" => "sidebar-footer",
			"type" => "select",
			"options" => $sidebars);



$theme_options[] = array( "name" => __('Single page parameters', 'wpspace'),
			"closed" => true,
			"type" => "group");


$theme_options[] = array( "name" => __('Single (detail) pages parameters', 'wpspace'),
			"std" => __('Select desired parameters for single (detail) pages (you can override it in each category and single post (page))', 'wpspace'),
			"override" => "category,post,page",
			"type" => "info");

$theme_options[] = array( "name" => __('Show featured image before post',  'wpspace'),
			"desc" => __("Show featured image (if selected) before post content on single pages", 'wpspace'),
			"id" => $shortname . '_' . "single_featured_image",
			"override" => "category,post,page",
			"std" => "no",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Show breadcrumbs area', 'wpspace'),
			"desc" => __('Show area with blog title and breadcrumbs line', 'wpspace'),
			"id" => $shortname."_"."single_breadcrumbs",
			"override" => "category,post,page",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Show post title area', 'wpspace'),
			"desc" => __('Show area with post title and post info on single pages', 'wpspace'),
			"id" => $shortname."_"."single_title",
			"override" => "category,post,page",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Show text before "Read more" tag', 'wpspace'),
			"desc" => __('Show text before "Read more" tag on single pages', 'wpspace'),
			"id" => $shortname."_"."single_text_before_readmore",
			"override" => "category,post,page",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);
			
$theme_options[] = array( "name" => __('Show main sidebar',  'wpspace'),
			"desc" => __('Select main sidebar position on single pages',  'wpspace'),
			"id" => $shortname . '_' . 'single_sidebar_position',
			"override" => "category,post,page",
			"std" => "right",
			"type" => "select",
			"options" => $positions);

$theme_options[] = array( "name" => __('Select main sidebar',  'wpspace'),
			"desc" => __('Select main sidebar for single pages',  'wpspace'),
			"id" => $shortname . "_" . "single_sidebar_main",
			"override" => "category,post,page",
			"std" => "sidebar-main",
			"type" => "select",
			"options" => $sidebars);

$theme_options[] = array( "name" => __('Show advertisement sidebar', 'wpspace'),
			"desc" => __('Show advertisement sidebar before footer', 'wpspace'),
			"id" => $shortname."_"."single_sidebar_advert_show",
			"override" => "category,post,page",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Select advertisement sidebar',  'wpspace'),
			"desc" => __('Select advertisement sidebar for single page.',  'wpspace'),
			"id" => $shortname . "_" . "single_sidebar_advert",
			"override" => "category,post,page",
			"std" => "sidebar-advert-1",
			"type" => "select",
			"options" => $sidebars);

$theme_options[] = array( "name" => __('Show footer sidebar', 'wpspace'),
			"desc" => __('Show footer sidebar', 'wpspace'),
			"id" => $shortname."_"."single_sidebar_footer_show",
			"override" => "category,post,page",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Select footer sidebar',  'wpspace'),
			"desc" => __('Select footer sidebar for single pages.',  'wpspace'),
			"id" => $shortname . "_" . "single_sidebar_footer",
			"override" => "category,post,page",
			"std" => "sidebar-footer",
			"type" => "select",
			"options" => $sidebars);
			
$theme_options[] = array( "name" => __('Show post author',  'wpspace'),
			"desc" => __("Show post author information block in single post page", 'wpspace'),
			"id" => $shortname . '_' . "single_show_post_author",
			"override" => "category,post,page",
			"std" => "yes",
			"type" => "radio",
			"style" => "horizontal",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Show post social share',  'wpspace'),
			"desc" => __("Show social share block in single post page", 'wpspace'),
			"id" => $shortname . '_' . "single_show_post_share",
			"override" => "category,post,page",
			"std" => "yes",
			"type" => "radio",
			"style" => "horizontal",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Show post tags',  'wpspace'),
			"desc" => __("Show tags block in single post page", 'wpspace'),
			"id" => $shortname . '_' . "single_show_post_tags",
			"override" => "category,post,page",
			"std" => "yes",
			"type" => "radio",
			"style" => "horizontal",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Show related posts',  'wpspace'),
			"desc" => __("Show related posts block in single post page", 'wpspace'),
			"id" => $shortname . '_' . "single_show_post_related",
			"override" => "category,post,page",
			"std" => "yes",
			"type" => "radio",
			"style" => "horizontal",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Show comments',  'wpspace'),
			"desc" => __("Show comments block in single post page", 'wpspace'),
			"id" => $shortname . '_' . "single_show_post_comments",
			"override" => "category,post,page",
			"std" => "yes",
			"type" => "radio",
			"style" => "horizontal",
			"options" => $yes_no);


/*
###############################
#### Social                #### 
###############################
*/
$theme_options[] = array( "name" => __('Social', 'wpspace'),
			"type" => "heading");

$theme_options[] = array( "name" => __('Social icons', 'wpspace'),
			"std" => __('URLs to you profile in some social networks. Check desired item to show it in header of site (up to 6 icons).', 'wpspace'),
			"type" => "info");


$theme_options[] = array( "name" => __('Facebook',  'wpspace'),
			"desc" => __("Link to your Facebook profile", 'wpspace'),
			"id" => $shortname . '_' . "social_links_facebook",
			"std" => "",
			"enable" => "true",
			"type" => "text");

$theme_options[] = array( "name" => __('Twitter',  'wpspace'),
			"desc" => __("Link to your Twitter profile", 'wpspace'),
			"id" => $shortname . '_' . "social_links_twitter",
			"std" => "",
			"enable" => true,
			"type" => "text");

$theme_options[] = array( "name" => __('Google Plus',  'wpspace'),
			"desc" => __("Link to your gplus profile", 'wpspace'),
			"id" => $shortname . '_' . "social_links_gplus",
			"std" => "",
			"enable" => true,
			"type" => "text");

$theme_options[] = array( "name" => __('LinkedIn',  'wpspace'),
			"desc" => __("Link to your Pinterest profile", 'wpspace'),
			"id" => $shortname . '_' . "social_links_linkedin",
			"std" => "",
			"enable" => true,
			"type" => "text");

$theme_options[] = array( "name" => __('Dribbble',  'wpspace'),
			"desc" => __("Link to your Dribbble profile", 'wpspace'),
			"id" => $shortname . '_' . "social_links_dribbble",
			"std" => "",
			"enable" => true,
			"type" => "text");

$theme_options[] = array( "name" => __('Vimeo',  'wpspace'),
			"desc" => __("Link to your Vimeo profile", 'wpspace'),
			"id" => $shortname . '_' . "social_links_vimeo",
			"std" => "",
			"enable" => true,
			"type" => "text");

$theme_options[] = array( "name" => __('Github',  'wpspace'),
			"desc" => __("Link to your Github profile", 'wpspace'),
			"id" => $shortname . '_' . "social_links_github",
			"std" => "",
			"enable" => false,
			"type" => "text");

$theme_options[] = array( "name" => __('Flickr',  'wpspace'),
			"desc" => __("Link to your Flickr profile", 'wpspace'),
			"id" => $shortname . '_' . "social_links_flickr",
			"std" => "",
			"enable" => false,
			"type" => "text");

$theme_options[] = array( "name" => __('Tumblr',  'wpspace'),
			"desc" => __("Link to your Tumblr profile", 'wpspace'),
			"id" => $shortname . '_' . "social_links_tumblr",
			"std" => "",
			"enable" => false,
			"type" => "text");

$theme_options[] = array( "name" => __('Instagram',  'wpspace'),
			"desc" => __("Link to your Instagram profile", 'wpspace'),
			"id" => $shortname . '_' . "social_links_instagram",
			"std" => "",
			"enable" => false,
			"type" => "text");

$theme_options[] = array( "name" => __('Pinterest',  'wpspace'),
			"desc" => __("Link to your Pinterest profile", 'wpspace'),
			"id" => $shortname . '_' . "social_links_pinterest",
			"std" => "",
			"enable" => false,
			"type" => "text");

$theme_options[] = array( "name" => __('SoundCloud',  'wpspace'),
			"desc" => __("Link to your SoundCloud profile", 'wpspace'),
			"id" => $shortname . '_' . "social_links_soundcloud",
			"std" => "",
			"enable" => false,
			"type" => "text");


/*
###############################
#### Contacts              #### 
###############################
*/
$theme_options[] = array( "name" => __('Contacts', 'wpspace'),
			"type" => "heading");

$theme_options[] = array( "name" => __('Show Google map in header on Contact page',  'wpspace'),
			"desc" => __("Do you want to show Google map with your location in header area on Contact Us page", 'wpspace'),
			"id" => $shortname . '_' . "contacts_map",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$theme_options[] = array( "name" => __('Latitude,Longtitude (if known) for Google map',  'wpspace'),
			"desc" => __("Enter your geocoordinates here (if known)", 'wpspace'),
			"id" => $shortname . '_' . "contacts_latlng",
			"std" => "",
			"type" => "text");

$theme_options[] = array( "name" => __('Google map initial zoom',  'wpspace'),
			"desc" => __("Enter desired initial zoom for Google map", 'wpspace'),
			"id" => $shortname . '_' . "contacts_zoom",
			"std" => 16,
			"from" => 1,
			"to" => 20,
			"type" => "range");

$theme_options[] = array( "name" => __('Address',  'wpspace'),
			"desc" => __("Enter your address here", 'wpspace'),
			"id" => $shortname . '_' . "contacts_address",
			"std" => "",
			"type" => "text");

$theme_options[] = array( "name" => __('Phone',  'wpspace'),
			"desc" => __("Enter your phone here", 'wpspace'),
			"id" => $shortname . '_' . "contacts_phone",
			"std" => "",
			"type" => "text");

$theme_options[] = array( "name" => __('Fax',  'wpspace'),
			"desc" => __("Enter your fax here", 'wpspace'),
			"id" => $shortname . '_' . "contacts_fax",
			"std" => "",
			"type" => "text");

$theme_options[] = array( "name" => __('Email',  'wpspace'),
			"desc" => __("Enter your email here", 'wpspace'),
			"id" => $shortname . '_' . "contacts_email",
			"std" => "",
			"type" => "text");

$theme_options[] = array( "name" => __('Site',  'wpspace'),
			"desc" => __("Enter your site url here", 'wpspace'),
			"id" => $shortname . '_' . "contacts_site",
			"std" => "",
			"type" => "text");


// Load current values for all theme options
load_all_theme_options();



/*-----------------------------------------------------------------------------------*/
/* Get all options array
/*-----------------------------------------------------------------------------------*/
function load_all_theme_options() {
	global $theme_options;
	foreach ($theme_options as $k => $item) {
		if (isset($item['id'])) {
			if (($val = get_option($item['id'], false)) !== false)
				$theme_options[$k]['val'] = $val;
			else
				$theme_options[$k]['val'] = $theme_options[$k]['std'] . (isset($theme_options[$k]['enable']) ? '|'.($theme_options[$k]['enable'] ? 1 : 0 ) : '');
		}
	}
}


/* ==========================================================================================
   ==  Get theme option. If not exists - try get site option. If not exist - return default
   ========================================================================================== */
function get_theme_option($option_name, $default = false) {
	global $shortname, $theme_options;
	$fullname = my_substr($option_name, 0, my_strlen($shortname.'_')) == $shortname.'_' ? $option_name : $shortname.'_'.$option_name;
	$val = false;
	if (isset($theme_options)) {
		foreach($theme_options as $option) {
			if (isset($option['id']) && $option['id'] == $fullname) {
				$val = $option['val'];
				break;
			}
		}
	}
	if ($val === false) {
		if (($val = get_option($fullname, false)) !== false) {
			return $val;
		} else if (($val = get_option($option_name, false)) !== false) {
			return $val;
		} else {
			return $default;
		}
	} else {
		return $val;
	}
}


/* ==========================================================================================
   ==  Update theme option
   ========================================================================================== */
function update_theme_option($option_name, $value) {
	global $shortname, $theme_options;
	$fullname = my_substr($option_name, 0, my_strlen($shortname.'_')) == $shortname.'_' ? $option_name : $shortname.'_'.$option_name;
	foreach($theme_options as $k=>$option) {
		if (isset($option['id']) && $option['id'] == $fullname) {
			$theme_options[$k]['val'] = $value;
			update_option($fullname, $value);
			break;
		}
	}
}

function get_option_name($fullname) {
	global $shortname;
	return my_substr($fullname, my_strlen($shortname)+1);
}
?>