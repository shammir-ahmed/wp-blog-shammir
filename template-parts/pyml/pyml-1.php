<?php
/**
 * The template for displaying PYML Slider.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */


// Setup PYML posts.
$blogshammir_pyml_orderby = blogshammir_option( 'pyml_orderby' );
$blogshammir_pyml_order   = explode( '-', $blogshammir_pyml_orderby );

$blogshammir_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => blogshammir_option( 'pyml_post_number' ), // phpcs:ignore WordPress.WP.PostsPerPage.posts_per_page_posts_per_page
	'order'               => $blogshammir_pyml_order[1],
	'orderby'             => $blogshammir_pyml_order[0],
	'ignore_sticky_posts' => true,
);

$tax_query = array(
	array(
		'taxonomy' => 'post_format',
		'field'    => 'slug',
		'terms'    => array( 'post-format-quote' ),
		'operator' => 'NOT IN',
	),
);

$blogshammir_pyml_categories = array_filter( array_map( 'absint', (array) blogshammir_option( 'pyml_category' ) ) );

// If categories are specified
if ( ! empty( $blogshammir_pyml_categories ) ) {
	$tax_query[] = array(
		'taxonomy' => 'category',
		'field'    => 'term_id',
		'terms'    => $blogshammir_pyml_categories,
		'operator' => 'IN',
	);
}

$blogshammir_args['tax_query'] = $tax_query;

$blogshammir_args  = apply_filters( 'blogshammir_pyml_query_args', $blogshammir_args );

$blogshammir_posts = new WP_Query( $blogshammir_args );

// No posts found.
if ( ! $blogshammir_posts->have_posts() ) {
	return;
}

// $blogshammir_pyml_bgs_html   = '';
$blogshammir_pyml_items_html = '';

$blogshammir_pyml_elements = (array) blogshammir_option( 'pyml_elements' );

$blogshammir_classes = blogshammir_template_part_column_classes( $blogshammir_args['posts_per_page'] );

while ( $blogshammir_posts->have_posts() ) :
	$blogshammir_posts->the_post();

	// Post items HTML markup.
	ob_start();
	?>
	<div class="<?php echo esc_attr( $blogshammir_classes ); ?>">
		<div class="blogshammir-post-item style-1 end rounded">
			<div class="blogshammir-post-thumb">
				<a href="<?php echo esc_url( blogshammir_entry_get_permalink() ); ?>" tabindex="0"></a>
				<div class="inner"><?php the_post_thumbnail( get_the_ID(), 'full' ); ?></div>
			</div><!-- END .blogshammir-post-thumb -->
			<div class="blogshammir-post-content">
							
				<?php if ( isset( $blogshammir_pyml_elements['category'] ) && $blogshammir_pyml_elements['category'] ) { ?>
					<div class="post-category">
						<?php blogshammir_entry_meta_category( ' ', false, apply_filters( 'blogshammir_pyml_category_limit', 3 ) ); ?>
					</div>
				<?php } ?>

				<?php get_template_part( 'template-parts/entry/entry-header' ); ?>

				<?php if ( isset( $blogshammir_pyml_elements['meta'] ) && $blogshammir_pyml_elements['meta'] ) { ?>
					<div class="entry-meta">
						<div class="entry-meta-elements">
							<?php
							blogshammir_entry_meta_author();

							blogshammir_entry_meta_date(
								array(
									'show_modified'   => false,
									'published_label' => '',
								)
							);
							?>
						</div>
					</div><!-- END .entry-meta -->
				<?php } ?>

			</div><!-- END .blogshammir-post-content -->			
		</div><!-- END .blogshammir-post-item -->
	</div>
	<?php
	$blogshammir_pyml_items_html .= ob_get_clean();
endwhile;

// Restore original Post Data.
wp_reset_postdata();

// Container.
$blogshammir_pyml_container = blogshammir_option( 'pyml_container' );
$blogshammir_pyml_container = 'full-width' === $blogshammir_pyml_container ? 'blogshammir-container blogshammir-container__wide' : 'blogshammir-container';

// Title.
$blogshammir_pyml_title = blogshammir_option( 'pyml_title' );

// Classes.
$blogshammir_classes  = '';
$blogshammir_classes .= blogshammir_option( 'pyml_card_border' ) ? ' blogshammir-card__boxed' : '';
$blogshammir_classes .= blogshammir_option( 'pyml_card_shadow' ) ? ' blogshammir-card-shadow' : '';

?>

<div class="blogshammir-pyml slider-overlay-1 <?php echo esc_attr( $blogshammir_classes ); ?>">
	<div class="blogshammir-pyml-container <?php echo esc_attr( $blogshammir_pyml_container ); ?>">
		<div class="blogshammir-flex-row">
			<div class="col-xs-12">
				<div class="blogshammir-card-items">
					<div class="h4 widget-title">
						<?php if ( $blogshammir_pyml_title ) : ?>
						<span><?php echo esc_html( $blogshammir_pyml_title ); ?></span>
						<?php endif; ?>
					</div>
					<div class="blogshammir-flex-row gy-4">
						<?php echo wp_kses_post( $blogshammir_pyml_items_html ); ?>
					</div>
				</div>
			</div>
		</div><!-- END .blogshammir-card-items -->
	</div>
</div><!-- END .blogshammir-pyml -->


