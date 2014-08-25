/* global jQuery:false */
var error_msg_box = null;

jQuery(document).ready(function() {
	"use strict";

	// Disable select text on dbl click
	/*
	jQuery('.registration-popup-link').mousedown(function(e){
		e.preventDefault();
		return false;
	})
	jQuery('.registration-popup-link').select(function(e){
		e.preventDefault();
		return false;
	})
	*/

	// Main menu substitute
	jQuery('#mainmenu').mobileMenu();

	// toTop link setup
	jQuery(window).scroll(function() {
		var s = jQuery(this).scrollTop();
		if (s >= 110) {
			jQuery('#toTop').show();
		} else {
			jQuery('#toTop').hide();	
		}
	});
	jQuery('#toTop').click(function(e) {
		jQuery('body,html').animate({scrollTop:0}, 800);
		e.preventDefault();
		return false;
	});

	// Search link
	var linkWidth = 0;
	jQuery('.search_link').click(function(e) {
		if (jQuery('.search_link').width() < 50) {
			linkWidth = jQuery('.search_link').width();
			//jQuery('.header_icons').width(400);
			//jQuery('.header_icons [class*="social"]').hide();
			jQuery('.search_link').animate({width:'250px'}, 200);
			jQuery('.search_over').animate({width:'250px'}, 200);
			jQuery('#header_top_inner .header_icons .searchform').show();
		} else if (jQuery('#header_top_inner .header_icons .field_search').val()!=='') {
			jQuery('#header_top_inner .header_icons .searchform').get(0).submit();
		} else {
			jQuery('#header_top_inner .header_icons .searchform').hide();
			jQuery('.search_link').animate({width:linkWidth+'px'}, 200);
			jQuery('.search_over').animate({width:linkWidth+'px'}, 200);
			//jQuery('.header_icons').animate({width:'280px'}, 200);
			//jQuery('.header_icons [class*="social"]').show();
		}
		e.preventDefault();
		return false;
	});
	// Search link
	jQuery('.search_form_link').click(function(e) {
		if (jQuery(this).parents('form').find('.field_search').val()!=='') {
			jQuery(this).parents('form').get(0).submit();
		}
		e.preventDefault();
		return false;
	});
	
	// Login & registration link
	jQuery('.link_login,.link_register,.popup_form .popup_title .popup_close').click(function(e) {
		var obj = jQuery(this);
		var popup = obj.hasClass('link_login') ? jQuery('#popup_login') : (obj.hasClass('link_register') ? jQuery('#popup_register') : jQuery(this).parents('.popup_form'));
		if (popup.length === 1) {
			if (popup.hasClass('visible')) {
				popup.removeClass('visible').slideUp();
			} else {
				jQuery('.popup_form').removeClass('visible').fadeOut();
				if (parseInt(popup.css('left'), 10) === 0) {
					var offset = jQuery(this).offset();
					popup.css({
						left: offset.left-10,
						top: offset.top+jQuery(this).height()+4
					});
				}
				popup.addClass('visible').slideDown();
			}
		}
		e.preventDefault();
		return false;
	});
	jQuery('.popup_form form').keypress(function(e){
		if (e.keyCode === 27) {
			jQuery(this).parents('.popup_form').find('.popup_title .popup_close').trigger('click');
			e.preventDefault();
			return false;
		} else if (e.keyCode === 13) {
			jQuery(this).parents('.popup_form').find('.popup_button a').trigger('click');
			e.preventDefault();
			return false;
		}
	});
	jQuery('#popup_login .popup_button a').click(function(e){
		jQuery('#popup_login form input').removeClass('error_fields_class');
		var error = formValidate(jQuery('#popup_login form'), {
			error_message_show: true,
			error_message_time: 4000,
			error_message_class: 'sc_infobox sc_infobox_style_error',
			error_fields_class: 'error_fields_class',
			exit_after_first_error: true,
			rules: [
				{
					field: "log",
					min_length: { value: 1, message: LOGIN_EMPTY},
					max_length: { value: 60, message: LOGIN_LONG}
				},
				{
					field: "pwd",
					min_length: { value: 4, message: PASSWORD_EMPTY},
					max_length: { value: 20, message: PASSWORD_LONG}
				}
			]
		});
		if (!error) {
			document.forms.login_form.submit();
		}
		e.preventDefault();
		return false;
	});
	jQuery('#popup_register .popup_button a').click(function(e){
		jQuery('#popup_register form input').removeClass('error_fields_class');
		var error = formValidate(jQuery("#popup_register form"), {
			error_message_show: true,
			error_message_time: 4000,
			error_message_class: "sc_infobox sc_infobox_style_error",
			error_fields_class: "error_fields_class",
			exit_after_first_error: true,
			rules: [
				{
					field: "registration_username",
					min_length: { value: 1, message: LOGIN_EMPTY },
					max_length: { value: 60, message: LOGIN_LONG }
				},
				{
					field: "registration_email",
					min_length: { value: 7, message: EMAIL_EMPTY },
					max_length: { value: 60, message: EMAIL_LONG },
					mask: { value: "^([a-z0-9_\\-]+\\.)*[a-z0-9_\\-]+@[a-z0-9_\\-]+(\\.[a-z0-9_\\-]+)*\\.[a-z]{2,6}$", message: EMAIL_NOT_VALID }
				},
				{
					field: "registration_pwd",
					min_length: { value: 4, message: PASSWORD_EMPTY },
					max_length: { value: 20, message: PASSWORD_LONG }
				},
				{
					field: "registration_pwd2",
					equal_to: { value: 'registration_pwd', message: PASSWORD_NOT_EQUAL }
				}
			]
		});
		if (!error) {
			jQuery.post(ajax_url, {
				action: 'registration_user',
				nonce: ajax_nonce,
				user_name: jQuery('#popup_register #registration_username').val(),
				user_email: jQuery('#popup_register #registration_email').val(),
				user_pwd: jQuery('#popup_register #registration_pwd').val()
			}).done(function(response) {
				var rez = JSON.parse(response);
				var result_box = jQuery('#popup_register .result');
				result_box.toggleClass('sc_infobox_style_error', false).toggleClass('sc_infobox_style_success', false);
				if (rez.error === '') {
					result_box.addClass('sc_infobox_style_success').html(REGISTRATION_SUCCESS);
					setTimeout(function() { jQuery('#popup_register .popup_close').trigger('click'); jQuery('.link_login').trigger('click'); }, 2000);
				} else {
					result_box.addClass('sc_infobox_style_error').html(REGISTRATION_FAILED + ' ' + rez.error);
				}
				result_box.fadeIn();
				setTimeout(function() { jQuery('#popup_register .result').fadeOut(); }, 5000);
			});
		}
		e.preventDefault();
		return false;
	});

	// Mainmenu
	jQuery('#mainmenu').superfish({
		autoArrows: false,
		speed: 'fast',
		speedOut: 'fast',
		animation: {height:'show'},
		animationOut: {opacity: 'hide'},
		useClick: false,
		delay: 100,
		disableHI: true
	});

	// Video and Audio tag wrapper
	jQuery('video,audio').mediaelementplayer(/* Options */);

	// Pretty photo
	jQuery("a[href$='jpg'],a[href$='jpeg'],a[href$='png'],a[href$='gif']").toggleClass('prettyPhoto', true);
	jQuery("a[class*='prettyPhoto']").click(function(e) {
		if (jQuery(window).width()<480)	{
			e.stopImmediatePropagation();
			window.location = jQuery(this).attr('href');
		}
		e.preventDefault();
		return false;
	});
	jQuery("a[class*='prettyPhoto']").prettyPhoto({
		social_tools: '',
		theme: 'light_rounded'
	});

	// Galleries Slider
	jQuery('.sc_slider_flex').flexslider({
		directionNav: true,
		controlNav: true,
		animation: 'fade',
		animationLoop: true,
		slideshow: true,
		slideshowSpeed: 7000,
		animationSpeed: 600,
		pauseOnAction: true,
		pauseOnHover: false,
		useCSS: false,
		manualControls: '',
		/*
		start: function(slider){},
		before: function(slider){},
		after: function(slider){},
		end: function(slider){},              
		added: function(){},            
		removed: function(){} 
		*/
	});
	
	// Elastislider links fix
	jQuery(".sc_blogger_slider a").click(function(e) {
		if (!jQuery(this).hasClass('image_zoom')) {
			window.location.href = jQuery(this).attr("href");
		}
		e.preventDefault();
		return false;
	});
	

	// ----------------------- Shortcodes setup -------------------
	jQuery('div.sc_infobox_closeable').click(function() {
		jQuery(this).fadeOut();
	});

	jQuery('.sc_tooltip_parent').hover(function(){
		var obj = jQuery(this);
		obj.find('.sc_tooltip').stop().animate({'marginTop': '5'}, 100).show();
	},
	function(){
		var obj = jQuery(this);
		obj.find('.sc_tooltip').stop().animate({'marginTop': '0'}, 100).hide();
	});
	

	// ----------------------- Comment form submit ----------------
	jQuery("form#commentform").submit(function(e) {
		var error = formValidate(jQuery(this), {
			error_message_text: GLOBAL_ERROR_TEXT,	// Global error message text (if don't write in checked field)
			error_message_show: true,				// Display or not error message
			error_message_time: 5000,				// Error message display time
			error_message_class: 'sc_infobox sc_infobox_style_error',	// Class appended to error message block
			error_fields_class: 'error_fields_class',					// Class appended to error fields
			exit_after_first_error: false,								// Cancel validation and exit after first error
			rules: [
				{
					field: 'author',
					min_length: { value: 1, message: NAME_EMPTY},
					max_length: { value: 60, message: NAME_LONG}
				},
				{
					field: 'email',
					min_length: { value: 7, message: EMAIL_EMPTY},
					max_length: { value: 60, message: EMAIL_LONG},
					mask: { value: '^([a-z0-9_\\-]+\\.)*[a-z0-9_\\-]+@[a-z0-9_\\-]+(\\.[a-z0-9_\\-]+)*\\.[a-z]{2,6}$', message: EMAIL_NOT_VALID}
				},
				{
					field: 'comment',
					min_length: { value: 1, message: MESSAGE_EMPTY },
					max_length: { value: 400, message: MESSAGE_LONG}
				}
			]
		});
		if (error) { e.preventDefault(); }
		return !error;
	});

	/* ================== Customize site ========================= */
	if (jQuery("#custom_options").length===1) {
		jQuery('#co_toggle').click(function(e) {
			var co = jQuery('#custom_options').eq(0);
			if (co.hasClass('opened')) {
				co.removeClass('opened').animate({marginRight:-237}, 300);
			} else {
				co.addClass('opened').animate({marginRight:-15}, 300);
			}
			e.preventDefault();
			return false;
		});
		// Body style
		jQuery("#custom_options .switcher a" ).draggable({
			axis: 'x',
			containment: 'parent',
			stop: function() {
				var left = parseInt(jQuery(this).css('left'), 10);
				var curStyle = left < 25 ? 'wide' : 'boxed';
				switchBox(jQuery(this).parent(), curStyle, true);
			}
		});
		jQuery("#custom_options .switcher" ).click(function(e) {
			switchBox(jQuery(this));
			e.preventDefault();
			return false;
		});
		jQuery("#custom_options .co_switch_box .boxed" ).click(function(e) {
			switchBox(jQuery('#custom_options .switcher'), 'boxed');
			e.preventDefault();
			return false;
		});
		jQuery("#custom_options .co_switch_box .stretched" ).click(function(e) {
			switchBox(jQuery('#custom_options .switcher'), 'wide');
			e.preventDefault();
			return false;
		});
		// Main theme color and Background color
		var clickedObj = null;
		jQuery('#custom_options .colorSelector').ColorPicker({
			onBeforeShow: function () {
				clickedObj = jQuery(this);
				jQuery(this).ColorPickerSetColor(jQuery(this).siblings('input').attr('value'));
			},
			onShow: function (colpkr) {
				jQuery(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				jQuery(colpkr).fadeOut(500);
				return false;
			},
			onSubmit: function (hsb, hex, rgb) {
				jQuery(clickedObj).find('div').css('backgroundColor', '#' + hex);
				jQuery(clickedObj).siblings('input').attr('value','#' + hex);
				if (clickedObj.attr('id')==='co_theme_color') {
					jQuery.cookie('theme_color', '#' + hex, {expires: 365, path: '/'});
					window.location = jQuery("#custom_options #co_site_url").val();
				} else {
					jQuery("#custom_options .co_switch_box .boxed").trigger('click');
					jQuery('#custom_options #co_bg_pattern_list .co_pattern_wrapper,#custom_options #co_bg_images_list .co_image_wrapper').removeClass('current');
					jQuery.cookie('bg_image', null, {expires: -1, path: '/'});
					jQuery.cookie('bg_pattern', null, {expires: -1, path: '/'});
					jQuery.cookie('bg_color', '#' + hex, {expires: 365, path: '/'});
					jQuery(document).find('body').removeClass('bg_pattern_1 bg_pattern_2 bg_pattern_3 bg_pattern_4 bg_pattern_5 bg_image_1 bg_image_2 bg_image_3').css('backgroundColor', '#'+hex);
				}
			}
		});
		// Background patterns
		jQuery('#custom_options #co_bg_pattern_list a').click(function(e) {
			jQuery("#custom_options .co_switch_box .boxed").trigger('click');
			jQuery('#custom_options #co_bg_pattern_list .co_pattern_wrapper,#custom_options #co_bg_images_list .co_image_wrapper').removeClass('current');
			var obj = jQuery(this).addClass('current');
			var val = obj.attr('id').substr(-1);
			jQuery.cookie('bg_color', null, {expires: -1, path: '/'});
			jQuery.cookie('bg_image', null, {expires: -1, path: '/'});
			jQuery.cookie('bg_pattern', val, {expires: 365, path: '/'});
			jQuery(document).find('body').removeClass('bg_pattern_1 bg_pattern_2 bg_pattern_3 bg_pattern_4 bg_pattern_5 bg_image_1 bg_image_2 bg_image_3').addClass('bg_pattern_' + val);
			e.preventDefault();
			return false;
		});
		// Background images
		jQuery('#custom_options #co_bg_images_list a').click(function(e) {
			jQuery("#custom_options .co_switch_box .boxed").trigger('click');
			jQuery('#custom_options #co_bg_images_list .co_image_wrapper,#custom_options #co_bg_pattern_list .co_pattern_wrapper').removeClass('current');
			var obj = jQuery(this).addClass('current');
			var val = obj.attr('id').substr(-1);
			jQuery.cookie('bg_color', null, {expires: -1, path: '/'});
			jQuery.cookie('bg_pattern', null, {expires: -1, path: '/'});
			jQuery.cookie('bg_image', val, {expires: 365, path: '/'});
			jQuery(document).find('body').removeClass('bg_pattern_1 bg_pattern_2 bg_pattern_3 bg_pattern_4 bg_pattern_5 bg_image_1 bg_image_2 bg_image_3').addClass('bg_image_' + val);
			e.preventDefault();
			return false;
		});
	}
	/* ================== /Customize site ========================= */
});

function switchBox(box) {
	"use strict";
	var toStyle = arguments[1] ? arguments[1] : '';
	var important = arguments[2] ? arguments[2] : false;
	var switcher = box.find('a').eq(0);
	var left = parseInt(switcher.css('left'), 10);
	var newStyle = left < 5 ? 'boxed' : 'wide';
	if (toStyle==='' || important || newStyle === toStyle) {
		if (toStyle==='') {toStyle = newStyle;}
		var right = box.width() - switcher.width() + 2;
		if (toStyle === 'wide') {switcher.animate({left: -2}, 200);}
		else {switcher.animate({left: right}, 200);}
		jQuery.cookie('body_style', toStyle, {expires: 365, path: '/'});
		jQuery(document).find('body').removeClass(toStyle==='boxed' ? 'wide' : 'boxed').addClass(toStyle);
		jQuery(document).trigger('resize');
	}
	return newStyle;
}
