<?php
/**
 * Blogshammir Customizer helper functions.
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

/**
 * Returns array of available widgets.
 *
 * @since 1.0.0
 * @return array, $widgets array of available widgets.
 */
function blogshammir_get_customizer_widgets() {

	$widgets = array(
		'text'           => 'Blogshammir_Customizer_Widget_Text',
		'advertisements' => 'Blogshammir_Customizer_Widget_Advertisements',
		'nav'            => 'Blogshammir_Customizer_Widget_Nav',
		'socials'        => 'Blogshammir_Customizer_Widget_Socials',
		'search'         => 'Blogshammir_Customizer_Widget_Search',
		'darkmode'       => 'Blogshammir_Customizer_Widget_Darkmode',
		'button'         => 'Blogshammir_Customizer_Widget_Button',
	);

	return apply_filters( 'blogshammir_customizer_widgets', $widgets );
}

/**
 * Get choices for "Hide on" customizer options.
 *
 * @since  1.0.0
 * @return array
 */
function blogshammir_get_display_choices() {

	// Default options.
	$return = array(
		'home'       => array(
			'title' => esc_html__( 'Home Page', 'blogshammir' ),
		),
		'posts_page' => array(
			'title' => esc_html__( 'Blog / Posts Page', 'blogshammir' ),
		),
		'search'     => array(
			'title' => esc_html__( 'Search', 'blogshammir' ),
		),
		'archive'    => array(
			'title' => esc_html__( 'Archive', 'blogshammir' ),
			'desc'  => esc_html__( 'Dynamic pages such as categories, tags, custom taxonomies...', 'blogshammir' ),
		),
		'post'       => array(
			'title' => esc_html__( 'Single Post', 'blogshammir' ),
		),
		'page'       => array(
			'title' => esc_html__( 'Single Page', 'blogshammir' ),
		),
	);

	// Get additionally registered post types.
	$post_types = get_post_types(
		array(
			'public'   => true,
			'_builtin' => false,
		),
		'objects'
	);

	if ( is_array( $post_types ) && ! empty( $post_types ) ) {
		foreach ( $post_types as $slug => $post_type ) {
			$return[ $slug ] = array(
				'title' => $post_type->label,
			);
		}
	}

	return apply_filters( 'blogshammir_display_choices', $return );
}

/**
 * Get device choices for "Display on" customizer options.
 *
 * @since  1.0.0
 * @return array
 */
function blogshammir_get_device_choices() {

	// Default options.
	$return = array(
		'desktop' => array(
			'title' => esc_html__( 'Hide On Desktop', 'blogshammir' ),
		),
		'tablet'  => array(
			'title' => esc_html__( 'Hide On Tablet', 'blogshammir' ),
		),
		'mobile'  => array(
			'title' => esc_html__( 'Hide On Mobile', 'blogshammir' ),
		),
	);

	return apply_filters( 'blogshammir_device_choices', $return );
}


