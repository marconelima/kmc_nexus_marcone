<?php
/**
 * Norma theme functions and definitions
 *
 * @package norma
 */

/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 */
load_theme_textdomain( 'wpspace', get_template_directory() . '/languages' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 1170; /* pixels */


add_action( 'after_setup_theme', 'theme_setup' );
function theme_setup() {
	/**
	 * WP core supports
	 */
	// Add default posts and comments RSS feed links to head 
	add_theme_support( 'automatic-feed-links' );
	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );
	// Custom header setup
	add_theme_support( 'custom-header', array('header-text'=>false));
	// Custom backgrounds setup
	add_theme_support( 'custom-background');
	// Supported posts formats
	add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote') ); 
	// Add user menu
	add_theme_support('nav-menus');
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
				'mainmenu' => 'Main Menu'
			)
		);
	}
	// Editor custom stylesheet - for user
	add_editor_style('css/editor-style.css');	
}


// TinyMCE styles selector 
add_filter('tiny_mce_before_init', 'theme_mce_add_styles');
function theme_mce_add_styles($init) {
	$init['theme_advanced_buttons2_add'] = 'styleselect';
	$init['theme_advanced_styles'] = 
		  'Titles (underline)=sc_title'
	;
	return $init;
}
/*
// TinyMCE add buttons
add_filter( 'mce_buttons', 'theme_mce_buttons' );
function theme_mce_buttons($arr) {
    return array('bold', 'italic', '|', 'bullist', 'numlist', '|', 'formatselect', 'styleselect', '|', 'link', 'unlink' );
}
*/

/**
 * Register widgetized area and update sidebar with default widgets
 */
add_action( 'widgets_init', 'theme_widgets_init' );
function theme_widgets_init() {
	if ( function_exists('register_sidebar') ) {
		register_sidebar( array(
			'name'          => __( 'Main Sidebar', 'wpspace' ),
			'id'            => 'sidebar-main',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget_title">',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Footer Sidebar', 'wpspace' ),
			'id'            => 'sidebar-footer',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget_title">',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Advertisement Sidebar', 'wpspace' ),
			'id'            => 'sidebar-advert-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget_title">',
			'after_title'   => '</h3>',
		) );
		// Custom sidebars
		$sidebars = explode(',', get_theme_option('custom_sidebars'));
		for ($i=0; $i<count($sidebars); $i++) {
			if (trim(chop($sidebars[$i]))=='') continue;
			$sb = explode('|', $sidebars[$i]);
			if (count($sb)==1) $sb[1] = $i+1;
			register_sidebar( array(
				'name'          => $sb[0],
				'id'            => 'custom-sidebar-'.$sb[1],
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget_title">',
				'after_title'   => '</h3>',
			) );		
		}
	}
}


