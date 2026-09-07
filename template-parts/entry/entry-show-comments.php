<?php
/**
 * Template part for displaying â€Show Commentsâ€ button.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

// Do not show if the post is password protected.
if ( post_password_required() ) {
	return;
}

$blogshammir_comment_count = get_comments_number();
$blogshammir_comment_title = esc_html__( 'Leave a Comment', 'blogshammir' );

if ( $blogshammir_comment_count > 0 ) {
	/* translators: %s is comment count */
	$blogshammir_comment_title = esc_html( sprintf( _n( 'Show %s Comment', 'Show %s Comments', $blogshammir_comment_count, 'blogshammir' ), $blogshammir_comment_count ) );
}

?>
<a href="#" id="blogshammir-comments-toggle" class="blogshammir-btn btn-large btn-fw btn-left-icon">
	<?php echo blogshammir()->icons->get_svg( 'chat' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<span><?php echo $blogshammir_comment_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
</a>


