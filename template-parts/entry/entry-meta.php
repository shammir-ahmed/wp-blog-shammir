<?php
/**
 * Template part for displaying entry meta info.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
 * Only show meta tags for posts.
 */
if ( ! in_array( get_post_type(), (array) apply_filters( 'blogshammir_entry_meta_post_type', array( 'post' ) ), true ) ) {
	return;
}

do_action( 'blogshammir_before_entry_meta' );

// Get meta items to be displayed.
$blogshammir_meta_elements = blogshammir_get_entry_meta_elements();

if ( isset( $args['blogshammir_meta_callback'] ) ) {
	$blogshammir_meta_elements = call_user_func( $args['blogshammir_meta_callback'] );
}

if ( ! empty( $blogshammir_meta_elements ) ) {

	echo '<div class="entry-meta"><div class="entry-meta-elements">';

	do_action( 'blogshammir_before_entry_meta_elements' );

	// Loop through meta items.
	foreach ( $blogshammir_meta_elements as $blogshammir_meta_item ) {

		// Call a template tag function.
		if ( function_exists( 'blogshammir_entry_meta_' . $blogshammir_meta_item ) ) {
			call_user_func( 'blogshammir_entry_meta_' . $blogshammir_meta_item );
		}
	}

	// Add edit post link.
	$blogshammir_edit_icon = blogshammir()->icons->get_meta_icon( 'edit', blogshammir()->icons->get_svg( 'edit-3', array( 'aria-hidden' => 'true' ) ) );

	blogshammir_edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				$blogshammir_edit_icon . __( 'Edit <span class="screen-reader-text">%s</span>', 'blogshammir' ),
				blogshammir_get_allowed_html_tags()
			),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);

	do_action( 'blogshammir_after_entry_meta_elements' );

	echo '</div></div>';
}

do_action( 'blogshammir_after_entry_meta' );


