<?php
/**
 * Blogshammir Sticky Header Settings section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Sticky_Header' ) ) :
	/**
	 * Blogshammir Sticky Header section in Customizer.
	 */
	class Blogshammir_Customizer_Sticky_Header {

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

			// Sticky Header Section.
			$options['section']['blogshammir_section_sticky_header'] = array(
				'title'    => esc_html__( 'Sticky Header', 'blogshammir' ),
				'panel'    => 'blogshammir_panel_header',
				'priority' => 80,
			);

			// Enable Transparent Header.
			$options['setting']['blogshammir_sticky_header'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'    => 'blogshammir-toggle',
					'label'   => esc_html__( 'Enable Sticky Header', 'blogshammir' ),
					'section' => 'blogshammir_section_sticky_header',
				),
			);

			return $options;
		}
	}
endif;
new Blogshammir_Customizer_Sticky_Header();


