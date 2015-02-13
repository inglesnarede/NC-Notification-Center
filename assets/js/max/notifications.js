jQuery(document).ready( function($) {

	// Notification is present and user is not logged in
	if ($("#nc-notification-area").length && nc_notification_ajax_script.logged_in == 'no') {
		
		var nc_notification_id = $('#nc-notification-area #remove-notification').attr('rel');

		if(!$.cookie('nc-notification-' + nc_notification_id)) {
			$('#nc-notification-area').show();
		}
		
		else { $('#nc-notification-area').detach(); }
	}
	
	$("#remove-notification").click( function() {
		
		var nc_notification_id = $(this).attr('rel');
		
		if( nc_notification_ajax_script.logged_in == 'no') {
			
			// Store a cookie in the browser so that it doesn't appear again
			$.cookie('nc-notification-' + nc_notification_id, 'with-cookie', { expires: 1 });
		}

		// If the user is logged in, store the notification ID in the User Meta Data
		var data = {
			action: 'mark_notification_as_read',
			nc_notification_read: nc_notification_id
		};

		$.post(nc_notification_ajax_script.ajaxurl, data, function(response) {
			$('#nc-notification-area').detach();
		});
		return false;
	});
});
