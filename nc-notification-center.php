<?php
/**
 * The Notification Center Plugin
 *
 * The Notification Center Plugin is a plugin to show some notices to users in WordPress.
 *
 * @package NC Notification Center
 */

/**
 * Plugin Name: NC Notification Center
 * Plugin URI:  http://inglesnarede.com.br
 * Description: The Notification Center Plugin for showing notices to users in WordPress
 * Author:      Renato Alves, Blog Inglês na Rede
 * Author URI:  http://ralv.es
 * Version:     1.0.0
 * Text Domain: nc-notification-center
 * Domain Path: /languages
 * License:     GPLv2 or later (license.txt)
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists('NC_Notification_Center') ) :
	/**
	* The Main NC_Notification_Center Class
	*
	* Highly inspired by BuddyPress and bbPress plugins
	*
	* @since NC_Notification_Center (1.0.0)
	*
	* @todo Add the Translation functions and file
	*/
	class NC_Notification_Center {
		/**
		 * Main instance
		 *
		 * @since NC_Notification_Center (1.0.0)
		 * @access public
		 * 
		 * @return instance
		 */
		public static function instance() {

			// Store the instance locally to avoid private static replication
			static $instance = null;

			// Only run these methods if they haven't been run previously
			if ( null === $instance ) {
				$instance = new NC_Notification_Center;
				$instance->setup_globals();
				$instance->includes();
				$instance->setup_actions();
			}

			// Always return the instance
			return $instance;
		}

		/**
		 * Construct
		 *
		 * @since NC_Notification_Center (1.0.0)
		 */
		private function __construct() { /*	Nothing for now! */ }


		/** Private Methods *******************************************************/

		/**
		 * Set some smart defaults to class variables. Allow some of them to be
		 * filtered to allow for early overriding.
		 *
		 * @since NC_Notification_Center (1.0.0)
		 * @access private
		 *
		 * @uses plugin_dir_path() Taking the plugin directory path
		 * @uses apply_filters() In case you want to change it
		 */
		private function setup_globals() {

			/** Paths *************************************************************/
			$this->file       = __FILE__;
			$this->plugin_dir = plugin_dir_path( $this->file );

			$this->core_dir = apply_filters( 'nc_dir', trailingslashit( $this->plugin_dir . 'core'  ) );

			if( ! defined('NC_DIR') ) 
				define('NC_DIR', plugin_dir_url( __FILE__ ) );
		}
		
		/**
		 * Include required files.
		 *
		 * @since NC_Notification_Center (1.0.0)
		 * @access private
		 *
		 * @uses is_admin() If is not in WordPress admin, load additional file.
		 */
		private function includes() {
			require( $this->core_dir . 'core-template.php' );
			require( $this->core_dir . 'assets.php' );

			if ( ! is_admin() ) {
				require( $this->core_dir . 'shortcode.php' );
			}
		}

		/**
		 * Adding the Notification Center Actions
		 * 
		 * @since NC_Notification_Center (1.0.0)
		 * @access private
		 *
		 * @uses add_action() Adding the nc_notification_center_post_type post type to the array
		 */
		private function setup_actions() {
			add_action( 'init', array( $this, 'nc_notification_center_post_type' ) );
		}

		/** Public Methods *******************************************************/

		public static function nc_notification_center_post_type() {
			$labels = array(
				'name' 					=> _x( 'Notification', 'post type general name', 'nc-notification-center' ),
				'singular_name' 		=> _x( 'Notification', 'post type singular name', 'nc-notification-center' ),
				'add_new' 				=> _x( 'Add New', 'Notification', 'nc-notification-center' ),
				'add_new_item' 			=> __( 'Add New Notification', 'nc-notification-center' ),
				'edit_item' 			=> __( 'Edit Notification', 'nc-notification-center' ),
				'new_item' 				=> __( 'New Notification', 'nc-notification-center' ),
				'view_item' 			=> __( 'View Notification', 'nc-notification-center' ),
				'search_items' 			=> __( 'Search Notifications', 'nc-notification-center' ),
				'not_found' 			=> __( 'No Notifications found', 'nc-notification-center' ),
				'not_found_in_trash' 	=> __( 'No Notifications found in Trash', 'nc-notification-center' ),
				'parent_item_colon' 	=> ''
			);

		 	$noticification_args = array(
		     	'labels' 				=> $labels,
		     	'singular_label' 		=> __('Notification', 'nc-notification-center'),
		     	'public' 				=> true,
		     	'show_ui' 				=> true,
				'show_in_menu'       	=> true,
			  	'capability_type' 		=> 'post',
			  	'menu_position'      	=> 20,
		     	'hierarchical' 			=> false,
		     	'rewrite' 				=> false,
		     	'menu_icon'           	=> 'dashicons-megaphone',
		     	'supports' 				=> array('title', 'editor', 'revisions')
		    );
		 	register_post_type('nc-notification', $noticification_args);
		}
	}
endif;

/**
 * The main function responsible for returning the one true NC_Notification_Center Instance to functions everywhere.
 *
 * @return NC_Notification_Center The one true NC_Notification_Center Instance.
 */
function NC_Notification_Center() {
	return NC_Notification_Center::instance();
}
add_action( 'plugins_loaded', 'NC_Notification_Center');

// And that's it! =)
