<?php
/**
 * The template for displaying the footer.
 *
 * @package norma
 */
?>
    </div><!-- #main -->
	
	<footer id="footer" class="site_footer" role="contentinfo">
		<?php if (get_custom_option(get_custom_option('prefix').'sidebar_advert_show') == 'yes'  ) { ?>
        <div id="advert" class="site_advert">
            <div id="advert_sidebar" class="widget_area sidebar_advert" role="complementary">
                <div id="advert_sidebar_inner">
                    <?php do_action( 'before_sidebar' ); ?>
                    <?php if ( ! dynamic_sidebar( get_custom_option(get_custom_option('prefix').'sidebar_advert') ) ) { ?>
                        <?php // Put here html if user no set widgets in sidebar ?>
                    <?php } // end sidebar widget area ?>
                </div>
            </div>
        </div>
        <?php } ?>

		<?php if (get_custom_option(get_custom_option('prefix').'sidebar_footer_show') == 'yes'  ) { ?>
		<div id="footer_sidebar" class="widget_area sidebar_footer" role="complementary">
			<div id="footer_sidebar_inner">
				<?php do_action( 'before_sidebar' ); ?>
				<?php if ( ! dynamic_sidebar( get_custom_option(get_custom_option('prefix').'sidebar_footer') ) ) { ?>
					<?php // Put here html if user no set widgets in sidebar ?>
				<?php } // end sidebar widget area ?>
			</div>
		</div>
        <?php } ?>

		<div id="footer_copyright">
			<div id="footer_copyright_inner">
				<?php
					echo get_theme_option('footer_copyright')
				?>
			</div>
		</div>
	</footer>

</div><!-- #page -->

<a href="#" id="toTop"></a>

<div id="popup_login" class="popup_form">
	<div class="popup_title">
    	<span class="popup_arrow"></span>
        <a href="#" class="popup_close">x</a>
	</div>
    <div class="popup_body">
        <form action="<?php echo wp_login_url(); ?>" method="post" name="login_form">
			<input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>"/>
			<div class="popup_field"><input type="text" name="log" id="log" placeholder="<?php _e('Login*', 'wpspace'); ?>" /></div>
			<div class="popup_field"><input type="password" name="pwd" id="pwd" placeholder="<?php _e('Password*', 'wpspace'); ?>" /></div>
			<div class="popup_field popup_button"><a href="#"><?php _e('Login', 'wpspace'); ?></a></div>
			<!--
			<div class="popup_field">
            	<input name="rememberme" id="rememberme" type="checkbox" value="forever">
                <label for="rememberme"><?php _e('Remember me', 'wpspace'); ?></label>
            </div>
            -->
			<div class="popup_field forgot_password">
				<?php _e('Forgot password?', 'wpspace'); ?>
            	<br /><a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>"><?php _e('Click here &raquo;', 'wpspace'); ?></a>
            </div>
            <div class="result sc_infobox"></div>
		</form>
    </div>
</div>

<div id="popup_register" class="popup_form">
	<div class="popup_title">
    	<span class="popup_arrow"></span>
        <a href="#" class="popup_close">x</a>
    </div>
    <div class="popup_body">
        <form action="#" method="post" name="register_form">
			<input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>"/>
			<div class="popup_field"><input type="text" name="registration_username" id="registration_username" placeholder="<?php _e('Your name*', 'wpspace'); ?>" /></div>
			<div class="popup_field"><input type="text" name="registration_email" id="registration_email" placeholder="<?php _e('Your email*', 'wpspace'); ?>" /></div>
			<div class="popup_field"><input type="password" name="registration_pwd" id="registration_pwd" placeholder="<?php _e('Your Password*', 'wpspace'); ?>" /></div>
			<div class="popup_field"><input type="password" name="registration_pwd2" id="registration_pwd2" placeholder="<?php _e('Confirm Password*', 'wpspace'); ?>" /></div>
			<div class="popup_field popup_button"><a href="#"><?php _e('Register', 'wpspace'); ?></a></div>
            <div class="result sc_infobox"></div>
		</form>
    </div>
</div>

