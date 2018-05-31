jQuery(document).ready(function(){
	jQuery('.btn-settings-ajax').on('click', function(){
		var clicked_button = jQuery(this);
		var click_btn_value = clicked_button.attr('data-action');
		if (!click_btn_value == 0) {
			clicked_button.css('display', 'none');;
			var response_text = clicked_button.next().css('display', 'inline-block');;

			jQuery.ajax({
				type: 'POST',
				url: ajax_postajax.ajaxurl,
				data: {
					action: click_btn_value
				},
				success: function(data) {
					response_text.text(data);
					
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					response_text.text(data);
				}
			});
		}
	return false;
	});
});