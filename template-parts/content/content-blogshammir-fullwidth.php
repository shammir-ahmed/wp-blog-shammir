<?php
/**
 * Template part for displaying content of Blogshammir Canvas [Fullwidth] page template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BlogShammir
 * @author Md Shammir Ahmed
 * @since   1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php blogshammir_schema_markup( 'article' ); ?>>
	<div class="entry-content blogshammir-entry blogshammir-fullwidth-entry">
		<?php
		do_action( 'blogshammir_before_page_content' );

		the_content();

		do_action( 'blogshammir_after_page_content' );
		?>
	</div><!-- END .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->


