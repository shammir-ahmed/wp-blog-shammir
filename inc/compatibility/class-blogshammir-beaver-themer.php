<?php
/**
 * Blogshammir compatibility class for Beaver Themer.
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

// Return if Beaver Themer not active.
if ( ! class_exists( 'FLThemeBuilderLoader' ) || ! class_exists( 'FLThemeBuilderLayoutData' ) ) {
	return;
}

// PHP 5.3+ is required.
if ( ! version_compare( PHP_VERSION, '5.3', '>=' ) ) {
	return;
}

if ( ! class_exists( 'Blogshammir_Beaver_Themer' ) ) :

	/**
	 * Beaver Themer compatibility.
	 */
	class Blogshammir_Beaver_Themer {

		/**
		 * Singleton instance of the class.
		 *
		 * @var object
		 */
		private static $instance;

		/**
		 * Instance.
		 *
		 * @since 1.0.0
		 * @return Blogshammir_Beaver_Themer
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Blogshammir_Beaver_Themer ) ) {
				self::$instance = new Blogshammir_Beaver_Themer();
			}
			return self::$instance;
		}

		/**
		 * Primary class constructor.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'add_theme_support' ) );
			add_action( 'wp', array( $this, 'header_footer_render' ) );
			add_action( 'wp', array( $this, 'page_header_render' ) );
			add_filter( 'fl_theme_builder_part_hooks', array( $this, 'register_part_hooks' ) );
		}

		/**
		 * Add theme support
		 *
		 * @since 1.0.0
		 */
		public function add_theme_support() {
			add_theme_support( 'fl-theme-builder-headers' );
			add_theme_support( 'fl-theme-builder-footers' );
			add_theme_support( 'fl-theme-builder-parts' );
		}

		/**
		 * Update header/footer with Beaver template
		 *
		 * @since 1.0.0
		 */
		public function header_footer_render() {

			// Get the header ID.
			$header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();

			// If we have a header, remove the theme header and hook in Theme Builder's.
			if ( ! empty( $header_ids ) ) {

				// Remove Top Bar.
				remove_action( 'blogshammir_header', 'blogshammir_topbar_output', 10 );

				// Remove Main Header.
				remove_action( 'blogshammir_header', 'blogshammir_header_output', 20 );

				// Replacement header.
				add_action( 'blogshammir_header', 'FLThemeBuilderLayoutRenderer::render_header' );
			}

			// Get the footer ID.
			$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();

			// If we have a footer, remove the theme footer and hook in Theme Builder's.
			if ( ! empty( $footer_ids ) ) {

				// Remove Main Footer.
				remove_action( 'blogshammir_footer', 'blogshammir_footer_output', 20 );

				// Remove Copyright Bar.
				remove_action( 'blogshammir_footer', 'blogshammir_copyright_bar_output', 30 );

				// Replacement footer.
				add_action( 'blogshammir_footer', 'FLThemeBuilderLayoutRenderer::render_footer' );
			}
		}

		/**
		 * Remove page header if using Beaver Themer.
		 *
		 * @since 1.0.0
		 */
		public function page_header_render() {

			// Get the page ID.
			$page_ids = FLThemeBuilderLayoutData::get_current_page_content_ids();

			// If we have a content layout, remove the theme page header.
			if ( ! empty( $page_ids ) ) {
				remove_action( 'blogshammir_page_header', 'blogshammir_page_header_template' );
			}
		}

		/**
		 * Register hooks
		 *
		 * @since 1.0.0
		 */
		public function register_part_hooks() {
			return array(
				array(
					'label' => 'Header',
					'hooks' => array(
						'blogshammir_before_masthead' => esc_html__( 'Before Header', 'blogshammir' ),
						'blogshammir_after_masthead'  => esc_html__( 'After Header', 'blogshammir' ),
					),
				),
				array(
					'label' => 'Main',
					'hooks' => array(
						'blogshammir_before_main' => esc_html__( 'Before Main', 'blogshammir' ),
						'blogshammir_after_main'  => esc_html__( 'After Main', 'blogshammir' ),
					),
				),
				array(
					'label' => 'Content',
					'hooks' => array(
						'blogshammir_before_page_content' => esc_html__( 'Before Content', 'blogshammir' ),
						'blogshammir_after_page_content'  => esc_html__( 'After Content', 'blogshammir' ),
					),
				),
				array(
					'label' => 'Footer',
					'hooks' => array(
						'blogshammir_before_colophon' => esc_html__( 'Before Footer', 'blogshammir' ),
						'blogshammir_after_colophon'  => esc_html__( 'After Footer', 'blogshammir' ),
					),
				),
				array(
					'label' => 'Sidebar',
					'hooks' => array(
						'blogshammir_before_sidebar' => esc_html__( 'Before Sidebar', 'blogshammir' ),
						'blogshammir_after_sidebar'  => esc_html__( 'After Sidebar', 'blogshammir' ),
					),
				),
				array(
					'label' => 'Singular',
					'hooks' => array(
						'blogshammir_before_singular'       => __( 'Before Singular', 'blogshammir' ),
						'blogshammir_after_singular'        => __( 'After Singular', 'blogshammir' ),
						'blogshammir_before_comments'       => __( 'Before Comments', 'blogshammir' ),
						'blogshammir_after_comments'        => __( 'After Comments', 'blogshammir' ),
						'blogshammir_before_single_content' => __( 'Before Single Content', 'blogshammir' ),
						'blogshammir_after_single_content'  => __( 'After Single Content', 'blogshammir' ),
					),
				),
			);
		}

	}

endif;

/**
 * Returns the one Blogshammir_Beaver_Themer instance.
 */
function blogshammir_beaver_themer() {
	return Blogshammir_Beaver_Themer::instance();
}

blogshammir_beaver_themer();


