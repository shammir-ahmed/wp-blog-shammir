<?php
/**
 * Blogshammir Customizer sections and panels.
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

if ( ! class_exists( 'Blogshammir_Customizer_Sections' ) ) :
	/**
	 * Blogshammir Customizer sections and panels.
	 */
	class Blogshammir_Customizer_Sections {

		/**
		 * Primary class constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			/**
			 * Registers our custom panels in Customizer.
			 */
			add_filter( 'blogshammir_customizer_options', array( $this, 'register_panel' ) );
		}

		/**
		 * Registers our custom options in Customizer.
		 *
		 * @since 1.0.0
		 * @param array $options Array of customizer options.
		 */
		public function register_panel( $options ) {

			// Title - General Options
			$options['section']['blogshammir_section_general_group'] = array(
				'class'    => 'Blogshammir_Customizer_Control_Section_Group_Title',
				'title'    => esc_html__( 'General Options', 'blogshammir' ),
				'priority' => 1,
			);

			// General panel.
			$options['panel']['blogshammir_panel_general'] = array(
				'title'    => esc_html__( 'General Settings', 'blogshammir' ),
				'priority' => 2,
			);

			// Header panel.
			$options['panel']['blogshammir_panel_header'] = array(
				'title'    => esc_html__( 'Header', 'blogshammir' ),
				'priority' => 3,
			);

			// Footer panel.
			$options['panel']['blogshammir_panel_footer'] = array(
				'title'    => esc_html__( 'Footer', 'blogshammir' ),
				'priority' => 3,
			);

			// Blog settings.
			$options['panel']['blogshammir_panel_blog'] = array(
				'title'    => esc_html__( 'Blog', 'blogshammir' ),
				'priority' => 3,
			);

			// Title - Extra Options
			$options['section']['blogshammir_section_extra_group'] = array(
				'class'    => 'Blogshammir_Customizer_Control_Section_Group_Title',
				'title'    => esc_html__( 'Extra Options', 'blogshammir' ),
				'priority' => 4,
			);

			// Title - Core
			$options['section']['blogshammir_section_core_group'] = array(
				'class'    => 'Blogshammir_Customizer_Control_Section_Group_Title',
				'title'    => esc_html__( 'Core', 'blogshammir' ),
				'priority' => 7,
			);

			return $options;
		}
	}
endif;
new Blogshammir_Customizer_Sections();


