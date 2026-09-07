<?php
/**
 * Blogshammir Misc section in Customizer.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

/**
 * Do not allow direct script access.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Blogshammir_Customizer_Misc' ) ) :
	/**
	 * Blogshammir Misc section in Customizer.
	 */
	class Blogshammir_Customizer_Misc {

		/**
		 * Primary class constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			/**
			 * Registers our custom options in Customizer.
			 */
			add_filter( 'blogshammir_customizer_options', array( $this, 'register_options' ) );
		}

		/**
		 * Registers our custom options in Customizer.
		 *
		 * @since 1.0.0
		 * @param array $options Array of customizer options.
		 */
		public function register_options( $options ) {

			// Section.
			$options['section']['blogshammir_section_misc'] = array(
				'title'    => esc_html__( 'Misc Settings', 'blogshammir' ),
				'panel'    => 'blogshammir_panel_general',
				'priority' => 60,
			);

			// Schema toggle.
			$options['setting']['blogshammir_enable_schema'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Schema Markup', 'blogshammir' ),
					'description' => esc_html__( 'Add structured data to your content.', 'blogshammir' ),
					'section'     => 'blogshammir_section_misc',
				),
			);

			// Custom form styles.
			$options['setting']['blogshammir_custom_input_style'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Custom Form Styles', 'blogshammir' ),
					'description' => esc_html__( 'Custom design for checkboxes and radio buttons.', 'blogshammir' ),
					'section'     => 'blogshammir_section_misc',
				),
			);

			// Enable/Disable Page Preloader.
			$options['setting']['blogshammir_preloader'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Enable Page Preloader', 'blogshammir' ),
					'description' => esc_html__( 'Show animation until page is fully loaded.', 'blogshammir' ),
					'section'     => 'blogshammir_section_misc',
				),
			);

			// Enable/Disable Scroll Top.
			$options['setting']['blogshammir_scroll_top'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Enable Scroll Top Button', 'blogshammir' ),
					'description' => esc_html__( 'A sticky button that allows users to easily return to the top of a page.', 'blogshammir' ),
					'section'     => 'blogshammir_section_misc',
				),
			);

			// Enable/Disable Cursor Dot.
			$options['setting']['blogshammir_enable_cursor_dot'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Enable Cursor Dot', 'blogshammir' ),
					'description' => esc_html__( 'A cursor dot effect show on desktop size mode only with work on mouse.', 'blogshammir' ),
					'section'     => 'blogshammir_section_misc',
				),
			);

			return $options;
		}
	}
endif;
new Blogshammir_Customizer_Misc();


