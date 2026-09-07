<?php
/**
 * Blogshammir Breadcrumbs Settings section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Breadcrumbs' ) ) :
	/**
	 * Blogshammir Breadcrumbs Settings section in Customizer.
	 */
	class Blogshammir_Customizer_Breadcrumbs {

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

			// Main Navigation Section.
			$options['section']['blogshammir_section_breadcrumbs'] = array(
				'title'    => esc_html__( 'Breadcrumbs', 'blogshammir' ),
				'panel'    => 'blogshammir_panel_header',
				'priority' => 70,
			);

			// Breadcrumbs.
			$options['setting']['blogshammir_breadcrumbs_enable'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'    => 'blogshammir-toggle',
					'label'   => esc_html__( 'Enable Breadcrumbs', 'blogshammir' ),
					'section' => 'blogshammir_section_breadcrumbs',
				),
			);

			// Hide breadcrumbs on.
			$options['setting']['blogshammir_breadcrumbs_hide_on'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_no_sanitize',
				'control'           => array(
					'type'        => 'blogshammir-checkbox-group',
					'label'       => esc_html__( 'Disable On: ', 'blogshammir' ),
					'description' => esc_html__( 'Choose on which pages you want to disable breadcrumbs. ', 'blogshammir' ),
					'section'     => 'blogshammir_section_breadcrumbs',
					'choices'     => blogshammir_get_display_choices(),
					'required'    => array(
						array(
							'control'  => 'blogshammir_breadcrumbs_enable',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Spacing.
			$options['setting']['blogshammir_breadcrumbs_spacing'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_responsive',
				'control'           => array(
					'type'        => 'blogshammir-spacing',
					'label'       => esc_html__( 'Spacing', 'blogshammir' ),
					'description' => esc_html__( 'Specify top and bottom padding.', 'blogshammir' ),
					'section'     => 'blogshammir_section_breadcrumbs',
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
							'control'  => 'blogshammir_breadcrumbs_enable',
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
new Blogshammir_Customizer_Breadcrumbs();