/**
 * Enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'theme_scripts' );
function theme_scripts() {
	//Enqueue styles
	wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
	wp_enqueue_style( 'shortcodes',  get_template_directory_uri() . '/css/shortcodes.css' );
	wp_add_inline_style( 'shortcodes', getThemeCustomStyles() );
	if (get_theme_option('responsive_layouts') == 'yes') {
		wp_enqueue_style( 'responsive',  get_template_directory_uri() . '/css/responsive.css' );
	}
	
	wp_enqueue_script('jquery');

	wp_enqueue_script( 'jquery_tools', get_template_directory_uri().'/js/jquery.tools.min.js', array('jquery'), '1.2.6', true);
	wp_enqueue_script( 'jquery_cookie', get_template_directory_uri().'/js/jquery.cookie.js', array('jquery'), '1.0.0', true);

	wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery'), '1.0', true );

	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider.min.js', array('jquery'), '2.1', true );

	wp_enqueue_style(  'prettyphoto-style', get_template_directory_uri() . '/js/prettyphoto/css/prettyPhoto.css' );
	wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/js/prettyphoto/jquery.prettyPhoto.js', array('jquery'), '3.1.5', true );

	wp_enqueue_style(  'mediaplayer-style',  get_template_directory_uri() . '/js/mediaplayer/mediaelementplayer.css' );
	wp_enqueue_script( 'mediaplayer', get_template_directory_uri() . '/js/mediaplayer/mediaelement-and-player.min.js', false, '1.0.0', true );
	
	wp_enqueue_script( 'mobilemenu', get_template_directory_uri().'/js/jquery.mobilemenu.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'easing', get_template_directory_uri().'/js/jquery.easing.js', array('jquery'), '1.0.0', true );

	if (get_theme_option('theme_customizer') == 'yes') {
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_style( 'color-picker', get_template_directory_uri().'/js/colorpicker/colorpicker.css');
		wp_enqueue_script('color-picker', get_template_directory_uri().'/js/colorpicker/colorpicker.js', array('jquery'), '1.0', true);
	}

	wp_enqueue_script( '_utils', get_template_directory_uri() . '/js/_utils.js', array(), '1.0.0', true );
	wp_enqueue_script( '_front', get_template_directory_uri() . '/js/_front.js', array(), '1.0.0', true );	
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

require_once( get_template_directory() . '/includes/_debug.php' );

require_once( get_template_directory() . '/includes/_utils.php' );
require_once( get_template_directory() . '/includes/_wp_utils.php' );

require_once( get_template_directory() . '/admin/theme-settings.php' );

require_once( get_template_directory() . '/includes/theme-customizer.php' );

require_once( get_template_directory() . '/includes/aq_resizer.php' );

require_once( get_template_directory() . '/includes/type-post.php' );
require_once( get_template_directory() . '/includes/type-page.php' );

require_once( get_template_directory() . '/includes/shortcodes.php' );
require_once( get_template_directory() . '/includes/wp-pagenavi.php' );

require_once( get_template_directory() . '/widgets/widget-contact-form.php' );
require_once( get_template_directory() . '/widgets/widget-popular-posts.php' );
require_once( get_template_directory() . '/widgets/widget-recent-posts.php' );
require_once( get_template_directory() . '/widgets/widget-twitter.php' );
require_once( get_template_directory() . '/widgets/widget-flickr.php' );
require_once( get_template_directory() . '/widgets/widget-advert.php' );
require_once( get_template_directory() . '/widgets/widget-contacts.php' );
require_once( get_template_directory() . '/widgets/widget-socials.php' );
require_once( get_template_directory() . '/widgets/qrcode/widget-qrcode-vcard.php' );




// Admin side setup
if (is_admin()) {
	add_action('admin_head', 'admin_theme_setup');
	function admin_theme_setup(){
		wp_enqueue_script('jquery');
	    wp_enqueue_style(  'wp-color-picker' );
    	wp_enqueue_script( 'wp-color-picker' );
	    wp_enqueue_style(  'theme-admin-style',  get_template_directory_uri() . '/css/admin-style.css' );
	
		wp_enqueue_script( '_utils', get_template_directory_uri() . '/js/_utils.js', array(), '1.0.0', true );
		//wp_enqueue_script( '_admin', get_template_directory_uri() . '/js/_admin.js', array(), '1.0.0', true );	
	}

	require_once( get_template_directory() . '/admin/theme-options.php' );
}





/* ========================= AJAX queries section ============================== */

// Get attachment url
add_action('wp_ajax_get_attachment_url', 'get_attachment_url_callback');
add_action('wp_ajax_nopriv_get_attachment_url', 'get_attachment_url_callback');

function get_attachment_url_callback() {
	global $_REQUEST;
	
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ajax_nonce' ) )
		die();

	$response = array('error'=>'');
	
	$id = (int) $_REQUEST['attachment_id'];
	
	$response['data'] = wp_get_attachment_url($id);
	
	echo json_encode($response);
	die();
}


// Send contact form data
add_action('wp_ajax_send_contact_form', 'send_contact_form_callback');
add_action('wp_ajax_nopriv_send_contact_form', 'send_contact_form_callback');

