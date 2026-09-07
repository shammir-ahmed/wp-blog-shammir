<?php
/**
 * Blogshammir Ticker section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Ticker' ) ) :
	/**
	 * Blogshammir Ticker section in Customizer.
	 */
	class Blogshammir_Customizer_Ticker {

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
			// Ticker News Section.
			$options['section']['blogshammir_section_ticker'] = array(
				'title'    => esc_html__( 'Ticker News', 'blogshammir' ),
				'priority' => 4,
			);

			// Ticker News enable.
			$options['setting']['blogshammir_enable_ticker'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'    => 'blogshammir-toggle',
					'section' => 'blogshammir_section_ticker',
					'label'   => esc_html__( 'Enable Ticker News Section', 'blogshammir' ),
				),
			);

			// Title.
			$options['setting']['blogshammir_ticker_title'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
				'control'           => array(
					'type'     => 'blogshammir-text',
					'section'  => 'blogshammir_section_ticker',
					'label'    => esc_html__( 'Title', 'blogshammir' ),
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_ticker',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Ticker News display on.
			$options['setting']['blogshammir_ticker_enable_on'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_no_sanitize',
				'control'           => array(
					'type'        => 'blogshammir-checkbox-group',
					'label'       => esc_html__( 'Enable On: ', 'blogshammir' ),
					'description' => esc_html__( 'Choose on which pages you want to enable Ticker News. ', 'blogshammir' ),
					'section'     => 'blogshammir_section_ticker',
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
							'control'  => 'blogshammir_enable_ticker',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Post Settings heading.
			$options['setting']['blogshammir_ticker_posts'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'     => 'blogshammir-heading',
					'section'  => 'blogshammir_section_ticker',
					'label'    => esc_html__( 'Post Settings', 'blogshammir' ),
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_ticker',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Post count.
			$options['setting']['blogshammir_ticker_post_number'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_range',
				'control'           => array(
					'type'        => 'blogshammir-range',
					'section'     => 'blogshammir_section_ticker',
					'label'       => esc_html__( 'Post Number', 'blogshammir' ),
					'description' => esc_html__( 'Set the number of visible posts.', 'blogshammir' ),
					'min'         => 1,
					'max'         => 500,
					'step'        => 1,
					'unit'        => '',
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_ticker',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_ticker_posts',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Post category.
			$options['setting']['blogshammir_ticker_category'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'section'     => 'blogshammir_section_ticker',
					'label'       => esc_html__( 'Category', 'blogshammir' ),
					'description' => esc_html__( 'Display posts from selected category only. Leave empty to include all.', 'blogshammir' ),
					'is_select2'  => true,
					'data_source' => 'category',
					'multiple'    => true,
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_ticker',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_ticker_posts',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Ticker Slider Elements.
			$options['setting']['blogshammir_ticker_elements'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'blogshammir_sanitize_sortable',
				'control'           => array(
					'type'        => 'blogshammir-sortable',
					'section'     => 'blogshammir_section_ticker',
					'label'       => esc_html__( 'Post Elements', 'blogshammir' ),
					'description' => esc_html__( 'Set order and visibility for post elements.', 'blogshammir' ),
					'sortable'    => false,
					'choices'     => array(
						// 'thumbnail' => esc_html__( 'Thumbnail', 'blogshammir' ),
						'meta' => esc_html__( 'Post Details', 'blogshammir' ),
					),
					'required'    => array(
						array(
							'control'  => 'blogshammir_enable_ticker',
							'value'    => true,
							'operator' => '==',
						),
						array(
							'control'  => 'blogshammir_ticker_posts',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
				'partial'           => array(
					'selector'            => '#ticker',
					'render_callback'     => 'blogshammir_blog_ticker',
					'container_inclusive' => true,
					'fallback_refresh'    => true,
				),
			);

			return $options;
		}
	}
endif;
new Blogshammir_Customizer_Ticker();


