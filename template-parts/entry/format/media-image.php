<?php
/**
 * Template part for displaying post format image entry.
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

$blogshammir_media = blogshammir_get_post_media( 'image' );

if ( ! $blogshammir_media || post_password_required() ) {
	return;
}

?>

<div class="post-thumb entry-media thumbnail">

	<?php
	if ( ! is_single( get_the_ID() ) ) {
		$blogshammir_media = sprintf(
			'<a href="%1$s" class="entry-image-link">%2$s</a>',
			esc_url( blogshammir_entry_get_permalink() ),
			$blogshammir_media
		);
	}

	echo $blogshammir_media; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	?>
</div>


