<?php
/**
 * The template for displaying Related posts on post details page.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */


// Setup Related posts.

if ( ! blogshammir_option( 'related_posts_enable' ) ) {
	return;
}
$numbre_of_posts = blogshammir_option( 'related_post_number' );
$numbre_of_posts = $numbre_of_posts ? $numbre_of_posts : 3;
$blogshammir_args   = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => $numbre_of_posts, // phpcs:ignore WordPress.WP.PostsPerPage.posts_per_page_posts_per_page
	'orderby'             => 'date',
	'ignore_sticky_posts' => true,
	'category__in'        => wp_get_post_categories( get_the_ID() ),
	'post__not_in'        => array( get_the_ID() ),
	'tax_query'           => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		array(
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => array( 'post-format-quote' ),
			'operator' => 'NOT IN',
		),
	),
);

$blogshammir_args = apply_filters( 'blogshammir_related_posts_query_args', $blogshammir_args );

$blogshammir_posts = new WP_Query( $blogshammir_args );

// No posts found.
if ( ! $blogshammir_posts->have_posts() ) {
	return;
}

$blogshammir_related_posts_items_html = '';
$col                               = blogshammir_option( 'related_posts_column' );
while ( $blogshammir_posts->have_posts() ) :
	$blogshammir_posts->the_post();

	// Post items HTML markup.
	ob_start();
	?>

	<div class="col-md-<?php echo esc_attr( $col ); ?> col-sm-6 col-xs-12">
		<div class="blogshammir-post-item style-1 end rounded">
			<div class="blogshammir-post-thumb">
				<a href="<?php echo esc_url( blogshammir_entry_get_permalink() ); ?>" tabindex="0"></a>
				<div class="inner"><?php the_post_thumbnail( get_the_ID(), 'full' ); ?></div>
			</div><!-- END .blogshammir-post-thumb -->
			<div class="blogshammir-post-content">
							
				<div class="post-category">
					<?php blogshammir_entry_meta_category( ' ', false, apply_filters( 'blogshammir_pyml_category_limit', 3 ) ); ?>
				</div>

				<?php get_template_part( 'template-parts/entry/entry-header' ); ?>

				<div class="entry-meta">
					<div class="entry-meta-elements">
						<?php
						blogshammir_entry_meta_author();
						?>
					</div>
				</div><!-- END .entry-meta -->

			</div><!-- END .blogshammir-post-content -->			
		</div><!-- END .blogshammir-post-item -->
	</div>
	<?php
	$blogshammir_related_posts_items_html .= ob_get_clean();
endwhile;

// Restore original Post Data.
wp_reset_postdata();

// Title.
$blogshammir_related_posts_title = blogshammir_option( 'related_posts_heading' );

?>
<div id="related_posts" class="mt-5">
	<div class="blogshammir-rp slider-overlay-1">
		<div class="blogshammir-rp-container">
			<div class="blogshammir-flex-row">
				<div class="col-xs-12">
					<div class="blogshammir-card-items">
						<div class="h4 widget-title">
							<?php if ( $blogshammir_related_posts_title ) : ?>
								<?php echo esc_html( $blogshammir_related_posts_title ); ?>
							<?php endif; ?>
						</div>
						<div class="blogshammir-flex-row gy-4">
							<?php echo $blogshammir_related_posts_items_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</div>
				</div>
			</div><!-- END .blogshammir-card-items -->
		</div>
	</div><!-- END .blogshammir-rp -->
</div><!-- END #related_posts -->


