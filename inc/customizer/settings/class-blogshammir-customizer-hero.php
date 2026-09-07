<?php
/**
 * Blogshammir Hero Section Settings section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Hero' ) ) :
	/**
	 * Blogshammir Page Title Settings section in Customizer.
	 */
	class Blogshammir_Customizer_Hero {

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

			// Hero Section.
			$options['section']['blogshammir_section_hero'] = array(
				'title'    => esc_html__( 'Hero', 'blogshammir' ),
				'priority' => 4,
			);

			// Hero enable.
			$options['setting']['blogshammir_enable_hero'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'    => 'blogshammir-toggle',
					'section' => 'blogshammir_section_hero',
					'label'   => esc_html__( 'Enable Hero Section', 'blogshammir' ),
				),
			);

			// Hero display on.
			$options['setting']['blogshammir_hero_enable_on'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_no_sanitize',
				'control'           => array(
					'type'        => 'blogshammir-checkbox-group',
					'label'       => esc_html__( 'Enable On: ', 'blogshammir' ),
					'description' => esc_html__( 'Choose on which pages you want to enable Hero. ', 'blogshammir' ),
					'section'     => 'blogshammir_section_hero',
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
							'control'  => 'blogshammir_enable_hero',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Hero Type.
			$options['setting']['blogshammir_hero_type'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'section'     => 'blogshammir_section_hero',
					'label'       => esc_html__( 'Type', 'blogshammir' ),
					'description' => esc_html__( 'Choose hero style type.', 'blogshammir' ),
					'choices'     => array(
						'horizontal-slider' => esc_html__( 'Slider Horizontal', 'blogshammir' ),
					),
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_hero',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Post Settings heading.
			$options['setting']['blogshammir_hero_slider_posts'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'     => 'blogshammir-heading',
					'section'  => 'blogshammir_section_hero',
					'label'    => esc_html__( 'Post Settings', 'blogshammir' ),
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_hero',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Post count.
			$options['setting']['blogshammir_hero_slider_post_number'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_range',
				'control'           => array(
					'type'        => 'blogshammir-range',
					'section'     => 'blogshammir_section_hero',
					'label'       => esc_html__( 'Post Number', 'blogshammir' ),
					'description' => esc_html__( 'Set the number of visible posts.', 'blogshammir' ),
					'min'         => 1,
					'max'         => 50,
					'step'        => 1,
					'unit'        => '',
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_hero',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_hero_slider_posts',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
				'partial'           => array(
					'selector'            => '#hero',
					'render_callback'     => 'blogshammir_blog_hero',
					'container_inclusive' => true,
					'fallback_refresh'    => true,
				),
			);

			// Post category.
			$options['setting']['blogshammir_hero_slider_category'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'section'     => 'blogshammir_section_hero',
					'label'       => esc_html__( 'Category', 'blogshammir' ),
					'description' => esc_html__( 'Display posts from selected category only. Leave empty to include all.', 'blogshammir' ),
					'is_select2'  => true,
					'data_source' => 'category',
					'multiple'    => true,
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_hero',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_hero_slider_posts',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Hero Slider heading.
			$options['setting']['blogshammir_hero_slider'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'     => 'blogshammir-heading',
					'section'  => 'blogshammir_section_hero',
					'label'    => esc_html__( 'Style', 'blogshammir' ),
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_hero',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Hero Slider Elements.
			$options['setting']['blogshammir_hero_slider_elements'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_sortable',
				'control'           => array(
					'type'        => 'blogshammir-sortable',
					'section'     => 'blogshammir_section_hero',
					'label'       => esc_html__( 'Post Elements', 'blogshammir' ),
					'description' => esc_html__( 'Set order and visibility for post elements.', 'blogshammir' ),
					'sortable'    => false,
					'choices'     => array(
						'category'  => esc_html__( 'Categories', 'blogshammir' ),
						'meta'      => esc_html__( 'Post Details', 'blogshammir' ),
						'read_more' => esc_html__( 'Continue Reading', 'blogshammir' ),
					),
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_hero',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_hero_slider',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
				'partial'           => array(
					'selector'            => '#hero',
					'render_callback'     => 'blogshammir_blog_hero',
					'container_inclusive' => true,
					'fallback_refresh'    => true,
				),
			);

			// Hero Slider Meta/Post Details.
			$options['setting']['blogshammir_hero_entry_meta_elements'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_sortable',
				'control'           => array(
					'type'        => 'blogshammir-sortable',
					'section'     => 'blogshammir_section_hero',
					'label'       => esc_html__( 'Post Meta', 'blogshammir' ),
					'description' => esc_html__( 'Set order and visibility for post meta details.', 'blogshammir' ),
					'choices'     => array(
						'author'   => esc_html__( 'Author', 'blogshammir' ),
						'date'     => esc_html__( 'Publish Date', 'blogshammir' ),
						'comments' => esc_html__( 'Comments', 'blogshammir' ),
					),
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_hero',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_hero_slider',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
				'partial'           => array(
					'selector'            => '#hero',
					'render_callback'     => 'blogshammir_blog_hero',
					'container_inclusive' => true,
					'fallback_refresh'    => true,
				),
			);

			// Continue Reading.
			$options['setting']['blogshammir_hero_slider_read_more'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
				'control'           => array(
					'type'        => 'blogshammir-text',
					'section'     => 'blogshammir_section_hero',
					'label'       => esc_html__( 'Continue Reading', 'blogshammir' ),
					'description' => esc_html__( 'Change Continue Reading Text.', 'blogshammir' ),
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_hero',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_hero_slider',
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
new Blogshammir_Customizer_Hero();


