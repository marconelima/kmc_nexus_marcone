/* global jQuery:false */

jQuery(document).ready(function() {
	"use strict";
	// Show/Hide Custom Parameters Section
	jQuery('.custom_parameters_link').click(function(e) {
		jQuery('.custom_parameters_section').toggleClass('opened');
		e.preventDefault();
		return false;
	});
});


// Post categories change handler
// show additional fields for portfolio
function initPostDetails() {
	"use strict";
	jQuery('#categorychecklist input[type="checkbox"]').on('change', categoryChangeHandler);
	checkPostCategories();
}

function categoryChangeHandler() {
	"use strict";
	checkPostCategories();
}

function checkPostCategories() {
	"use strict";
	var cat_ids = '';
	jQuery('#categorychecklist input[type="checkbox"]').each(function() {
		if (jQuery(this).get(0).checked) {
			cat_ids += (cat_ids!=='' ? ',' : '')+jQuery(this).val();
		}
	});
	// Check selected cats for portfolio fields
	jQuery.post( ajax_url, {
		action: 'check_portfolio_style',
		ids: cat_ids,
		nonce: ajax_nonce
	}).done( function(response) {
		var rez = null;
		try {
			rez = JSON.parse(response);
		} catch(e) {
			rez = null;
		}
		if (rez.portfolio === 1) {
			jQuery('.portfolio_meta').show();
		} else {
			jQuery('.portfolio_meta').hide();
		}
	});
}


// Icons selector
function initIconsSelector() {
	"use strict";
	jQuery('.radio-icon-icon').click(function(){
		jQuery(this).parent().find('.radio-icon-icon').removeClass('radio-icon-selected');
		jQuery(this).addClass('radio-icon-selected');
	});
}


// Media manager handler
var media_frame = null;
var media_link = '';
function showMediaManager(el) {
	"use strict";

	media_link = jQuery(el);
	// If the media frame already exists, reopen it.
	if ( media_frame ) {
		media_frame.open();
		return false;
	}

	// Create the media frame.
	media_frame = wp.media({
		// Set the title of the modal.
		title: media_link.data('choose'),
		// Tell the modal to show only images.
		library: {
			type: 'image'
		},
		// Multiple choise
		muiltiple: media_link.data('multiple')==='true',
		// Customize the submit button.
		button: {
			// Set the text of the button.
			text: media_link.data('update'),
			// Tell the button not to close the modal, since we're
			// going to refresh the page when the image is selected.
			close: true
		}
	});

	// When an image is selected, run a callback.
	media_frame.on( 'select', function() {
		// Grab the selected attachment.
		var field = jQuery("#"+media_link.data('linked-field')).eq(0);
		var attachment = '';
		if (media_link.data('multiple')==='true') {
			media_frame.state().get('selection').map( function( att ) {
				attachment += (attachment ? "\n" : "") + att.toJSON().url;
			});
			var val = field.val();
			attachment = val + (val ? "\n" : '') + attachment;
		} else {
			attachment = media_frame.state().get('selection').first().toJSON().url;
		}
		field.val(attachment);
		field.trigger('change');
	});

	// Finally, open the modal.
	media_frame.open();
	return false;
}
