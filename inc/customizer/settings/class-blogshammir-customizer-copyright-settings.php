<?php
/**
 * Blogshammir Copyright Bar section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Copyright_Settings' ) ) :
	/**
	 * Blogshammir Copyright Bar section in Customizer.
	 */
	class Blogshammir_Customizer_Copyright_Settings {

		/**
		 * Primary class constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Registers our custom options in Customizer.
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
			$options['section']['blogshammir_section_copyright_bar'] = array(
				'title'    => esc_html__( 'Copyright Bar', 'blogshammir' ),
				'priority' => 30,
				'panel'    => 'blogshammir_panel_footer',
			);

			// Enable Copyright Bar.
			$options['setting']['blogshammir_enable_copyright'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'    => 'blogshammir-toggle',
					'label'   => esc_html__( 'Enable Copyright Bar', 'blogshammir' ),
					'section' => 'blogshammir_section_copyright_bar',
				),
			);

			// Copyright Layout.
			$options['setting']['blogshammir_copyright_layout'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-radio-image',
					'section'     => 'blogshammir_section_copyright_bar',
					'label'       => esc_html__( 'Copyright Layout', 'blogshammir' ),
					'description' => esc_html__( 'Choose your site&rsquo;s copyright widgets layout.', 'blogshammir' ),
					'choices'     => array(
						'layout-1' => array(
							'image' => BLOGSHAMMIR_THEME_URI . '/inc/customizer/assets/images/copyright-layout-1.svg',
							'title' => esc_html__( 'Centered', 'blogshammir' ),
						),
					),
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_copyright',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Copyright widgets heading.
			$options['setting']['blogshammir_copyright_heading_widgets'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-heading',
					'section'     => 'blogshammir_section_copyright_bar',
					'label'       => esc_html__( 'Copyright Bar Widgets', 'blogshammir' ),
					'description' => esc_html__( 'Click the Add Widget button to add available widgets to your Copyright Bar.', 'blogshammir' ),
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_copyright',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Copyright widgets.
			$options['setting']['blogshammir_copyright_widgets'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_widget',
				'control'           => array(
					'type'       => 'blogshammir-widget',
					'section'    => 'blogshammir_section_copyright_bar',
					'label'      => esc_html__( 'Copyright Bar Widgets', 'blogshammir' ),
					'widgets'    => array(
						'text'    => array(
							'max_uses' => 1,
						),
						'nav'     => array(
							'menu_location' => apply_filters( 'blogshammir_footer_menu_location', 'blogshammir-footer' ),
							'max_uses'      => 1,
						),
						'socials' => array(
							'max_uses' => 1,
							'styles'   => array(
								'minimal' => esc_html__( 'Minimal', 'blogshammir' ),
								'rounded' => esc_html__( 'Rounded', 'blogshammir' ),
							),
						),
					),
					'locations'  => array(
						'start' => esc_html__( 'Start', 'blogshammir' ),
						'end'   => esc_html__( 'End', 'blogshammir' ),
					),
					'visibility' => array(
						'all'                => esc_html__( 'Show on All Devices', 'blogshammir' ),
						'hide-mobile'        => esc_html__( 'Hide on Mobile', 'blogshammir' ),
						'hide-tablet'        => esc_html__( 'Hide on Tablet', 'blogshammir' ),
						'hide-mobile-tablet' => esc_html__( 'Hide on Mobile and Tablet', 'blogshammir' ),
					),
					'required'   => array(
						array(
							'control'  => 'blogshammir_copyright_heading_widgets',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_enable_copyright',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
				'partial'           => array(
					'selector'            => '#blogshammir-copyright',
					'render_callback'     => 'blogshammir_copyright_bar_output',
					'container_inclusive' => true,
					'fallback_refresh'    => true,
				),
			);

			return $options;
		}

	}
endif;
new Blogshammir_Customizer_Copyright_Settings();