<?php
if (get_theme_option('theme_customizer') == 'yes') {
	$theme_color = get_custom_option('theme_color');
	$body_style = get_custom_option('body_style');
	$bg_color = get_custom_option('bg_color');
	$bg_pattern = get_custom_option('bg_pattern');
	$bg_image = get_custom_option('bg_image');
?>
	<div id="custom_options">
		<div class="co_header">
			<a href="#" id="co_toggle" class="icon-cog"></a>
            <div class="co_title_wrapper"><h4 class="co_title"><?php _e('Choose Your Style', 'wpspace'); ?></h4></div>
		</div>
		<div class="co_options">
			<form name="co_form">
				<input type="hidden" id="co_site_url" name="co_site_url" value="<?php echo 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>" />
				<div class="co_form_row first">
					<input type="hidden" name="co_theme_color" value="<?php echo $theme_color; ?>" />
					<span class="co_label"><?php _e('Basic color:', 'wpspace'); ?></span>
                    <div id="co_theme_color" class="colorSelector"><div></div></div>
                </div>
                <div class="co_form_row">
					<input type="hidden" name="co_body_style" value="<?php echo $body_style; ?>" />
					<span class="co_label"><?php _e('Background:', 'wpspace'); ?></span>
                    <div class="co_switch_box">
                        <a href="#" class="stretched"><?php _e('Stretched', 'wpspace'); ?></a>
                        <div class="switcher"><a href="#"></a></div>
                        <a href="#" class="boxed"><?php _e('Boxed', 'wpspace'); ?></a>
                    </div>
                    <?php if ($body_style == 'boxed') { ?>
                    <script type="text/javascript">
						jQuery(document).ready(function() {
							var box = jQuery('#custom_options .switcher');
							var switcher = box.find('a').eq(0);
							var right = box.width() - switcher.width() + 2;
							switcher.css({left: right});
						});
                    </script>
                    <?php } ?>
                </div>
				<?php if (false) { ?>
                <div class="co_form_row">
					<input type="hidden" name="co_bg_color" value="<?php echo $bg_color; ?>" />
					<span class="co_label"><?php _e('Background color:', 'wpspace'); ?></span>
                    <div id="co_bg_color" class="colorSelector"><div></div></div>
                </div>
                <?php } ?>
				<div class="co_form_row">
					<input type="hidden" name="co_bg_pattern" value="<?php echo $bg_pattern; ?>" />
					<span class="co_label"><?php _e('Background pattern:', 'wpspace'); ?></span>
                    <div id="co_bg_pattern_list">
                    	<a href="#" id="pattern_1" class="co_pattern_wrapper<?php echo $bg_pattern==1 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/pattern_1.png" /></a>
                    	<a href="#" id="pattern_2" class="co_pattern_wrapper<?php echo $bg_pattern==2 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/pattern_2.png" /></a>
                    	<a href="#" id="pattern_3" class="co_pattern_wrapper<?php echo $bg_pattern==3 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/pattern_3.png" /></a>
                    	<a href="#" id="pattern_4" class="co_pattern_wrapper<?php echo $bg_pattern==4 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/pattern_4.png" /></a>
                    	<a href="#" id="pattern_5" class="co_pattern_wrapper<?php echo $bg_pattern==5 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/pattern_5.png" /></a>
					</div>
                </div>
				<div class="co_form_row">
					<input type="hidden" name="co_bg_image" value="<?php echo $bg_image; ?>" />
					<span class="co_label"><?php _e('Background image:', 'wpspace'); ?></span>
                    <div id="co_bg_images_list">
                    	<a href="#" id="image_1" class="co_image_wrapper<?php echo $bg_image==1 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/image_1.jpg" /></a>
                    	<a href="#" id="image_2" class="co_image_wrapper<?php echo $bg_image==2 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/image_2.jpg" /></a>
                    	<a href="#" id="image_3" class="co_image_wrapper<?php echo $bg_image==3 ? ' current' : '' ; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/image_3.jpg" /></a>
					</div>
                </div>
	        </form>
			<script type="text/javascript" language="javascript">
				jQuery(document).ready(function(){
					// Theme & Background color
					jQuery('#co_theme_color div').css('backgroundColor', '<?php echo $theme_color; ?>');
					//jQuery('#co_bg_color div').css('backgroundColor', '<?php echo $bg_color; ?>');    
                });
            </script>
        </div>
	</div>
<?php
}

?>

