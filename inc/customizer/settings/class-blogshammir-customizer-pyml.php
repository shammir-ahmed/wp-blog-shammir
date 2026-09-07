<?php
/**
 * Blogshammir PYML section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_PYML' ) ) :
	/**
	 * Blogshammir PYML section in Customizer.
	 */
	class Blogshammir_Customizer_PYML {

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
			// Posts You Might Like Section.
			$options['section']['blogshammir_section_pyml'] = array(
				'title'    => esc_html__( 'Posts You Might Like', 'blogshammir' ),
				'priority' => 5,
			);

			// Posts You Might Like enable.
			$options['setting']['blogshammir_enable_pyml'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'    => 'blogshammir-toggle',
					'section' => 'blogshammir_section_pyml',
					'label'   => esc_html__( 'Enable Posts You Might Like Section', 'blogshammir' ),
				),
			);

			// Title.
			$options['setting']['blogshammir_pyml_title'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
				'control'           => array(
					'type'     => 'blogshammir-text',
					'section'  => 'blogshammir_section_pyml',
					'label'    => esc_html__( 'Title', 'blogshammir' ),
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_pyml',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Posts You Might Like display on.
			$options['setting']['blogshammir_pyml_enable_on'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_no_sanitize',
				'control'           => array(
					'type'        => 'blogshammir-checkbox-group',
					'label'       => esc_html__( 'Enable On: ', 'blogshammir' ),
					'description' => esc_html__( 'Choose on which pages you want to enable Posts You Might Like. ', 'blogshammir' ),
					'section'     => 'blogshammir_section_pyml',
					'choices'     => array(
						'home'       => array(
							'title' => esc_html__( 'Home Page', 'blogshammir' ),
						),
						'posts_page' => array(
							'title' => esc_html__( 'Blog / Posts Page', 'blogshammir' ),
						),
					),
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_pyml',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// PYML heading.
			$options['setting']['blogshammir_pyml_style'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'     => 'blogshammir-heading',
					'section'  => 'blogshammir_section_pyml',
					'label'    => esc_html__( 'Style', 'blogshammir' ),
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_pyml',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// PYML Elements.
			$options['setting']['blogshammir_pyml_elements'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_sortable',
				'control'           => array(
					'type'        => 'blogshammir-sortable',
					'section'     => 'blogshammir_section_pyml',
					'label'       => esc_html__( 'Post Elements', 'blogshammir' ),
					'description' => esc_html__( 'Set order and visibility for post elements.', 'blogshammir' ),
					'sortable'    => false,
					'choices'     => array(
						'category' => esc_html__( 'Categories', 'blogshammir' ),
						'meta'     => esc_html__( 'Post Details', 'blogshammir' ),
					),
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_pyml',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_pyml_style',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
				'partial'           => array(
					'selector'            => '#pyml',
					'render_callback'     => 'blogshammir_blog_pyml',
					'container_inclusive' => true,
					'fallback_refresh'    => true,
				),
			);

			// Post Settings heading.
			$options['setting']['blogshammir_pyml_posts'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'     => 'blogshammir-heading',
					'section'  => 'blogshammir_section_pyml',
					'label'    => esc_html__( 'Post Settings', 'blogshammir' ),
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_pyml',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Post count.
			$options['setting']['blogshammir_pyml_post_number'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_range',
				'control'           => array(
					'type'        => 'blogshammir-range',
					'section'     => 'blogshammir_section_pyml',
					'label'       => esc_html__( 'Post Number', 'blogshammir' ),
					'description' => esc_html__( 'Set the number of visible posts.', 'blogshammir' ),
					'min'         => 1,
					'max'         => 4,
					'step'        => 1,
					'unit'        => '',
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_pyml',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_pyml_posts',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
				'partial'           => array(
					'selector'            => '#pyml',
					'render_callback'     => 'blogshammir_blog_pyml',
					'container_inclusive' => true,
					'fallback_refresh'    => true,
				),
			);

			// Post category.
			$options['setting']['blogshammir_pyml_category'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'section'     => 'blogshammir_section_pyml',
					'label'       => esc_html__( 'Category', 'blogshammir' ),
					'description' => esc_html__( 'Display posts from selected category only. Leave empty to include all.', 'blogshammir' ),
					'is_select2'  => true,
					'data_source' => 'category',
					'multiple'    => true,
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_pyml',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_pyml_posts',
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
new Blogshammir_Customizer_PYML();


