<?php
/**
 * Blogshammir Base Colors section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Colors' ) ) :
	/**
	 * Blogshammir Colors section in Customizer.
	 */
	class Blogshammir_Customizer_Colors {

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
			$options['section']['blogshammir_section_colors'] = array(
				'title'    => esc_html__( 'Base Colors', 'blogshammir' ),
				'panel'    => 'blogshammir_panel_general',
				'priority' => 20,
			);

			// Accent color.
			$options['setting']['blogshammir_accent_color'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_color',
				'control'           => array(
					'type'        => 'blogshammir-color',
					'label'       => esc_html__( 'Accent Color', 'blogshammir' ),
					'description' => esc_html__( 'The accent color is used subtly throughout your site, to call attention to key elements.', 'blogshammir' ),
					'section'     => 'blogshammir_section_colors',
					'priority'    => 10,
					'opacity'     => false,
				),
			);

			// Dark mode
			$options['setting']['blogshammir_dark_mode'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Dark mode', 'blogshammir' ),
					'description' => esc_html__( 'Enable dark mode.', 'blogshammir' ),
					'section'     => 'blogshammir_section_colors',
					'priority'    => 11,
				),
			);

			// Body Animation
			$options['setting']['blogshammir_body_animation'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'label'       => esc_html__( 'Body Animation', 'blogshammir' ),
					'description' => esc_html__( 'Choose Body Animation.', 'blogshammir' ),
					'section'     => 'blogshammir_section_colors',
					'priority'    => 12,
					'choices'     => array(
						'0' => esc_html__( 'None', 'blogshammir' ),
						'1' => esc_html__( 'Glassmorphism', 'blogshammir' ),
					),
				),
			);

			// Body background heading.
			$options['setting']['blogshammir_body_background_heading'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'     => 'blogshammir-heading',
					'priority' => 40,
					'label'    => esc_html__( 'Body Background', 'blogshammir' ),
					'section'  => 'blogshammir_section_colors',
					'toggle'   => false,
				),
			);

			return $options;
		}

	}
endif;
new Blogshammir_Customizer_Colors();


