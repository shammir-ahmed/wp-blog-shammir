<?php
/**
 * Template part for displaying post in post listing.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

?>

<?php do_action( 'blogshammir_before_article' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blogshammir-article' ); ?><?php blogshammir_schema_markup( 'article' ); ?>>

	<?php
	$blogshammir_blog_entry_format = get_post_format();

	if ( 'quote' === $blogshammir_blog_entry_format ) {
		get_template_part( 'template-parts/entry/format/media', $blogshammir_blog_entry_format );
	} else {

		$blogshammir_blog_entry_elements = blogshammir_get_blog_entry_elements();

		if ( ! empty( $blogshammir_blog_entry_elements ) ) {
			foreach ( $blogshammir_blog_entry_elements as $blogshammir_element ) {
				get_template_part( 'template-parts/entry/entry', $blogshammir_element );
			}
		}
	}
	?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'blogshammir_after_article' ); ?>


