<?php
/**
 * Blogshammir Layout section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Layout' ) ) :
	/**
	 * Blogshammir Layout section in Customizer.
	 */
	class Blogshammir_Customizer_Layout {

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
			$options['section']['blogshammir_layout_section'] = array(
				'title'    => esc_html__( 'Layout', 'blogshammir' ),
				'panel'    => 'blogshammir_panel_general',
				'priority' => 10,
			);

			// Site layout.
			$options['setting']['blogshammir_site_layout'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'section'     => 'blogshammir_layout_section',
					'label'       => esc_html__( 'Site Layout', 'blogshammir' ),
					'description' => esc_html__( 'Choose your site&rsquo;s main layout.', 'blogshammir' ),
					'choices'     => array(
						'fw-contained' => esc_html__( 'Full Width: Contained', 'blogshammir' ),
						'fw-stretched' => esc_html__( 'Full Width: Stretched', 'blogshammir' ),
					),
				),
			);

			return $options;
		}
	}
endif;
new Blogshammir_Customizer_Layout();


