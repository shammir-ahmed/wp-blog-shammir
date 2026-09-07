<?php
/**
 * Template part for displaying blog post - horizontal.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */
$class_no_media = ! has_post_thumbnail() ? 'no-entry-media' : '';
?>

<?php do_action( 'blogshammir_before_article' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'blogshammir-article', esc_attr( $class_no_media ) ) ); ?><?php blogshammir_schema_markup( 'article' ); ?>>

	<?php
	$blogshammir_blog_entry_format = get_post_format();

	if ( 'quote' === $blogshammir_blog_entry_format ) {
		get_template_part( 'template-parts/entry/format/media', $blogshammir_blog_entry_format );
	} else {

		$blogshammir_classes     = array();
		$blogshammir_classes[]   = 'blogshammir-blog-entry-wrapper';
		$blogshammir_thumb_align = blogshammir_option( 'blog_image_position' );
		$blogshammir_thumb_align = apply_filters( 'blogshammir_horizontal_blog_image_position', $blogshammir_thumb_align );
		$blogshammir_classes[]   = 'blogshammir-thumb-' . $blogshammir_thumb_align;
		$blogshammir_classes     = implode( ' ', $blogshammir_classes );
		?>

		<div class="<?php echo esc_attr( $blogshammir_classes ); ?>">
			<?php get_template_part( 'template-parts/entry/entry-thumbnail' ); ?>

			<div class="blogshammir-entry-content-wrapper">

				<?php
				if ( blogshammir_option( 'blog_horizontal_post_categories' ) ) {
					get_template_part( 'template-parts/entry/entry-category' );
				}

				get_template_part( 'template-parts/entry/entry-header' );
				get_template_part( 'template-parts/entry/entry-summary' );


				if ( blogshammir_option( 'blog_horizontal_read_more' ) ) {
					get_template_part( 'template-parts/entry/entry-summary-footer' );
				}

				get_template_part( 'template-parts/entry/entry-meta' );
				?>
			</div>
		</div>

	<?php } ?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'blogshammir_after_article' ); ?>


