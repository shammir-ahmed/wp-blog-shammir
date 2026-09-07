<?php
/**
 * Template for Single post
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BlogShammir
 * @author Md Shammir Ahmed
 * @since   1.0.0
 */

?>

<?php do_action( 'blogshammir_before_article' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blogshammir-article' ); ?><?php blogshammir_schema_markup( 'article' ); ?>>

	<?php
	if ( 'quote' === get_post_format() ) {
		get_template_part( 'template-parts/entry/format/media', 'quote' );
	}

	$blogshammir_single_post_elements = blogshammir_get_single_post_elements();

	if ( ! empty( $blogshammir_single_post_elements ) ) {
		foreach ( $blogshammir_single_post_elements as $blogshammir_element ) {

			if ( 'content' === $blogshammir_element ) {
				do_action( 'blogshammir_before_single_content', 'before_post_content' );
				get_template_part( 'template-parts/entry/entry', $blogshammir_element );
				do_action( 'blogshammir_after_single_content', 'after_post_content' );
			} else {
				get_template_part( 'template-parts/entry/entry', $blogshammir_element );
			}
		}
	}
	?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'blogshammir_after_article' ); ?>


