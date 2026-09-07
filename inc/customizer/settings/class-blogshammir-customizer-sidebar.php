<?php
/**
 * Blogshammir Sidebar section in Customizer.
 *
 * @package BlogShammir
 * @author Md Shammir Ahmed
 * @since   1.0.0
 */

/**
 * Do not allow direct script access.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Blogshammir_Customizer_Sidebar' ) ) :

	/**
	 * Blogshammir Sidebar section in Customizer.
	 */
	class Blogshammir_Customizer_Sidebar {

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
			$options['section']['blogshammir_section_sidebar'] = array(
				'title'    => esc_html__( 'Sidebar', 'blogshammir' ),
				'priority' => 3,
			);

			// Default sidebar position.
			$options['setting']['blogshammir_sidebar_position'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'section'     => 'blogshammir_section_sidebar',
					'label'       => esc_html__( 'Default Position', 'blogshammir' ),
					'description' => esc_html__( 'Choose default sidebar position layout. You can change this setting per page via metabox settings.', 'blogshammir' ),
					'choices'     => array(
						'no-sidebar'    => esc_html__( 'No Sidebar', 'blogshammir' ),
						'left-sidebar'  => esc_html__( 'Left Sidebar', 'blogshammir' ),
						'right-sidebar' => esc_html__( 'Right Sidebar', 'blogshammir' ),
					),
				),
			);

			// Single post sidebar position.
			$options['setting']['blogshammir_single_post_sidebar_position'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'label'       => esc_html__( 'Single Post', 'blogshammir' ),
					'description' => esc_html__( 'Choose default sidebar position layout for single posts. You can change this setting per post via metabox settings.', 'blogshammir' ),
					'section'     => 'blogshammir_section_sidebar',
					'choices'     => array(
						'default'       => esc_html__( 'Default', 'blogshammir' ),
						'no-sidebar'    => esc_html__( 'No Sidebar', 'blogshammir' ),
						'left-sidebar'  => esc_html__( 'Left Sidebar', 'blogshammir' ),
						'right-sidebar' => esc_html__( 'Right Sidebar', 'blogshammir' ),
					),
				),
			);

			// Single page sidebar position.
			$options['setting']['blogshammir_single_page_sidebar_position'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'label'       => esc_html__( 'Page', 'blogshammir' ),
					'description' => esc_html__( 'Choose default sidebar position layout for pages. You can change this setting per page via metabox settings.', 'blogshammir' ),
					'section'     => 'blogshammir_section_sidebar',
					'choices'     => array(
						'default'       => esc_html__( 'Default', 'blogshammir' ),
						'no-sidebar'    => esc_html__( 'No Sidebar', 'blogshammir' ),
						'left-sidebar'  => esc_html__( 'Left Sidebar', 'blogshammir' ),
						'right-sidebar' => esc_html__( 'Right Sidebar', 'blogshammir' ),
					),
				),
			);

			// Archive sidebar position.
			$options['setting']['blogshammir_archive_sidebar_position'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'label'       => esc_html__( 'Archives & Search', 'blogshammir' ),
					'description' => esc_html__( 'Choose default sidebar position layout for archives and search results.', 'blogshammir' ),
					'section'     => 'blogshammir_section_sidebar',
					'choices'     => array(
						'default'       => esc_html__( 'Default', 'blogshammir' ),
						'no-sidebar'    => esc_html__( 'No Sidebar', 'blogshammir' ),
						'left-sidebar'  => esc_html__( 'Left Sidebar', 'blogshammir' ),
						'right-sidebar' => esc_html__( 'Right Sidebar', 'blogshammir' ),
					),
				),
			);

			// Sidebar options heading.
			$options['setting']['blogshammir_sidebar_options_heading'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'    => 'blogshammir-heading',
					'label'   => esc_html__( 'Options', 'blogshammir' ),
					'section' => 'blogshammir_section_sidebar',
				),
			);

			// Sidebar width.
			$options['setting']['blogshammir_sidebar_width'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_range',
				'control'           => array(
					'type'        => 'blogshammir-range',
					'section'     => 'blogshammir_section_sidebar',
					'label'       => esc_html__( 'Sidebar Width', 'blogshammir' ),
					'description' => esc_html__( 'Change your sidebar width.', 'blogshammir' ),
					'min'         => 15,
					'max'         => 50,
					'step'        => 1,
					'unit'        => '%',
					'required'    => array(
						array(
							'control'  => 'blogshammir_sidebar_options_heading',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Sticky sidebar.
			$options['setting']['blogshammir_sidebar_sticky'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'section'     => 'blogshammir_section_sidebar',
					'label'       => esc_html__( 'Sticky Sidebar', 'blogshammir' ),
					'description' => esc_html__( 'Stick sidebar when scrolling.', 'blogshammir' ),
					'choices'     => array(
						''        => esc_html__( 'Disable', 'blogshammir' ),
						'sidebar' => esc_html__( 'Stick first widget', 'blogshammir' ),
					),
					'required'    => array(
						array(
							'control'  => 'blogshammir_sidebar_options_heading',
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

new Blogshammir_Customizer_Sidebar();