function send_contact_form_callback() {
	global $_REQUEST;

	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ajax_nonce' ) )
		die();

	$response = array('error'=>'');

	$user_name = my_substr($_REQUEST['user_name'], 0, 20);
	$user_email = my_substr($_REQUEST['user_email'], 0, 60);
	$user_msg = getShortString($_REQUEST['user_msg'], 300);

	if (!($contact_email = get_theme_option('admin_email'))) 
		$response['error'] = __('Unknown admin email!', 'wpspace');
	else {
		$subj = sprintf(__('Site %s - Contact form message from %s', 'wpspace'), get_bloginfo('site_name'), $user_name);
		$msg = "
".__('Name:', 'wpspace')." $user_name
".__('E-mail:', 'wpspace')." $user_email

".__('Message:', 'wpspace')." $user_msg

............ " . get_bloginfo('site_name') . " (" . home_url() . ") ............";

		$head = "Content-Type: text/plain; charset=\"utf-8\"\n"
			. "X-Mailer: PHP/" . phpversion() . "\n"
			. "Reply-To: $user_email\n"
			. "To: $contact_email\n"
			. "From: $user_email\n"
			. "Subject: $subj\n";

		if (!mail($contact_email, $subj, $msg, $head)) {
			$response['error'] = __('Error send message!', 'wpspace');
		}
	
		echo json_encode($response);
		die();
	}
}


// Check categories for portfolio style
add_action('wp_ajax_check_portfolio_style', 'check_portfolio_style_callback');
add_action('wp_ajax_nopriv_check_portfolio_style', 'check_portfolio_style_callback');

function check_portfolio_style_callback() {
	global $_REQUEST;
	
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ajax_nonce' ) )
		die();

	$response = array('error'=>'', 'portfolio' => 0);
	
	$ids = explode(',', $_REQUEST['ids']);
	if (count($ids) > 0) {
		foreach ($ids as $id) {
			$id = (int) $id;
			$prop = getCategoryInheritedProperty($id, 'blog_style');
			if (in_array($prop, array('p1','p2','p3','p4'))) {
				$response['portfolio'] = 1;
				break;
			}
		}
	}
	
	echo json_encode($response);
	die();
}



// New user registration
add_action('wp_ajax_registration_user', 'registration_user_callback');
add_action('wp_ajax_nopriv_registration_user', 'registration_user_callback');

function registration_user_callback() {
	global $_REQUEST;

	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ajax_nonce' ) ) {
		die();
	}

	$user_name = my_substr($_REQUEST['user_name'], 0, 20);
	$user_email = my_substr($_REQUEST['user_email'], 0, 60);
	$user_pwd = my_substr($_REQUEST['user_pwd'], 0, 20);

	$response = array('error' => '');

	$id = wp_insert_user( array ('user_login' => $user_name, 'user_pass' => $user_pwd, 'user_email' => $user_email) );
	if ( is_wp_error($id) ) {
		$response['error'] = $id->get_error_message();
	}

	echo json_encode($response);
	die();
}




/* ========================= Custom lists (sidebars, styles, etc) ============================== */


// Return list of categories
function getCategoriesList($prepend_default=true) {
	$list = array();
	if ($prepend_default) $list['default'] = __("Inherit", 'wpspace');
	$args = array(
		'type'                     => 'post',
		'child_of'                 => 0,
		'parent'                   => '',
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => 0,
		'hierarchical'             => 1,
		'exclude'                  => '',
		'include'                  => '',
		'number'                   => '',
		'taxonomy'                 => 'category',
		'pad_counts'               => false );
	$categories = get_categories( $args );
	foreach ($categories as $cat) {
		$list[$cat->term_id] = $cat->name;
	}
	return $list;
}


// Return custom sidebars list, prepended default and main sidebars item (if need)
function getSidebarsList($prepend_default=true) {
	$list = array();
	if ($prepend_default) $list['default'] = __("Inherit", 'wpspace');
	$list['sidebar-main'] = __("Main sidebar", 'wpspace');
	$list['sidebar-advert-1'] = __("Advertisement sidebar", 'wpspace');
	$list['sidebar-footer'] = __("Footer sidebar", 'wpspace');
	$sidebars = explode(',', get_theme_option('custom_sidebars'));
	for ($i=0; $i<count($sidebars); $i++) {
		if (trim(chop($sidebars[$i]))=='') continue;
		$sb = explode('|', $sidebars[$i]);
		if (count($sb)==1) $sb[1] = $i+1;
		$list['custom-sidebar-'.$sb[1]] = $sb[0];
	}
	return $list;
}


