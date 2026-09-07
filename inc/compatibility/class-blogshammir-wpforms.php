<?php
/**
 * WP Forms compatibility class.
 *
 * @package BlogShammir
 * @author Md Shammir Ahmed
 * @since   1.0.0
 */

/**
 * Do not allow direct script access.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Blogshammir_WPForms' ) ) :
	/**
	 * WPForms compatibility class.
	 */
	class Blogshammir_WPForms {

		/**
		 * Primary class constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			add_action( 'activate_wpforms-lite/wpforms.php', array( $this, 'disable_redirect_on_activation' ), 20 );

			// If WPForms is not activated then return.
			if ( ! class_exists( 'WPForms' ) ) {
				return;
			}
		}

		/**
		 * Disable admin page redirect on plugin activation.
		 *
		 * @since 1.0.0
		 */
		public function disable_redirect_on_activation() {
			delete_transient( 'wpforms_activation_redirect' );
		}
	}
endif;
new Blogshammir_WPForms();


