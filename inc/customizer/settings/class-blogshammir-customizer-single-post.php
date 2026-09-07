<?php
/**
 * Blogshammir Blog - Single Post section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Single_Post' ) ) :
	/**
	 * Blogshammir Blog - Single Post section in Customizer.
	 */
	class Blogshammir_Customizer_Single_Post {

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
			$options['section']['blogshammir_section_blog_single_post'] = array(
				'title'    => esc_html__( 'Single Post', 'blogshammir' ),
				'panel'    => 'blogshammir_panel_blog',
				'priority' => 20,
			);

			$options['setting']['blogshammir_single_post_elements'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_sortable',
				'control'           => array(
					'type'        => 'blogshammir-sortable',
					'section'     => 'blogshammir_section_blog_single_post',
					'label'       => esc_html__( 'Post Elements', 'blogshammir' ),
					'description' => esc_html__( 'Set visibility of post elements.', 'blogshammir' ),
					'sortable'    => false,
					'choices'     => array(
						'thumb'          => esc_html__( 'Featured Image', 'blogshammir' ),
						'category'       => esc_html__( 'Post Categories', 'blogshammir' ),
						'tags'           => esc_html__( 'Post Tags', 'blogshammir' ),
						'last-updated'   => esc_html__( 'Last Updated Date', 'blogshammir' ),
						'about-author'   => esc_html__( 'About Author Box', 'blogshammir' ),
						'prev-next-post' => esc_html__( 'Next/Prev Post Links', 'blogshammir' ),
					),
				),
			);

			// Meta/Post Details Layout.
			$options['setting']['blogshammir_single_post_meta_elements'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_sortable',
				'control'           => array(
					'type'        => 'blogshammir-sortable',
					'label'       => esc_html__( 'Post Meta', 'blogshammir' ),
					'description' => esc_html__( 'Set order and visibility for post meta details.', 'blogshammir' ),
					'section'     => 'blogshammir_section_blog_single_post',
					'choices'     => array(
						'author'   => esc_html__( 'Author', 'blogshammir' ),
						'date'     => esc_html__( 'Publish Date', 'blogshammir' ),
						'comments' => esc_html__( 'Comments', 'blogshammir' ),
						'category' => esc_html__( 'Categories', 'blogshammir' ),
					),
				),
			);

			// Meta icons.
			$options['setting']['blogshammir_single_entry_meta_icons'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'    => 'blogshammir-toggle',
					'section' => 'blogshammir_section_blog_single_post',
					'label'   => esc_html__( 'Show avatar and icons in post meta', 'blogshammir' ),
				),
			);

			// Toggle Comments.
			$options['setting']['blogshammir_single_toggle_comments'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Show Toggle Comments', 'blogshammir' ),
					'description' => esc_html__( 'Hide comments and comment form behind a toggle button. ', 'blogshammir' ),
					'section'     => 'blogshammir_section_blog_single_post',
				),
			);

			// Enable related posts.
			$options['setting']['blogshammir_related_posts_enable'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'     => 'blogshammir-toggle',
					'label'    => esc_html__( 'Related posts', 'blogshammir' ),
					'section'  => 'blogshammir_section_blog_single_post',
				),
			);

			return $options;
		}
	}
endif;
new Blogshammir_Customizer_Single_Post();