<script type="text/javascript">
jQuery(document).ready(function() {
	<?php
	// Reject old browsers
	global $jreject;
	if ($jreject) {
	?>
		jQuery.reject({
			reject : {
				all: false, // Nothing blocked
				msie5: true, msie6: true, msie7: true, msie8: true // Covers MSIE 5-8
				/*
				 * Possibilities are endless...
				 *
				 * // MSIE Flags (Global, 5-8)
				 * msie, msie5, msie6, msie7, msie8,
				 * // Firefox Flags (Global, 1-3)
				 * firefox, firefox1, firefox2, firefox3,
				 * // Konqueror Flags (Global, 1-3)
				 * konqueror, konqueror1, konqueror2, konqueror3,
				 * // Chrome Flags (Global, 1-4)
				 * chrome, chrome1, chrome2, chrome3, chrome4,
				 * // Safari Flags (Global, 1-4)
				 * safari, safari2, safari3, safari4,
				 * // Opera Flags (Global, 7-10)
				 * opera, opera7, opera8, opera9, opera10,
				 * // Rendering Engines (Gecko, Webkit, Trident, KHTML, Presto)
				 * gecko, webkit, trident, khtml, presto,
				 * // Operating Systems (Win, Mac, Linux, Solaris, iPhone)
				 * win, mac, linux, solaris, iphone,
				 * unknown // Unknown covers everything else
				 */
			},
			imagePath: "<?php echo get_template_directory_uri(); ?>/js/jreject/images/",
			header: "<?php _e('Your browser is out of date', 'wpspace'); ?>", // Header Text
			paragraph1: "<?php _e('You are currently using an unsupported browser', 'wpspace'); ?>", // Paragraph 1
			paragraph2: "<?php _e('Please install one of the many optional browsers below to proceed', 'wpspace'); ?>",
			closeMessage: "<?php _e('Close this window at your own demise!', 'wpspace'); ?>" // Message below close window link
		});
	<?php 
	} 
	
	if (get_theme_option('menu_position')=='fixed') {
		// Menu fixed position
	?>
		var menu_offset = jQuery('#header_middle').offset().top;
		jQuery(window).scroll(function() {
			var s = jQuery(this).scrollTop();
			if (s >= menu_offset) {
				jQuery('body').addClass('menu_fixed');
			} else {
				jQuery('body').removeClass('menu_fixed');
			}
		});
	<?php } ?>
});


// Javascript String constants for translation
GLOBAL_ERROR_TEXT	= "<?php _e('Global error text', 'wspace'); ?>";
NAME_EMPTY 			= "<?php _e('The name can\'t be empty', 'wspace'); ?>";
NAME_LONG 			= "<?php _e('Too long name', 'wspace'); ?>";
EMAIL_EMPTY 		= "<?php _e('Too short (or empty) email address', 'wspace'); ?>";
EMAIL_LONG 			= "<?php _e('Too long email address', 'wspace'); ?>";
EMAIL_NOT_VALID 	= "<?php _e('Invalid email address', 'wspace'); ?>";
MESSAGE_EMPTY 		= "<?php _e('The message text can\'t be empty', 'wspace'); ?>";
MESSAGE_LONG 		= "<?php _e('Too long message text', 'wspace'); ?>";
SEND_COMPLETE 		= "<?php _e("Send message complete!", 'wspace'); ?>";
SEND_ERROR 			= "<?php _e("Transmit failed!", 'wspace'); ?>";
GEOCODE_ERROR 		= "<?php _e("Geocode was not successful for the following reason:", 'wspace'); ?>";
LOGIN_EMPTY			= "<?php _e("The Login field can't be empty", 'wpspace'); ?>";
LOGIN_LONG			= "<?php _e('Too long login field', 'wpspace'); ?>";
PASSWORD_EMPTY		= "<?php _e("The password can't be empty and shorter then 5 characters", 'wpspace'); ?>";
PASSWORD_LONG		= "<?php _e('Too long password', 'wpspace'); ?>";
PASSWORD_NOT_EQUAL	= "<?php _e('The passwords in both fields are not equal', 'wpspace'); ?>";
REGISTRATION_SUCCESS= "<?php _e('Registration success! Please log in!', 'wpspace'); ?>";
REGISTRATION_FAILED	= "<?php _e('Registration failed!', 'wpspace'); ?>";

// AJAX parameters
<?php global $ajax_url, $ajax_nonce; ?>
ajax_url = "<?php echo $ajax_url; ?>";
ajax_nonce = "<?php echo $ajax_nonce; ?>";
</script>


<?php wp_footer(); ?>

</body>
</html>