<?php
/**
 * Template part for displaying entry thumbnail (featured image).
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

// Get default post media.
$blogshammir_media = blogshammir_get_post_media( '' );

if ( ! $blogshammir_media || post_password_required() ) {
	return;
}

$blogshammir_post_format = get_post_format();

// Wrap with link for non-singular pages.
if ( 'link' === $blogshammir_post_format || ! is_single( get_the_ID() ) ) {

	$blogshammir_icon = '';

	if ( is_sticky() ) {
		$blogshammir_icon = sprintf(
			'<span class="entry-media-icon is_sticky" title="%1$s" aria-hidden="true"><span class="entry-media-icon-wrapper">%2$s%3$s</span></span>',
			esc_attr__( 'Featured', 'blogshammir' ),
			blogshammir()->icons->get_svg(
				'pin',
				array(
					'class'       => 'top-icon',
					'aria-hidden' => 'true',
				)
			),
			blogshammir()->icons->get_svg( 'pin', array( 'aria-hidden' => 'true' ) )
		);
	} elseif ( 'video' === $blogshammir_post_format ) {

		$blogshammir_icon = sprintf(
			'<span class="entry-media-icon" aria-hidden="true"><span class="entry-media-icon-wrapper">%1$s%2$s</span></span>',
			blogshammir()->icons->get_svg(
				'play-2',
				array(
					'class'       => 'top-icon',
					'aria-hidden' => 'true',
				)
			),
			blogshammir()->icons->get_svg( 'play-2', array( 'aria-hidden' => 'true' ) )
		);
	} elseif ( 'link' === $blogshammir_post_format ) {
		$blogshammir_icon = sprintf(
			'<span class="entry-media-icon" title="%1$s" aria-hidden="true"><span class="entry-media-icon-wrapper">%2$s%3$s</span></span>',
			esc_url( blogshammir_entry_get_permalink() ),
			blogshammir()->icons->get_svg(
				'external-link',
				array(
					'class'       => 'top-icon',
					'aria-hidden' => 'true',
				)
			),
			blogshammir()->icons->get_svg( 'external-link', array( 'aria-hidden' => 'true' ) )
		);
	}

	$blogshammir_icon = apply_filters( 'blogshammir_post_format_media_icon', $blogshammir_icon, $blogshammir_post_format );

	$blogshammir_media = sprintf(
		'<a href="%1$s" class="entry-image-link">%2$s%3$s</a>',
		esc_url( blogshammir_entry_get_permalink() ),
		$blogshammir_media,
		$blogshammir_icon
	);
}

$blogshammir_media = apply_filters( 'blogshammir_post_thumbnail', $blogshammir_media );

// Print the post thumbnail.
echo wp_kses(
	sprintf(
		'<div class="post-thumb entry-media thumbnail">%1$s</div>',
		$blogshammir_media
	),
	blogshammir_get_allowed_html_tags()
);


