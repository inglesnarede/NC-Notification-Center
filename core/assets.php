<?php
/**
 * Notification Center Assets
 * 
 * @package NC Notification Center
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Loads CSS and Javascript needed for the Notification
 * 
 * @since NC_Notification_Center (1.0.0)
 *
 * @uses wp_enqueue_style() Enqueue the needed CSS
 * @uses wp_enqueue_script() Enqueue the needed js
 * @uses wp_localize_script() Localize needed js globals
 * @uses is_user_logged_in() Check if user is loggedin
 * @return array Enqueues the Style and Js needed to present the notifications
 */
function nc_notification_center_assets() {
	$logged_in = 'yes';

	// Loads the CSS
	wp_enqueue_style( 'nc-notification', NC_DIR . 'assets/css/notifications.css');

	// Loads JS for non logged in users
	// Comes with jquery.cookie
	if ( ! is_user_logged_in() ) {
		wp_enqueue_script( 'nc-notification', NC_DIR . 'assets/js/jquery.cokkie.js', array( 'jquery' ) );
		wp_enqueue_script( 'nc-notification', NC_DIR . 'assets/js/nc-notification-center.js', array( 'jquery' ) );
		$logged_in = 'no';
	} 

	// Load now for the logged in
	// jquery.cookie removed as the ID it is stored in medatada
	else {
		wp_enqueue_script( 'nc-notification', NC_DIR . 'assets/js/nc-notification-center.js', array( 'jquery' ) );
	}
	
	// Global variables
	wp_localize_script( 'nc-notification', 'nc_notification_ajax_script', 
		array( 
			'ajaxurl' 	=> admin_url( 'admin-ajax.php' ),
			'logged_in' => $logged_in
		)
	);	
}
add_action('wp_enqueue_scripts', 'nc_notification_center_assets');

/**
 * Removes the JS and CSS if user already removed the notification (clicked the close button),
 * otherwise, it loads the js/css in every page loads after first visit
 *
 * @since NC_Notification_Center (1.0.0)
 *
 * @global $user_ID Global variable with the ID of the current user
 *
 * @uses get_posts() To fetch the last nc-notification post type
 * @uses nc_check_notification_is_read() To check if the notification had already been removed
 * @uses wp_dequeue_style() For removing styles
 * @uses wp_dequeue_script() For removing scripts
 * @return array Returns an array with the assets
 */
function nc_notification_remove_assets(){
	global $user_ID;

	// Query agrs removing pagination and unneeded caching
	$notification_args = array( 'post_type' => 'nc-notification', 'posts_per_page' => 1, 'no_found_rows' => true, 'cache_results' => false, 'update_post_meta_cache' => false, 'update_post_term_cache' => false );

	$notifications = get_posts( $notification_args );

	if( $notifications ) :
		foreach ( $notifications as $notification ) {
			if( nc_check_notification_is_read($notification->ID, $user_ID) == true || !is_user_logged_in() && isset($_COOKIE['nc-notification-' . $notification->ID . '']) ) {
				wp_dequeue_style('nc-notification');
				wp_dequeue_script('nc-notification');
			}
		}
	endif;
}
add_action('wp_enqueue_scripts', 'nc_notification_remove_assets');
