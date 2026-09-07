<?php
/**
 * Template part for displaying entry footer.
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

?>

<?php do_action( 'blogshammir_before_entry_footer' ); ?>
<footer class="entry-footer">
	<?php

	// Allow text to be filtered.
	$blogshammir_read_more_text = blogshammir_option( 'blog_read_more' );

	?>
	<a href="<?php echo esc_url( blogshammir_entry_get_permalink() ); ?>" class="blogshammir-btn btn-text-1"><span><?php echo esc_html( $blogshammir_read_more_text ); ?></span></a>
</footer>
<?php do_action( 'blogshammir_after_entry_footer' ); ?>


