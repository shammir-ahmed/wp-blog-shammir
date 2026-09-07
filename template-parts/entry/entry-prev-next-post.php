<?php
/**
 * Template part for displaying Previous/Next Post section.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

// Do not show if post is password protected.
if ( post_password_required() ) {
	return;
}

$blogshammir_next_post = get_next_post();
$blogshammir_prev_post = get_previous_post();

// Return if there are no other posts.
if ( empty( $blogshammir_next_post ) && empty( $blogshammir_prev_post ) ) {
	return;
}
?>

<?php do_action( 'blogshammir_entry_before_prev_next_posts' ); ?>
<section class="post-nav" role="navigation">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'blogshammir' ); ?></h2>

	<?php

	// Previous post link.
	previous_post_link(
		'<div class="nav-previous"><h6 class="nav-title">' . wp_kses( __( 'Previous Post', 'blogshammir' ), blogshammir_get_allowed_html_tags( 'button' ) ) . '</h6>%link</div>',
		sprintf(
			'<div class="nav-content">%1$s <span>%2$s</span></div>',
			blogshammir_get_post_thumbnail( $blogshammir_prev_post, array( 75, 75 ) ),
			'%title'
		)
	);

	// Next post link.
	next_post_link(
		'<div class="nav-next"><h6 class="nav-title">' . wp_kses( __( 'Next Post', 'blogshammir' ), blogshammir_get_allowed_html_tags( 'button' ) ) . '</h6>%link</div>',
		sprintf(
			'<div class="nav-content"><span>%2$s</span> %1$s</div>',
			blogshammir_get_post_thumbnail( $blogshammir_next_post, array( 75, 75 ) ),
			'%title'
		)
	);

	?>

</section>
<?php do_action( 'blogshammir_entry_after_prev_next_posts' ); ?>


