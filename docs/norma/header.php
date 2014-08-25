<?php
/**
 * The Header for our theme.
 *
 * @package norma
 */
	
// AJAX Queries settings
global $ajax_nonce, $ajax_url;
$ajax_nonce = wp_create_nonce('ajax_nonce');
$ajax_url = admin_url('admin-ajax.php');

// Theme custom settings from current post and category
global $options_prefix, $cat_options, $post_options, $custom_options;
// Current post & category custom options
$post_options = $cat_options = array();
$prefix = 'blog_';
if (is_single() || is_page()) {
	// Current post custom options
	$post_options = get_post_custom(get_the_ID());
	if (is_single() || get_the_ID()!=getTemplatePageId('template-blog')) $prefix = 'single_';
	$cats = getCategoriesByPostId(get_the_ID());
	if ($cats) {
		foreach ($cats as $cat) {
			$new_options = getCategoryInheritedProperties($cat['term_id']);
			foreach ($new_options as $k=>$v) {
				if (!empty($v) && $v!='default' && (!isset($cat_options[$k]) || empty($cat_options[$k]) || $cat_options[$k]=='default'))
					$cat_options[$k] = $v;
			}
		}
	}
} else if (is_category()) {
	$cat = (int) get_query_var( 'cat' );
	if (empty($cat)) $cat = get_query_var( 'category_name' );
	$cat_options = getCategoryInheritedProperties($cat);
} else if (is_search() && ($page_id=getTemplatePageId('search'))>0) {
	$post_options = get_post_custom($page_id);
	$prefix = 'single_';
} else if (is_archive() && ($page_id=getTemplatePageId('archive'))>0) {
	$post_options = get_post_custom($page_id);
	$prefix = 'single_';
} else if (is_404() && ($page_id=getTemplatePageId('404'))>0) {
	$post_options = get_post_custom($page_id);
	$prefix = 'single_';
}
if (isset($post_options['post_custom_options'])) {
	$post_options = unserialize($post_options['post_custom_options'][0]);
}
$custom_options = array(
	'prefix' => $prefix,
	'body_style' => my_strtolower(getValueGPC('body_style', get_theme_option('body_style'))) == 'boxed' ? 'boxed' : 'wide',
	'blog_style' => my_strtolower(getValueGPC('blog_style', get_custom_option('blog_style'))),
	'theme_color' => getValueGPC('theme_color', get_theme_option('theme_color'))
);
// Reject old browsers support
global $jreject;
$jreject = false;
if (!isset($_COOKIE['jreject'])) {
	wp_enqueue_style(  'jquery_reject-style',  get_template_directory_uri() . '/js/jreject/css/jquery.reject.css' );
	wp_enqueue_script( 'jquery_reject', get_template_directory_uri() . '/js/jreject/jquery.reject.js', array('jquery'), '1.0.0', true );
	setcookie('jreject', 1, 0, '/');
	$jreject = true;
}
$font = get_custom_option('theme_font');
$fonts = getFontsList(false);
if (isset($fonts[$font])) {
	$font_link = $fonts[$font]['link'];
} else {
	$font_link = "Ubuntu:400,400italic,500,500italic,700,700italic";
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php if (($favicon = get_theme_option('favicon'))) { ?>
		<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $favicon; ?>" />
    <?php
	}
	?>
	<link href='http://fonts.googleapis.com/css?family=<?php echo $font_link; ?>&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php 
	$class = $style = '';
	if (get_custom_option('body_style')=='boxed') {
		if (($img = (int) getValueGPC('bg_image', 0)) > 0)
			$class = 'bg_image_'.$img;
		else if (($img = (int) getValueGPC('bg_pattern', 0)) > 0)
			$class = 'bg_pattern_'.$img;
		else if (($img = getValueGPC('bg_color', '')) != '')
			$style = 'background-color: '.$img.';';
		else {
			if (($img = get_custom_option('bg_custom_image')) != '')
				$style = 'background: url('.$img.') ' . str_replace('_', ' ', get_custom_option('bg_custom_image_position')) . ' no-repeat fixed;';
			else if (($img = get_custom_option('bg_custom_pattern')) != '')
				$style = 'background: url('.$img.') 0 0 repeat fixed;';
			else if (($img = get_custom_option('bg_image')) > 0)
				$class = 'bg_image_'.$img;
			else if (($img = get_custom_option('bg_pattern')) > 0)
				$class = 'bg_pattern_'.$img;
			if (($img = get_custom_option('bg_color')) != '')
				$style .= 'background-color: '.$img.';';
		}
	}
	body_class(get_custom_option('body_style').($class!='' ? ' '.$class : ''));
	if ($style!='') echo ' style="'.$style.'"';
	?>
>
	<!--[if lt IE 9]>
	<?php echo do_shortcode("[infobox style='error']<div style=\"text-align:center;\">".__("It looks like you're using an old version of Internet Explorer. For the best WordPress experience, please <a href=\"http://microsoft.com\" style=\"color:#191919\">update your browser</a> or learn how to <a href=\"http://browsehappy.com\" style=\"color:#191919\">browse happy</a>!", 'wpspace')."</div>[/infobox]"); ?>
	<![endif]-->
    <div id="page" class="hfeed site">
        <?php do_action( 'before' ); ?>
        <header id="header" class="site_header" role="banner">
			<div id="header_top">
				<div id="header_top_inner">
					<div class="call_us"<?php echo get_theme_option('show_login')=='yes' ? '' : ' style="border-right:none;"'; ?>>
						<span class="icon-phone"></span>
						<?php echo get_theme_option('header_call_us'); ?>
					</div>
					<?php if (get_theme_option('show_login')=='yes') { ?>
					<div class="login_or_register">
						<span class="icon-user"></span>
                   		<?php if( !is_user_logged_in() ) { ?>
							<a href="#" class="link_login"><?php _e('Login', 'wpspace'); ?></a> or <a href="#" class="link_register"><?php _e('Register', 'wpspace'); ?></a>
                   		<?php } else { ?>
							<a href="<?php echo wp_logout_url(home_url()); ?>" class="link_logout"><?php _e('Logout', 'wpspace'); ?></a>
                   		<?php } ?>
					</div>
					<?php } ?>
					<div class="header_icons">
                    	<form class="searchform" action="<?php echo home_url(); ?>" method="get"><input class="field field_search" type="search" placeholder="<?php _e('Search &hellip;', 'wpspace'); ?>" value="" name="s"></form>
						<a href="#" class="search_link"><span class="search_over"><span class="icon-search"></span></span></a>
						<?php
						global $theme_options, $shortname;
						for ($i=count($theme_options)-1; $i>=0; $i--) {
							if (!isset($theme_options[$i]['id']) || my_substr($theme_options[$i]['id'], my_strlen($shortname)+1, 12)!='social_links') continue;
							$soc = my_substr($theme_options[$i]['id'], my_strlen($shortname)+1+13);
							$tmp = explode('|', $theme_options[$i]['val']);
							if ($tmp[1]==1) {
							?>
								<a class="social <?php echo $soc; ?>" href="<?php echo $tmp[0]; ?>"><span class="icon-<?php echo $soc; ?>"></span></a>
							<?php 
							}
						}
						?>
					</div>
				</div>
       		</div>
			
			<?php 
				if (($header_custom_image = get_header_image()) != '') {
					$header_style = ' style = "background: url('.$header_custom_image.');"';
				} else {
					$header_style = '';
				}
			?>
						
			<div id="header_middle_wrapper">
                <div id="header_middle" <?php echo $header_style; ?>>
                    <div id="header_middle_inner">
                        <?php if (($logo = get_theme_option('logo'))!='') { ?>
                        	<div class="logo"><a href="<?php echo get_home_url(); ?>"><img src="<?php echo $logo; ?>" border="0" align="middle" /></a></div>
                        <?php } else { ?>
							<div class="logo_default"><a href="<?php echo get_home_url(); ?>">N<span class="logo_norma"><span class="logo_norma_top"></span><span class="logo_norma_bottom"></span></span>RMA</a></div>
                        <?php } ?>
                        <nav id="mainmenu_area" class="mainmenu_area" role="navigation">
                            <?php
                                wp_nav_menu(array(
                                    'menu'              => '',
                                    'container'         => '',
                                    'container_class'   => '',
                                    'container_id'      => '',
                                    'items_wrap'      	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                    'menu_class'        => '',
                                    'menu_id'           => 'mainmenu',
                                    'echo'              => true,
                                    'fallback_cb'       => '',
                                    'before'            => '',
                                    'after'             => '',
                                    'link_before'       => '',
                                    'link_after'        => '',
                                    'depth'             => 11,
                                    'theme_location'    => 'mainmenu'
                                ));
                            ?>			
                        </nav>
                    </div>
                </div>
			</div>
            <div id="header_middle_fixed"></div>
		</header>

        
		<div id="main" class="<?php echo getSidebarClass(get_custom_option(get_custom_option('prefix') . 'sidebar_position')); ?>">
			<?php if (get_custom_option(get_custom_option('prefix') . 'breadcrumbs')=='yes') { ?>
				<div id="breadcrumbs_area">
					<div id="breadcrumbs_inner">
						<h4 class="title"><?php echo getBlogTitle(); ?></h4>
						<?php if (!is_404()) showBreadcrumbs( array('home' => __('Home', 'wpspace'), 'truncate_title' => 50 ) ); ?>
					</div>
				</div>
			<?php } ?>

			<?php
			if (get_custom_option('slider_show')=='yes') { 
				$slider_display = get_custom_option('slider_display');
				$slider = get_custom_option('slider_engine');
			?>
                <div id="main_slider" class="main_slider_<?php echo $slider_display; ?>">
                    <div id="main_slider_inner">
                        <?php
							if ($slider == 'revo' && is_plugin_active('revslider/revslider.php')) {
								$slider_alias = get_custom_option('slider_alias');
								if (!empty($slider_alias)) putRevSlider($slider_alias);
							} else if ($slider == 'flex') {
								$slider_cat = get_custom_option("slider_category");
								$slider_count = $slider_ids = get_custom_option("slider_posts");
								if (my_strpos($slider_ids, ',')!==false)
									$slider_count = 0;
								else {
									$slider_ids = '';
									if (empty($slider_count)) $slider_count = 3;
								}
								if (!empty($slider_cat) || !empty($slider_ids)) {
									echo do_shortcode('[slider engine="flex"' 
										. ($slider_cat ? ' cat="'.$slider_cat.'"' : '') 
										. ($slider_ids ? ' ids="'.$slider_ids.'"' : '') 
										. ($slider_count ? ' count="'.$slider_count.'"' : '') 
										. ']');
								}
							}
                        ?>
                    </div>
                </div>
			<?php } ?>

			<?php 
			if ( is_page_template( 'contacts.php' ) && get_theme_option('contacts_map')=='yes' ) { 
				$address = get_theme_option('contacts_address');
				$latlng = get_theme_option('contacts_latlng');
				if (!empty($address) || !empty($latlng)) {
			?>
					<div id="main_map" class="main_map">
						<div id="main_map_inner">
							<?php
							echo do_shortcode("[googlemap ".(!empty($latlng) ? "latlng='$latlng'" : "address='$address'")." zoom='" .get_theme_option('contacts_zoom') ."' width='100%' height='500']");
							?>
						</div>
					</div>
			<?php
				}
			} 
			?>
