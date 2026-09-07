<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

/*
 * Return if comments are not meant to be displayed.
 */
if ( ! blogshammir_comments_displayed() ) {
	return;
}

?>
<?php do_action( 'blogshammir_before_comments' ); ?>
<section id="comments" class="comments-area">

	<div class="comments-title-wrapper center-text">
		<h3 class="comments-title">
			<?php

			// Get comments number.
			$blogshammir_comments_count = get_comments_number();

			if ( 0 === intval( $blogshammir_comments_count ) ) {
				$blogshammir_comments_title = esc_html__( 'Comments', 'blogshammir' );
			} else {
				/* translators: %s Comment number */
				$blogshammir_comments_title = sprintf( _n( '%s Comment', '%s Comments', $blogshammir_comments_count, 'blogshammir' ), number_format_i18n( $blogshammir_comments_count ) );
			}

			// Apply filters to the comments count.
			$blogshammir_comments_title = apply_filters( 'blogshammir_comments_count', $blogshammir_comments_title );

			echo wp_kses( $blogshammir_comments_title, blogshammir_get_allowed_html_tags() );
			?>
		</h3><!-- END .comments-title -->

		<?php
		if ( ! have_comments() ) {
			$blogshammir_no_comments_title = apply_filters( 'blogshammir_no_comments_text', esc_html__( 'No comments yet. Why don&rsquo;t you start the discussion?', 'blogshammir' ) );
			?>
			<p class="no-comments"><?php echo esc_html( $blogshammir_no_comments_title ); ?></p>
		<?php } ?>
	</div>

	<ol class="comment-list">
		<?php

		// List comments.
		wp_list_comments(
			array(
				'callback'    => 'blogshammir_comment',
				'avatar_size' => apply_filters( 'blogshammir_comment_avatar_size', 50 ),
				'reply_text'  => __( 'Reply', 'blogshammir' ),
			)
		);
		?>
	</ol>

	<?php
	// If comments are closed and there are comments, let's leave a note.
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="comments-closed center-text"><?php esc_html_e( 'Comments are closed', 'blogshammir' ); ?></p>
	<?php endif; ?>

	<?php
	the_comments_pagination(
		array(
			'prev_text' => '<span class="screen-reader-text">' . __( 'Previous', 'blogshammir' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'blogshammir' ) . '</span>',
		)
	);
	?>

	<?php
	comment_form(
		array(
			/* translators: %1$s opening anchor tag, %2$s closing anchor tag */
			'must_log_in'   => '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a comment.', 'blogshammir' ), '<a href="' . wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">', '</a>' ) . '</p>', // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			'logged_in_as'  => '<p class="logged-in-as">' . esc_html__( 'Logged in as', 'blogshammir' ) . ' <a href="' . esc_url( admin_url( 'profile.php' ) ) . '">' . $user_identity . '</a> <a href="' . wp_logout_url( get_permalink() ) . '" title="' . esc_html__( 'Log out of this account', 'blogshammir' ) . '">' . esc_html__( 'Log out?', 'blogshammir' ) . '</a></p>',
			'class_submit'  => 'blogshammir-btn primary-button',
			'comment_field' => '<p class="comment-textarea"><textarea name="comment" id="comment" cols="44" rows="8" class="textarea-comment" placeholder="' . esc_html__( 'Write a comment&hellip;', 'blogshammir' ) . '" required="required"></textarea></p>',
			'id_submit'     => 'comment-submit',
		)
	);
	?>

</section><!-- #comments -->
<?php do_action( 'blogshammir_after_comments' ); ?>