// Return sliders list, prepended default and main sidebars item (if need)
function getSlidersList($prepend_default=true) {
	$list = array();
	if ($prepend_default) $list['default'] = __("Inherit", 'wpspace');
	$list["flex"] = __("Flexslider", 'wpspace');
	if (is_plugin_active('revslider/revslider.php'))
		$list["revo"] = __("Revolution slider", 'wpspace');
	return $list;
}
	

// Return sidebars positions
function getSidebarsPositions($prepend_default=true) {
	$list = array();
	if ($prepend_default) $list['default'] = __("Inherit", 'wpspace');
	$list['right'] = __('Right', 'wpspace');
	$list['left'] = __('Left', 'wpspace');
	$list['fullwidth'] = __('Hide (without sidebar)', 'wpspace');
	return $list;
}

// Return sidebar class
function getSidebarClass($position) {
	if ($position == 'fullwidth')
		$class = 'without_sidebar';
	else if ($position == 'left')
		$class = 'with_sidebar left_sidebar';
	else
		$class = 'with_sidebar right_sidebar';
	return $class;
}

// Return blog styles list, prepended default
function getBlogStylesList($prepend_default=true) {
	$list = array();
	if ($prepend_default) $list['default'] = __("Inherit", 'wpspace');
	$list['b1'] = __('Blog Style 1', 'wpspace');
	$list['b2'] = __('Blog Style 2', 'wpspace');
	$list['b3'] = __('Blog Style 3', 'wpspace');
	$list['p1'] = __('Portfolio Style 1', 'wpspace');
	$list['p2'] = __('Portfolio Style 2', 'wpspace');
	$list['p3'] = __('Portfolio Style 3', 'wpspace');
	$list['p4'] = __('Portfolio Style 4', 'wpspace');
	return $list;
}

// Return blog modes list, prepended default
function getBlogModesList($prepend_default=true) {
	$list = array();
	if ($prepend_default) $list['default'] = __("Inherit", 'wpspace');
	$list['short'] = __('Short Blog mode (only excerpt for each article)', 'wpspace');
	$list['full']  = __('Full Blog mode (fullpost content)', 'wpspace');
	return $list;
}

// Return list with 'Yes' and 'No' items
function getYesNoList($prepend_default=true) {
	$list = array();
	if ($prepend_default) $list['default'] = __("Inherit", 'wpspace');
	$list["yes"] = __("Yes", 'wpspace');
	$list["no"]  = __("No", 'wpspace');
	return $list;
}

// Return list with 'Show' and 'Hide' items
function getShowHideList($prepend_default=true) {
	$list = array();
	if ($prepend_default) $list['default'] = __("Inherit", 'wpspace');
	$list["show"] = __("Show", 'wpspace');
	$list["hide"] = __("Hide", 'wpspace');
	return $list;
}

