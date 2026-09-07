<?php
/**
 * Blogshammir Main Header Settings section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Main_Header' ) ) :
	/**
	 * Blogshammir Main Header section in Customizer.
	 */
	class Blogshammir_Customizer_Main_Header {

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

			// Main Header Section.
			$options['section']['blogshammir_section_main_header'] = array(
				'title'    => esc_html__( 'Main Header', 'blogshammir' ),
				'panel'    => 'blogshammir_panel_header',
				'priority' => 20,
			);

			// Header Layout.
			$options['setting']['blogshammir_header_layout'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-radio-image',
					'label'       => esc_html__( 'Header Layout', 'blogshammir' ),
					'description' => esc_html__( 'Pre-defined positions of header elements, such as logo and navigation.', 'blogshammir' ),
					'section'     => 'blogshammir_section_main_header',
					'priority'    => 5,
					'choices'     => array(
						'layout-1' => array(
							'image' => BLOGSHAMMIR_THEME_URI . '/inc/customizer/assets/images/header-layout-1.svg',
							'title' => esc_html__( 'Header 1', 'blogshammir' ),
						),
					),
				),
			);

			// Header widgets heading.
			$options['setting']['blogshammir_header_heading_widgets'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-heading',
					'label'       => esc_html__( 'Header Widgets', 'blogshammir' ),
					'description' => esc_html__( 'Click the "Add Widget" button to add available widgets to your Header. Click the down arrow icon to expand widget options.', 'blogshammir' ),
					'section'     => 'blogshammir_section_main_header',
					'space'       => true,
				),
			);

			// Header widgets.
			$options['setting']['blogshammir_header_widgets'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_widget',
				'control'           => array(
					'type'       => 'blogshammir-widget',
					'label'      => esc_html__( 'Header Widgets', 'blogshammir' ),
					'section'    => 'blogshammir_section_main_header',
					'widgets'    => apply_filters(
						'blogshammir_main_header_widgets',
						array(
							'search'   => array(
								'max_uses' => 1,
							),
							'darkmode' => array(
								'max_uses' => 1,
							),
							'button'   => array(
								'max_uses' => 1,
							),
							'socials'  => array(
								'max_uses' => 1,
								'styles'   => array(
									'rounded-fill'   => esc_html__( 'Rounded Fill', 'blogshammir' ),
									'rounded-border' => esc_html__( 'Rounded Border', 'blogshammir' ),
								),
							),
						)
					),
					'locations'  => array(
						'left'  => esc_html__( 'Left', 'blogshammir' ),
						'right' => esc_html__( 'Right', 'blogshammir' ),
					),
					'visibility' => array(
						'all'                => esc_html__( 'Show on All Devices', 'blogshammir' ),
						'hide-mobile'        => esc_html__( 'Hide on Mobile', 'blogshammir' ),
						'hide-tablet'        => esc_html__( 'Hide on Tablet', 'blogshammir' ),
						'hide-mobile-tablet' => esc_html__( 'Hide on Mobile and Tablet', 'blogshammir' ),
					),
					'required'   => array(
						array(
							'control'  => 'blogshammir_header_heading_widgets',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
				'partial'           => array(
					'selector'            => '#blogshammir-header',
					'render_callback'     => 'blogshammir_header_content_output',
					'container_inclusive' => false,
					'fallback_refresh'    => true,
				),
			);

			return $options;
		}
	}
endif;
new Blogshammir_Customizer_Main_Header();


