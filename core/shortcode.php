<?php
/**
 * Notification Center - Shortcode to display the notification
 * 
 * @package NC Notification Center
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * The NC Notification Area shortcode displays the notification if the user has not read it before
 *
 * The shorcode is to be put in different places in the community so that where the user go, he/she can 
 * be informed of everything that is going on.
 * 
 * @since NC_Notification_Center (1.0.0)
 * 
 * @uses nc_check_notification_is_read() To confirm if the user already read particular notification
 * @uses do_shortcode() To make the content of the Notification shortcode compatiable
 * @return shorcode Returns the NC Notification Area Shortcode
 */
function nc_notification_display() {
	global $user_ID;

	$notification_args = array( 'post_type' => 'nc-notification', 'posts_per_page' => 1, 'no_found_rows' => true, 'cache_results' => false, 'update_post_meta_cache' => false, 'update_post_term_cache' => false );

	$notifications = get_posts( $notification_args );

	if( $notifications ) :
		foreach ( $notifications as $notification ) {

			if( is_user_logged_in() && nc_check_notification_is_read($notification->ID, $user_ID) != true ||
				!is_user_logged_in() && !isset($_COOKIE['nc-notification-' . $notification->ID . '']) ) { ?>

				<section id="nc-notification-area" class="small-12 columns" role="region">
					<div class="nc-notification-area">					
						<a id="remove-notification" class="remove-notification" href="" rel="<?php echo esc_attr( $notification->ID ); ?>"><?php _e('X', 'nc-notification-area'); ?></a>
						
						<h6><?php echo esc_html( get_the_title( $notification->ID ) ); ?></h6>

						<?php echo do_shortcode( wpautop( __( $notification->post_content ) ) ); ?>
					</div>
				</section>

			<?php }
		}
	endif;
}
add_shortcode( 'nc-notification-area', 'nc_notification_display' );
