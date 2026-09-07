<?php //phpcs:ignore
/**
 * Theme functions and definitions.
 *
 * @package BlogShammir
 * @author Md Shammir Ahmed
 * @since   1.0.0
 */

/**
 * Main Blogshammir class.
 *
 * @since 1.0.0
 */
final class Blogshammir {

	/**
	 * Theme options
	 *
	 * @since 1.0.0
	 * @var object
	 */
	public $options;

	/**
	 * Theme fonts
	 *
	 * @since 1.0.0
	 * @var object
	 */
	public $fonts;

	/**
	 * Theme icons
	 *
	 * @since 1.0.0
	 * @var object
	 */
	public $icons;

	/**
	 * Theme customizer
	 *
	 * @since 1.0.0
	 * @var object
	 */
	public $customizer;

	/**
	 * Theme admin
	 *
	 * @since 1.0.0
	 * @var object
	 */
	public $admin;

	/**
	 * Singleton instance of the class.
	 *
	 * @since 1.0.0
	 * @var object
	 */
	private static $instance;
	/**
	 * Theme version.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $version = '1.0.30';
	/**
	 * Main Blogshammir Instance.
	 *
	 * Insures that only one instance of Blogshammir exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0.0
	 * @return Blogshammir
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Blogshammir ) ) {
			self::$instance = new Blogshammir();
			self::$instance->constants();
			self::$instance->includes();
			self::$instance->objects();
			// Hook now that all of the Blogshammir stuff is loaded.
			do_action( 'blogshammir_loaded' );
		}
		return self::$instance;
	}

	/**
	 * Setup constants.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function constants() {
		if ( ! defined( 'BLOGSHAMMIR_THEME_VERSION' ) ) {
			define( 'BLOGSHAMMIR_THEME_VERSION', $this->version );
		}
		if ( ! defined( 'BLOGSHAMMIR_THEME_URI' ) ) {
			define( 'BLOGSHAMMIR_THEME_URI', get_parent_theme_file_uri() );
		}
		if ( ! defined( 'BLOGSHAMMIR_THEME_PATH' ) ) {
			define( 'BLOGSHAMMIR_THEME_PATH', get_parent_theme_file_path() );
		}
	}
	/**
	 * Include files.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function includes() {
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/common.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/helpers.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/widgets.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/template-tags.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/template-parts.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/icon-functions.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/breadcrumbs.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/class-blogshammir-dynamic-styles.php';
		// Core.
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/core/class-blogshammir-options.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/core/class-blogshammir-enqueue-scripts.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/core/class-blogshammir-fonts.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/core/class-blogshammir-theme-setup.php';
		// Compatibility.
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/compatibility/woocommerce/class-blogshammir-woocommerce.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/compatibility/socialsnap/class-blogshammir-socialsnap.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/compatibility/class-blogshammir-wpforms.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/compatibility/class-blogshammir-jetpack.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/compatibility/class-blogshammir-beaver-themer.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/compatibility/class-blogshammir-elementor.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/compatibility/class-blogshammir-elementor-pro.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/compatibility/class-blogshammir-hfe.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/compatibility/back-compat.php';

		if ( is_admin() ) {
			require_once BLOGSHAMMIR_THEME_PATH . '/inc/utilities/class-blogshammir-plugin-utilities.php';
			require_once BLOGSHAMMIR_THEME_PATH . '/inc/admin/class-blogshammir-admin.php';

		}
		new Blogshammir_Enqueue_Scripts();
		// Customizer.
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/customizer/class-blogshammir-customizer.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/customizer/customizer-callbacks.php';
		require_once BLOGSHAMMIR_THEME_PATH . '/inc/customizer/class-blogshammir-section-ordering.php';
	}
	/**
	 * Setup objects to be used throughout the theme.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function objects() {

		blogshammir()->options    = new Blogshammir_Options();
		blogshammir()->fonts      = new Blogshammir_Fonts();
		blogshammir()->icons      = new Blogshammir_Icons();
		blogshammir()->customizer = new Blogshammir_Customizer();
		if ( is_admin() ) {
			blogshammir()->admin = new Blogshammir_Admin();
		}
	}
}

/**
 * The function which returns the one Blogshammir instance.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $blogshammir = blogshammir(); ?>
 *
 * @since 1.0.0
 * @return object
 */
function blogshammir() {
	return Blogshammir::instance();
}

blogshammir();


