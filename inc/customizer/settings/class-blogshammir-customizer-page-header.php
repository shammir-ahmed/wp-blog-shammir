<?php
/**
 * Blogshammir Page Title Settings section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Page_Header' ) ) :
	/**
	 * Blogshammir Page Title Settings section in Customizer.
	 */
	class Blogshammir_Customizer_Page_Header {

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

			// Page Title Section.
			$options['section']['blogshammir_section_page_header'] = array(
				'title'    => esc_html__( 'Page Header', 'blogshammir' ),
				'panel'    => 'blogshammir_panel_header',
				'priority' => 60,
			);

			// Page Header enable.
			$options['setting']['blogshammir_page_header_enable'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'    => 'blogshammir-toggle',
					'label'   => esc_html__( 'Enable Page Header', 'blogshammir' ),
					'section' => 'blogshammir_section_page_header',
				),
			);

			// Spacing.
			$options['setting']['blogshammir_page_header_spacing'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_responsive',
				'control'           => array(
					'type'        => 'blogshammir-spacing',
					'label'       => esc_html__( 'Page Title Spacing', 'blogshammir' ),
					'description' => esc_html__( 'Specify Page Title top and bottom padding.', 'blogshammir' ),
					'section'     => 'blogshammir_section_page_header',
					'choices'     => array(
						'top'    => esc_html__( 'Top', 'blogshammir' ),
						'bottom' => esc_html__( 'Bottom', 'blogshammir' ),
					),
					'responsive'  => true,
					'unit'        => array(
						'px',
					),
					'required'    => array(
						array(
							'control'  => 'blogshammir_page_header_enable',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Page Header design options heading.
			$options['setting']['blogshammir_page_header_heading_design'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'     => 'blogshammir-heading',
					'label'    => esc_html__( 'Design Options', 'blogshammir' ),
					'section'  => 'blogshammir_section_page_header',
					'required' => array(
						array(
							'control'  => 'blogshammir_page_header_enable',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Page Header background design.
			$options['setting']['blogshammir_page_header_background'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_design_options',
				'control'           => array(
					'type'     => 'blogshammir-design-options',
					'label'    => esc_html__( 'Background', 'blogshammir' ),
					'section'  => 'blogshammir_section_page_header',
					'display'  => array(
						'background' => array(
							'color'    => esc_html__( 'Solid Color', 'blogshammir' ),
							'gradient' => esc_html__( 'Gradient', 'blogshammir' ),
						),
					),
					'required' => array(
						array(
							'control'  => 'blogshammir_page_header_enable',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_page_header_heading_design',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Page Header Text Color.
			$options['setting']['blogshammir_page_header_text_color'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_design_options',
				'control'           => array(
					'type'     => 'blogshammir-design-options',
					'label'    => esc_html__( 'Font Color', 'blogshammir' ),
					'section'  => 'blogshammir_section_page_header',
					'display'  => array(
						'color' => array(
							'text-color'       => esc_html__( 'Text Color', 'blogshammir' ),
							'link-color'       => esc_html__( 'Link Color', 'blogshammir' ),
							'link-hover-color' => esc_html__( 'Link Hover Color', 'blogshammir' ),
						),
					),
					'required' => array(
						array(
							'control'  => 'blogshammir_page_header_enable',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_page_header_heading_design',
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
new Blogshammir_Customizer_Page_Header();


