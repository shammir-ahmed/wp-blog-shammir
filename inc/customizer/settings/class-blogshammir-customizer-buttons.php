<?php
/**
 * Buttons section in Customizer Â» General Settings.
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

if ( ! class_exists( 'Blogshammir_Customizer_Buttons' ) ) :
	/**
	 * Buttons section in Customizer Â» General Settings.
	 */
	class Blogshammir_Customizer_Buttons {

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

			$theme = wp_get_theme();
			// Upsell section
			$options['section']['blogshammir_section_upsell_button'] = array(
				'class'    => 'Blogshammir_Customizer_Control_Section_Pro',
				'title'    => esc_html__( 'Need more features?', 'blogshammir' ),
				'pro_url'  => sprintf( esc_url_raw( 'https://github.com/shammir-ahmed%s' ), strtolower( $theme->name ) ),
				'pro_text' => esc_html__( 'Upgrade to pro', 'blogshammir' ),
				'priority' => 200,
			);

			$options['setting']['blogshammir_section_upsell_heading'] = array(
				'control' => array(
					'type'    => 'hidden',
					'section' => 'blogshammir_section_upsell_button',
				),
			);
			// Docs link
			$options['section']['blogshammir_section_docs_button'] = array(
				'class'    => 'Blogshammir_Customizer_Control_Section_Pro',
				'title'    => esc_html__( 'Need Help?', 'blogshammir' ),
				'pro_url'  => esc_url_raw( 'http://docs.peregrine-themes.com/' ),
				'pro_text' => esc_html__( 'See the Articles', 'blogshammir' ),
				'priority' => 200,
			);

			$options['setting']['blogshammir_section_docs_heading'] = array(
				'control' => array(
					'type'    => 'hidden',
					'section' => 'blogshammir_section_docs_button',
				),
			);

			return $options;
		}
	}
endif;
new Blogshammir_Customizer_Buttons();


