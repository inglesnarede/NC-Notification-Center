<?php
/**
 * Notification Center Read Functions
 * 
 * @package NC Notification Center
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Function to confirm if the notification was read/closed
 * 
 * @since NC_Notification_Center (1.0.0)
 * 
 * @uses get_user_meta() Get the user metadata
 * @param $post_id The post ID
 * @param $user_id The user ID
 * @return true|false|null
 */
function nc_check_notification_is_read($post_id, $user_id) {
	
	$read_notifications = get_user_meta($user_id, 'nc_notification_ids', true);

	if( $read_notifications && is_array($read_notifications) ) {
		
		if( in_array($post_id, $read_notifications) ) {
			return true;
		}
	}
	
	// if not closed
	return false;
}

/**
 * Function to add the notification ID to the current user closing the notification
 * 
 * @since NC_Notification_Center (1.0.0)
 *
 * @global $user_ID Global variable with the ID of the current user
 * 
 * @uses update_user_meta() Update the user medadata
 * @uses get_user_meta() Get the user medatada
 * @param int $post_id The post ID
 * @return int The notification id
 */
function nc_notification_add_to_usermeta($post_id) {
	global $user_ID;

	$read_notifications = get_user_meta($user_ID, 'nc_notification_ids', true);
	$read_notifications[] = $post_id;
	
	update_user_meta($user_ID, 'nc_notification_ids', $read_notifications);

	// Check and make sure the stored value matches the new one
	if ( get_user_meta( $user_ID, 'nc_notification_ids', true ) != $read_notifications )
		wp_die( __('Something is wrong here.', 'nc-notification-center') );
}

/**
 * Function to mark a notification as read/closed
 * 
 * @since NC_Notification_Center (1.0.0)
 * 
 * @see nc_notification_add_to_usermeta()
 * @return null It is just a placeholder
 */
function nc_notification_mark_as_read() {
	if( isset( $_POST['nc_notification_read'] ) ) {

		$nc_notification_id = intval( $_POST['nc_notification_read'] );

		$marked_as_read = nc_notification_add_to_usermeta( $nc_notification_id );
	}
	die();
}
add_action('wp_ajax_mark_notification_as_read', 'nc_notification_mark_as_read');
