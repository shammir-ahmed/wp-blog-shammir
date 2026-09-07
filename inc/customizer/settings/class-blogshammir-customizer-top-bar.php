<?php
/**
 * Blogshammir Top Bar Settings section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Top_Bar' ) ) :
	/**
	 * Blogshammir Top Bar Settings section in Customizer.
	 */
	class Blogshammir_Customizer_Top_Bar {

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
			$options['section']['blogshammir_section_top_bar'] = array(
				'title'    => esc_html__( 'Top Bar', 'blogshammir' ),
				'panel'    => 'blogshammir_panel_header',
				'priority' => 10,
			);

			// Enable Top Bar.
			$options['setting']['blogshammir_top_bar_enable'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Enable Top Bar', 'blogshammir' ),
					'description' => esc_html__( 'Top Bar is a section with widgets located above Main Header area.', 'blogshammir' ),
					'section'     => 'blogshammir_section_top_bar',
				),
			);

			// Top Bar widgets heading.
			$options['setting']['blogshammir_top_bar_heading_widgets'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-heading',
					'label'       => esc_html__( 'Top Bar Widgets', 'blogshammir' ),
					'description' => esc_html__( 'Click the Add Widget button to add available widgets to your Top Bar.', 'blogshammir' ),
					'section'     => 'blogshammir_section_top_bar',
					'required'    => array(
						array(
							'control'  => 'blogshammir_top_bar_enable',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Top Bar widgets.
			$options['setting']['blogshammir_top_bar_widgets'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_widget',
				'control'           => array(
					'type'       => 'blogshammir-widget',
					'label'      => esc_html__( 'Top Bar Widgets', 'blogshammir' ),
					'section'    => 'blogshammir_section_top_bar',
					'widgets'    => array(
						'text'    => array(
							'max_uses' => 2,
						),
						'nav'     => array(
							'max_uses' => 1,
						),
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
							'control'  => 'blogshammir_top_bar_heading_widgets',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_top_bar_enable',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
				'partial'           => array(
					'selector'            => '#blogshammir-topbar',
					'render_callback'     => 'blogshammir_topbar_output',
					'container_inclusive' => true,
					'fallback_refresh'    => true,
				),
			);

			// Top Bar design options heading.
			$options['setting']['blogshammir_top_bar_heading_design_options'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'     => 'blogshammir-heading',
					'label'    => esc_html__( 'Design Options', 'blogshammir' ),
					'section'  => 'blogshammir_section_top_bar',
					'required' => array(
						array(
							'control'  => 'blogshammir_top_bar_enable',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Top Bar Background.
			$options['setting']['blogshammir_top_bar_background'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_design_options',
				'control'           => array(
					'type'     => 'blogshammir-design-options',
					'label'    => esc_html__( 'Background', 'blogshammir' ),
					'section'  => 'blogshammir_section_top_bar',
					'display'  => array(
						'background' => array(
							'color'    => esc_html__( 'Solid Color', 'blogshammir' ),
							'gradient' => esc_html__( 'Gradient', 'blogshammir' ),
						),
					),
					'required' => array(
						array(
							'control'  => 'blogshammir_top_bar_enable',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_top_bar_heading_design_options',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Top Bar Text Color.
			$options['setting']['blogshammir_top_bar_text_color'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_design_options',
				'control'           => array(
					'type'     => 'blogshammir-design-options',
					'label'    => esc_html__( 'Font Color', 'blogshammir' ),
					'section'  => 'blogshammir_section_top_bar',
					'display'  => array(
						'color' => array(
							'text-color'       => esc_html__( 'Text Color', 'blogshammir' ),
							'link-color'       => esc_html__( 'Link Color', 'blogshammir' ),
							'link-hover-color' => esc_html__( 'Link Hover Color', 'blogshammir' ),
						),
					),
					'required' => array(
						array(
							'control'  => 'blogshammir_top_bar_enable',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_top_bar_heading_design_options',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			return $options;
		}
	}
endif;
new Blogshammir_Customizer_Top_Bar();