// Return Google fonts list
function getFontsList($prepend_default=true) {
	$list = array();
	if ($prepend_default) $list['default'] = 'default';
	$list['Advent Pro'] = array('family'=>'sans-serif', 'link'=>'Advent+Pro:400,500,700');
	$list['Arimo'] = array('family'=>'sans-serif', 'link'=>'Arimo:400,400italic,700,700italic');
	$list['Asap'] = array('family'=>'sans-serif', 'link'=>'Asap:400,400italic,700,700italic');
	$list['Averia Sans Libre'] = array('family'=>'cursive', 'link'=>'Averia+Sans+Libre:400,400italic,700,700italic');
	$list['Averia Serif Libre'] = array('family'=>'cursive', 'link'=>'Averia+Serif+Libre:400,400italic,700,700italic');
	$list['Cabin'] = array('family'=>'sans-serif', 'link'=>'Cabin:400,500,400italic,500italic,700,700italic');
	$list['Cabin Condensed'] = array('family'=>'sans-serif', 'link'=>'Cabin+Condensed:400,500,700');
	$list['Caudex'] = array('family'=>'serif', 'link'=>'Caudex:400,700,400italic,700italic');
	$list['Comfortaa'] = array('family'=>'cursive', 'link'=>'Comfortaa:400,700');
	$list['Cousine'] = array('family'=>'sans-serif', 'link'=>'Cousine:400,400italic,700,700italic');
	$list['Crimson Text'] = array('family'=>'serif', 'link'=>'Crimson+Text:400,400italic,700italic,700');
	$list['Cuprum'] = array('family'=>'sans-serif', 'link'=>'Cuprum:400,400italic,700,700italic');
	$list['Dosis'] = array('family'=>'sans-serif', 'link'=>'Dosis:400,500,700');
	$list['Economica'] = array('family'=>'sans-serif', 'link'=>'Economica:400,700');
	$list['Exo'] = array('family'=>'sans-serif', 'link'=>'Exo:400,400italic,500,500italic,700,700italic');
	$list['Expletus Sans'] = array('family'=>'cursive', 'link'=>'Expletus+Sans:400,500,400italic,500italic,700,700italic');
	$list['Karla'] = array('family'=>'sans-serif', 'link'=>'Karla:400,400italic,700,700italic');
	$list['Lato'] = array('family'=>'sans-serif', 'link'=>'Lato:400,400italic,700,700italic');
	$list['Lekton'] = array('family'=>'sans-serif', 'link'=>'Lekton:400,700,400italic');
	$list['Lobster Two'] = array('family'=>'cursive', 'link'=>'Lobster+Two:400,700,400italic,700italic');
	$list['Maven Pro'] = array('family'=>'sans-serif', 'link'=>'Maven+Pro:400,500,700');
	$list['Merriweather'] = array('family'=>'serif', 'link'=>'Merriweather:400,400italic,700,700italic');
	$list['Neuton'] = array('family'=>'serif', 'link'=>'Neuton:400,400italic,700');
	$list['Noticia Text'] = array('family'=>'serif', 'link'=>'Noticia+Text:400,400italic,700,700italic');
	$list['Old Standard TT'] = array('family'=>'serif', 'link'=>'Old+Standard+TT:400,400italic,700');
	$list['Open Sans'] = array('family'=>'sans-serif', 'link'=>'Open+Sans:400,700,400italic,700italic');
	$list['Orbitron'] = array('family'=>'sans-serif', 'link'=>'Orbitron:400,500,700');
	$list['Oswald'] = array('family'=>'sans-serif', 'link'=>'Oswald:400,700');
	$list['Overlock'] = array('family'=>'cursive', 'link'=>'Overlock:400,700,400italic,700italic');
	$list['Oxygen'] = array('family'=>'sans-serif', 'link'=>'Oxygen:400,700');
	$list['PT Serif'] = array('family'=>'serif', 'link'=>'PT+Serif:400,400italic,700,700italic');
	$list['Puritan'] = array('family'=>'sans-serif', 'link'=>'Puritan:400,400italic,700,700italic');
	$list['Raleway'] = array('family'=>'sans-serif', 'link'=>'Raleway:400,500,700');
	$list['Roboto'] = array('family'=>'sans-serif', 'link'=>'Roboto:400,400italic,500,700,500italic,700italic');
	$list['Roboto Condensed'] = array('family'=>'sans-serif', 'link'=>'Roboto+Condensed:400,400italic,700,700italic');
	$list['Rosario'] = array('family'=>'sans-serif', 'link'=>'Rosario:400,400italic,700,700italic');
	$list['Share'] = array('family'=>'cursive', 'link'=>'Share:400,400italic,700,700italic');
	$list['Signika Negative'] = array('family'=>'sans-serif', 'link'=>'Signika+Negative:400,700');
	$list['Tinos'] = array('family'=>'serif', 'link'=>'Tinos:400,400italic,700,700italic');
	$list['Ubuntu'] = array('family'=>'sans-serif', 'link'=>'Ubuntu:400,400italic,500,500italic,700,700italic');
	$list['Vollkorn'] = array('family'=>'serif', 'link'=>'Vollkorn:400,400italic,700,700italic');
	return $list;
}

// Return iconed classes list
function getIconsList($prepend_default=true) {
	$list = array();
	if ($prepend_default) $list['default'] = 'default';
	return array_merge($list, parseIconsClasses(get_template_directory() . "/includes/fontello/css/fontello-codes.css"));
}

