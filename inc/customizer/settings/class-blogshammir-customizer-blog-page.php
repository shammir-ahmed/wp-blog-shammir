<?php
/**
 * Blogshammir Blog Â» Blog Page / Archive section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Blog_Page' ) ) :
	/**
	 * Blogshammir Blog Â» Blog Page / Archive section in Customizer.
	 */
	class Blogshammir_Customizer_Blog_Page {

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
			$options['section']['blogshammir_section_blog_page'] = array(
				'title' => esc_html__( 'Blog Page / Archive', 'blogshammir' ),
				'panel' => 'blogshammir_panel_blog',
			);

			// Layout.
			$options['setting']['blogshammir_blog_layout'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'label'       => esc_html__( 'Layout', 'blogshammir' ),
					'description' => esc_html__( 'Choose blog layout.', 'blogshammir' ),
					'section'     => 'blogshammir_section_blog_page',
					'choices'     => array(
						'blog-horizontal' => esc_html__( 'Horizontal', 'blogshammir' ),
					),
				),
			);

			$_image_sizes = blogshammir_get_image_sizes();
			$size_choices = array();

			if ( ! empty( $_image_sizes ) ) {
				foreach ( $_image_sizes as $key => $value ) {
					$name = ucwords( str_replace( array( '-', '_' ), ' ', $key ) );

					$size_choices[ $key ] = $name;

					if ( $value['width'] || $value['height'] ) {
						$size_choices[ $key ] .= ' (' . $value['width'] . 'x' . $value['height'] . ')';
					}
				}
			}

			// Featured Image Size.
			$options['setting']['blogshammir_blog_image_size'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'    => 'blogshammir-select',
					'label'   => esc_html__( 'Featured Image Size', 'blogshammir' ),
					'section' => 'blogshammir_section_blog_page',
					'choices' => $size_choices,
				),
			);

			// Read more.
			$options['setting']['blogshammir_blog_read_more'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
				'control'           => array(
					'type'        => 'blogshammir-text',
					'section'     => 'blogshammir_section_blog_page',
					'label'       => esc_html__( 'Read More', 'blogshammir' ),
					'description' => esc_html__( 'Change Read More Text.', 'blogshammir' ),
				),
			);

			// Meta/Post Details Layout.
			$options['setting']['blogshammir_blog_entry_meta_elements'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_sortable',
				'control'           => array(
					'type'        => 'blogshammir-sortable',
					'section'     => 'blogshammir_section_blog_page',
					'label'       => esc_html__( 'Post Meta', 'blogshammir' ),
					'description' => esc_html__( 'Set order and visibility for post meta details.', 'blogshammir' ),
					'choices'     => array(
						'author'   => esc_html__( 'Author', 'blogshammir' ),
						'date'     => esc_html__( 'Publish Date', 'blogshammir' ),
						'comments' => esc_html__( 'Comments', 'blogshammir' ),
						'tag'      => esc_html__( 'Tags', 'blogshammir' ),
					),
				),
			);

			// Post Categories.
			$options['setting']['blogshammir_blog_horizontal_post_categories'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Show Post Categories', 'blogshammir' ),
					'description' => esc_html__( 'A list of categories the post belongs to. Displayed above post title.', 'blogshammir' ),
					'section'     => 'blogshammir_section_blog_page',
					'required'    => array(
						array(
							'control'  => 'blogshammir_blog_layout',
							'value'    => 'blog-horizontal',
							'operator' => '==',
						),
					),
				),
			);

			// Read More Button.
			$options['setting']['blogshammir_blog_horizontal_read_more'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'     => 'blogshammir-toggle',
					'label'    => esc_html__( 'Show Read More Button', 'blogshammir' ),
					'section'  => 'blogshammir_section_blog_page',
					'required' => array(
						array(
							'control'  => 'blogshammir_blog_layout',
							'value'    => 'blog-horizontal',
							'operator' => '==',
						),
					),
				),
			);

			// Meta Author image.
			$options['setting']['blogshammir_entry_meta_icons'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'    => 'blogshammir-toggle',
					'section' => 'blogshammir_section_blog_page',
					'label'   => esc_html__( 'Show avatar and icons in post meta', 'blogshammir' ),
				),
			);

			// Excerpt Length.
			$options['setting']['blogshammir_excerpt_length'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_range',
				'control'           => array(
					'type'        => 'blogshammir-range',
					'section'     => 'blogshammir_section_blog_page',
					'label'       => esc_html__( 'Excerpt Length', 'blogshammir' ),
					'description' => esc_html__( 'Number of words displayed in the excerpt.', 'blogshammir' ),
					'min'         => 0,
					'max'         => 100,
					'step'        => 1,
					'unit'        => '',
					'responsive'  => false,
				),
			);

			// Excerpt more.
			$options['setting']['blogshammir_excerpt_more'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
				'control'           => array(
					'type'        => 'blogshammir-text',
					'section'     => 'blogshammir_section_blog_page',
					'label'       => esc_html__( 'Excerpt More', 'blogshammir' ),
					'description' => esc_html__( 'What to append to excerpt if the text is cut.', 'blogshammir' ),
				),
			);

			return $options;
		}
	}
endif;

new Blogshammir_Customizer_Blog_Page();


