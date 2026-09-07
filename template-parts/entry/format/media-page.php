<?php
/**
 * Template part for displaying page featured image.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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

// Get default post media.
$blogshammir_media = blogshammir_get_post_media( '' );

if ( ! $blogshammir_media || post_password_required() ) {
	return;
}

$blogshammir_media = apply_filters( 'blogshammir_post_thumbnail', $blogshammir_media, get_the_ID() );

$blogshammir_classes = array( 'post-thumb', 'entry-media', 'thumbnail' );

$blogshammir_classes = apply_filters( 'blogshammir_post_thumbnail_wrapper_classes', $blogshammir_classes, get_the_ID() );
$blogshammir_classes = trim( implode( ' ', array_unique( $blogshammir_classes ) ) );

// Print the post thumbnail.
echo wp_kses_post(
	sprintf(
		'<div class="%2$s">%1$s</div>',
		$blogshammir_media,
		esc_attr( $blogshammir_classes )
	)
);