// Return post-format icon name (from Fontello library)
function getPostFormatIcon($format) {
	$icon = 'icon-';
	if ($format=='gallery')		$icon .= 'camera';
	else if ($format=='video')	$icon .= 'video';
	else if ($format=='audio')	$icon .= 'note-beamed';
	else if ($format=='image')	$icon .= 'newspaper';
	else if ($format=='quote')	$icon .= 'quote';
	else if ($format=='link')	$icon .= 'link';
	else if ($format=='status')	$icon .= 'tag';
	else if ($format=='aside')	$icon .= 'book-open';
	else if ($format=='chat')	$icon .= 'list';
	else						$icon .= 'pencil';
	return $icon;
}



/* ========================= Miscelaneous functions ============================== */

// Return property value from theme custom > category custom > post custom > request parameters
function get_custom_option($name, $defa=null) {
	global $post_options, $cat_options, $custom_options;
	if (isset($custom_options[$name])) {
		$rez = $custom_options[$name];
	} else {
		$rez = get_theme_option($name, $defa);
		if (!is_single() && isset($post_options[$name]) && (is_array($post_options[$name]) ? $post_options[$name][0] : $post_options[$name])!='default')
			$rez = is_array($post_options[$name]) ? $post_options[$name][0] : $post_options[$name];
		if (isset($cat_options[$name]) && $cat_options[$name]!='default')
			$rez = $cat_options[$name];
		if (is_single() && isset($post_options[$name]) && (is_array($post_options[$name]) ? $post_options[$name][0] : $post_options[$name])!='default')
			$rez = is_array($post_options[$name]) ? $post_options[$name][0] : $post_options[$name];
		$rez = getValueGPC($name, $rez);
		$custom_options[$name] = $rez;
	}
	return $rez;
}


function show_custom_field($field, $meta='') {
	$upload_url = admin_url('media-upload.php');
	$ajax_nonce = wp_create_nonce('ajax_nonce');
	$ajax_url = admin_url('admin-ajax.php');
	switch ($field['type']) {
		case 'info':
			if (!isset($field['desc']) && isset($field['std'])) $field['desc'] = $field['std'];
			break;
		case 'text':
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="'. $meta. '" size="30" style="width:30%" />';
			break;
		case 'textarea':
			echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">'. $meta . '</textarea>';
			break;
		case 'select':
			echo '<select name="', $field['id'], '" id="', $field['id'], '">' . getOptionsFromArray($field['options'], $meta) . '</select>';
			break;
		case 'radio':
			foreach ($field['options'] as $option) {
				echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
			}
			break;
		case 'checkbox':
			echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
			break;
		case 'file':
			echo '<input type="file" name="', $field['id'], '" id="', $field['id'], '"', $meta ? '' : '', ' />';
			break;
		case "icons":
			$i = 0;
			if (isset($field['css']) && $field['css']!='' && file_exists($field['css'])) {
				$field['options'] = parseIconsClasses($field['css']);
			}
			echo '<div class="icons_selector">';
			foreach ($field['options'] as $option) { 
				$i++;
				$checked = '';
				$selected = '';
				if ($option == $meta || ($i == 1  && $meta == '')) { $checked = ' checked'; $selected = 'radio-icon-selected'; }
				echo '<input type="radio" id="radio-icon-' . $field['id'] . $i . '" class="radio-icon-radio" value="'.$option.'" name="'. $field['id'].'" '.$checked.' />';
				echo '<span class="radio-icon-icon '. $option . ' ' . $selected .'" onClick="document.getElementById(\'radio-icon-'. $field['id'] . $i.'\').checked = true;"></span>';
			}
			echo '<div>';
			break; 
		case 'mediamanager':
			wp_enqueue_media( );
			?>
			<a id="<?php echo $field['id']; ?>" class="button mediamanager"
				data-choose="<?php isset($field['multiple']) && $field['multiple'] ? _e( 'Choose Images', 'wpspace') : _e( 'Choose Image', 'wpspace'); ?>"
				data-update="<?php isset($field['multiple']) && $field['multiple'] ? _e( 'Add to Gallery', 'wpspace') : _e( 'Choose Image', 'wpspace'); ?>"
            	data-multiple="<?php isset($field['multiple']) && $field['multiple'] ? 'true' : 'false'; ?>"
                data-linked-field="<?php echo $field['media_field_id']; ?>"
                onclick="showMediaManager(this); return false;"
                >
				<?php isset($field['multiple']) && $field['multiple'] ? _e( 'Choose Images', 'wpspace') : _e( 'Choose Image', 'wpspace'); ?>
            </a>
			<?php
			break;
	}
	if (isset($field['desc'])) echo '<p class="custom_descr">'.$field['desc'].'</p>';
}


