<?php
/**
 * Blogshammir Main Footer section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Main_Footer' ) ) :
	/**
	 * Blogshammir Main Footer section in Customizer.
	 */
	class Blogshammir_Customizer_Main_Footer {

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
			$options['section']['blogshammir_section_main_footer'] = array(
				'title'    => esc_html__( 'Main Footer', 'blogshammir' ),
				'panel'    => 'blogshammir_panel_footer',
				'priority' => 20,
			);

			// Enable Footer.
			$options['setting']['blogshammir_enable_footer'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'    => 'blogshammir-toggle',
					'label'   => esc_html__( 'Enable Main Footer', 'blogshammir' ),
					'section' => 'blogshammir_section_main_footer',
				),
			);

			// Footer Layout.
			$options['setting']['blogshammir_footer_layout'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-radio-image',
					'label'       => esc_html__( 'Column Layout', 'blogshammir' ),
					'description' => esc_html__( 'Choose your site&rsquo;s footer column layout.', 'blogshammir' ),
					'section'     => 'blogshammir_section_main_footer',
					'choices'     => array(
						'layout-2' => array(
							'image' => BLOGSHAMMIR_THEME_URI . '/inc/customizer/assets/images/footer-layout-2.svg',
							'title' => esc_html__( '1/3 + 1/3 + 1/3', 'blogshammir' ),
						),
						'layout-8' => array(
							'image' => BLOGSHAMMIR_THEME_URI . '/inc/customizer/assets/images/footer-layout-8.svg',
							'title' => esc_html__( '1', 'blogshammir' ),
						),
					),
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_footer',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
				'partial'           => array(
					'selector'            => '#blogshammir-footer-widgets',
					'render_callback'     => 'blogshammir_footer_widgets',
					'container_inclusive' => false,
					'fallback_refresh'    => true,
				),
			);

			// Center footer widgets..
			$options['setting']['blogshammir_footer_widgets_align_center'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'     => 'blogshammir-toggle',
					'label'    => esc_html__( 'Center Widget Content', 'blogshammir' ),
					'section'  => 'blogshammir_section_main_footer',
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_footer',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
				'partial'           => array(
					'selector'            => '#blogshammir-footer-widgets',
					'render_callback'     => 'blogshammir_footer_widgets',
					'container_inclusive' => false,
					'fallback_refresh'    => true,
				),
			);

			// Footer Design Options heading.
			$options['setting']['blogshammir_footer_heading_design_options'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'     => 'blogshammir-heading',
					'label'    => esc_html__( 'Design Options', 'blogshammir' ),
					'section'  => 'blogshammir_section_main_footer',
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_footer',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Footer Background.
			$options['setting']['blogshammir_footer_background'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_design_options',
				'control'           => array(
					'type'     => 'blogshammir-design-options',
					'label'    => esc_html__( 'Background', 'blogshammir' ),
					'section'  => 'blogshammir_section_main_footer',
					'display'  => array(
						'background' => array(
							'color'    => esc_html__( 'Solid Color', 'blogshammir' ),
							'gradient' => esc_html__( 'Gradient', 'blogshammir' ),
						),
					),
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_footer',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_footer_heading_design_options',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Footer Text Color.
			$options['setting']['blogshammir_footer_text_color'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_design_options',
				'control'           => array(
					'type'     => 'blogshammir-design-options',
					'label'    => esc_html__( 'Font Color', 'blogshammir' ),
					'section'  => 'blogshammir_section_main_footer',
					'display'  => array(
						'color' => array(
							'text-color'         => esc_html__( 'Text Color', 'blogshammir' ),
							'link-color'         => esc_html__( 'Link Color', 'blogshammir' ),
							'link-hover-color'   => esc_html__( 'Link Hover Color', 'blogshammir' ),
							'widget-title-color' => esc_html__( 'Widget Title Color', 'blogshammir' ),
						),
					),
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_footer',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_footer_heading_design_options',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Footer Border.
			$options['setting']['blogshammir_footer_border'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_design_options',
				'control'           => array(
					'type'     => 'blogshammir-design-options',
					'label'    => esc_html__( 'Border', 'blogshammir' ),
					'section'  => 'blogshammir_section_main_footer',
					'display'  => array(
						'border' => array(
							'style'     => esc_html__( 'Style', 'blogshammir' ),
							'color'     => esc_html__( 'Color', 'blogshammir' ),
							'width'     => esc_html__( 'Width (px)', 'blogshammir' ),
							'positions' => array(
								'top'    => esc_html__( 'Top', 'blogshammir' ),
								'bottom' => esc_html__( 'Bottom', 'blogshammir' ),
							),
						),
					),
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_footer',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_footer_heading_design_options',
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
new Blogshammir_Customizer_Main_Footer();


