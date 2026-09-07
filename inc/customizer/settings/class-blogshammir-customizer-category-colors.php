<?php
/**
 * Blogshammir Category Colors section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Category_Colors' ) ) :
	/**
	 * Blogshammir Colors section in Customizer.
	 */
	class Blogshammir_Customizer_Category_Colors {

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
			$options['section']['blogshammir_section_category_colors'] = array(
				'title'    => esc_html__( 'Post Category Colors', 'blogshammir' ),
				'panel'    => 'blogshammir_panel_general',
				'priority' => 21,
			);

			// Category color.
			$categories = get_categories( array( 'hide_empty' => 1 ) );
			foreach ( $categories as $category ) {
				$options['setting'][ 'blogshammir_category_color_' . esc_attr( $category->term_id ) ] = array(
					'transport'         => 'refresh',
					'sanitize_callback' => 'blogshammir_sanitize_color',
					'control'           => array(
						'type'     => 'blogshammir-color',
						'label'    => sprintf( esc_html__( '%1$s Color', 'blogshammir' ), esc_html( $category->name ) ),
						'section'  => 'blogshammir_section_category_colors',
						'priority' => 10,
						'opacity'  => false,
					),
				);
			}

			return $options;
		}

	}
endif;
new Blogshammir_Customizer_Category_Colors();