/* ========================= Additional fields for categories ============================== */

// Get category custom fields
function category_custom_fields_get($tax = null) {  
	$t_id = is_object($tax) ? $tax->term_id : $tax; 				// Get the ID of the term you're editing  
	return $t_id ? get_option( "category_term_{$t_id}" ) : false;	// Do the check  
}

// Get category custom fields
function category_custom_fields_set($term_id, $term_meta) {  
	update_option( "category_term_{$term_id}", $term_meta );  
}


// Add the fields to the "category" taxonomy, using our callback function  
add_action( 'category_edit_form_fields', 'category_custom_fields_show', 10, 1 );  
add_action( 'category_add_form_fields', 'category_custom_fields_show', 10, 1 );  
function category_custom_fields_show($tax = null) {  
	global $theme_options;
	$term_meta = category_custom_fields_get($tax);
	wp_enqueue_script( '_admin', get_template_directory_uri() . '/js/_admin.js', array(), '1.0.0', true );	
?>  
	<table border="0" cellpadding="0" cellspacing="0" class="form-table">
    <tr class="form-field" valign="top">  
	    <th scope="row"><h3 class="custom_title"><?php _e('Custom settings for this category (and nested):', 'wpspace'); ?></h3></th>  
	    <td>
            <p class="custom_descr"><?php _e('Select parameters for showing posts from this category and all nested categories.', 'wpspace'); ?><br />
			<?php _e('Attention: In each nested categories you can override this settings.', 'wpspace'); ?></p>
         	<p><a href="#" class="custom_parameters_link"><?php _e('Show/Hide custom parameters', 'wpspace'); ?></a></p>
       </td>
	</tr>
<?php 
	foreach ($theme_options as $option) { 
		if (!isset($option['override']) || !in_array('category', explode(',', $option['override']))) continue;
		$id = isset($option['id']) ? get_option_name($option['id']) : '';
?>
	<tr class="form-field custom_parameters_section">  
	    <th scope="row" valign="top">
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
				<select size="1" name="term_meta[<?php echo $id; ?>]" id="<?php echo $id; ?>" style="width:150px;">
					<option value="default"><?php _e('Inherit', 'wpspace'); ?></option>
					<?php echo getOptionsFromArray($option['options'], isset($term_meta[$id]) ? $term_meta[$id] : 'default'); ?>
				</select>
				<p class="custom_descr"><?php echo $option['desc']; ?></p>
			<?php } else { ?>
				<input type="text" name="term_meta[<?php echo $id; ?>]" id="<?php echo $id; ?>" style="width:150px;" value="<?php echo isset($term_meta[$id]) ? ($term_meta[$id]=='default' ? '' : $term_meta[$id]) : ''; ?>" />
				<p class="custom_descr"><?php echo $option['desc']; ?></p>
			<?php } ?>
		</td>
	</tr>  
<?php  
	}
?>
    </table>
<?php
} 



  
// Save the changes made on the "category" taxonomy, using our callback function  
add_action( 'edited_category', 'category_custom_fields_save', 10, 1 );
add_action( 'created_category', 'category_custom_fields_save', 10, 1 );
function category_custom_fields_save( $term_id=0 ) {  
	if ( isset( $_POST['term_meta'] ) ) {  
		$term_meta = category_custom_fields_get($term_id);
		$cat_keys = array_keys( $_POST['term_meta'] );  
		foreach ( $cat_keys as $key ) {
			if ( isset( $_POST['term_meta'][$key] ) ){
				$term_meta[$key] = $_POST['term_meta'][$key]=='' ? 'default' : $_POST['term_meta'][$key];  
			}  
		}  
		//save the option array  
		category_custom_fields_set($term_id, $term_meta);
	}  
}
?>