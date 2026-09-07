<?php
/**
 * Blogshammir Featured Links Section Settings section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Featured_Links' ) ) :
	/**
	 * Blogshammir Page Title Settings section in Customizer.
	 */
	class Blogshammir_Customizer_Featured_Links {

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

			// Featured links Section.
			$options['section']['blogshammir_section_featured_links'] = array(
				'title'    => esc_html__( 'Featured Items', 'blogshammir' ),
				'priority' => 4,
			);

			// Featured links enable.
			$options['setting']['blogshammir_enable_featured_links'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'    => 'blogshammir-toggle',
					'section' => 'blogshammir_section_featured_links',
					'label'   => esc_html__( 'Enable featured items section', 'blogshammir' ),
				),
			);

			// Title.
			$options['setting']['blogshammir_featured_links_title'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
				'control'           => array(
					'type'     => 'blogshammir-text',
					'section'  => 'blogshammir_section_featured_links',
					'label'    => esc_html__( 'Title', 'blogshammir' ),
					'required' => array(
						array(
							'control'  => 'blogshammir_enable_featured_links',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			$options['setting']['blogshammir_featured_links'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_repeater_sanitize',
				'control'           => array(
					'type'         => 'blogshammir-repeater',
					'label'        => esc_html__( 'Featured Items', 'blogshammir' ),
					'section'      => 'blogshammir_section_featured_links',
					'item_name'    => esc_html__( 'Featured Link', 'blogshammir' ),
					'title_format' => esc_html__( '[live_title]', 'blogshammir' ), // [live_title]
					'add_text'     => esc_html__( 'Add new Feature', 'blogshammir' ),
					'max_item' => 999, // 3 Maximum item can add,
										'fields'       => array(
						'link'  => array(
							'title' => esc_html__( 'Select feature link', 'blogshammir' ),
							'type'  => 'link',
						),

						'image' => array(
							'title' => esc_html__( 'Image', 'blogshammir' ),
							'type'  => 'media',
						),
					),
					'required'     => array(
						array(
							'control'  => 'blogshammir_enable_featured_links',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
				'partial'           => array(
					'selector'            => '#featured_links',
					'render_callback'     => 'blogshammir_blog_featured_links',
					'container_inclusive' => true,
					'fallback_refresh'    => true,
				),
			);

			// Featured links display on.
			$options['setting']['blogshammir_featured_links_enable_on'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_no_sanitize',
				'control'           => array(
					'type'        => 'blogshammir-checkbox-group',
					'label'       => esc_html__( 'Enable On: ', 'blogshammir' ),
					'description' => esc_html__( 'Choose on which pages you want to enable Featured links. ', 'blogshammir' ),
					'section'     => 'blogshammir_section_featured_links',
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
							'control'  => 'blogshammir_enable_featured_links',
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
new Blogshammir_Customizer_Featured_Links();



