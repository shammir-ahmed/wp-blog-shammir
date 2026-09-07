<?php
/**
 * The template for displaying Ticker Slider.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */


// Setup Ticker posts.
$blogshammir_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => blogshammir_option( 'ticker_post_number' ), // phpcs:ignore WordPress.WP.PostsPerPage.posts_per_page_posts_per_page
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

$blogshammir_ticker_categories = array_filter( array_map( 'absint', (array) blogshammir_option( 'ticker_category' ) ) );


// If categories are specified
if ( ! empty( $blogshammir_ticker_categories ) ) {
	$tax_query[] = array(
		'taxonomy' => 'category',
		'field'    => 'term_id',
		'terms'    => $blogshammir_ticker_categories,
		'operator' => 'IN',
	);
}

$blogshammir_args['tax_query'] = $tax_query;

$blogshammir_args = apply_filters( 'blogshammir_ticker_query_args', $blogshammir_args );

$blogshammir_posts = new WP_Query( $blogshammir_args );

// No posts found.
if ( ! $blogshammir_posts->have_posts() ) {
	return;
}

$blogshammir_ticker_items_html = '';

$blogshammir_ticker_elements = (array) blogshammir_option( 'ticker_elements' );

$blogshammir_ticker_type = blogshammir_option( 'ticker_type' );

$blogshammir_ticker_slide = $blogshammir_ticker_type === 'one-ticker' ? 'ticker-item' : '';

while ( $blogshammir_posts->have_posts() ) :
	$blogshammir_posts->the_post();

	// Post items HTML markup.
	ob_start();
	?>
	<div class="<?php echo esc_attr( $blogshammir_ticker_slide ); ?>">
		<div class="ticker-slide-item">

			<?php if ( has_post_thumbnail() ) { ?>
			<div class="ticker-slider-backgrounds">
				<a href="<?php echo esc_url( blogshammir_entry_get_permalink() ); ?>">
					<?php the_post_thumbnail( 'thumbnail' ); ?>
				</a>
			</div><!-- END .ticker-slider-items -->
			<?php } ?>

			<div class="slide-inner">				

				<?php if ( get_the_title() ) { ?>
					<h6><a href="<?php echo esc_url( blogshammir_entry_get_permalink() ); ?>"><?php the_title(); ?></a></h6>
				<?php } ?>

				<?php if ( isset( $blogshammir_ticker_elements['meta'] ) && $blogshammir_ticker_elements['meta'] ) { ?>
					<div class="entry-meta">
						<div class="entry-meta-elements">
							<?php
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

			</div><!-- END .slide-inner -->
		</div><!-- END .ticker-slide-item -->
	</div><!-- END .swiper-slide -->
	<?php
	$blogshammir_ticker_items_html .= ob_get_clean();
endwhile;

// Restore original Post Data.
wp_reset_postdata();

$blogshammir_ticker_title = blogshammir_option( 'ticker_title' );

?>

<div class="blogshammir-ticker <?php echo esc_attr( $blogshammir_ticker_type ); ?>">
	<div class="blogshammir-ticker-container blogshammir-container">
		<div class="blogshammir-flex-row">
			<div class="col-xs-12">
				<div class="blogshammir-card-items">
					<?php if ( $blogshammir_ticker_title ) : ?>
					<div class="h4 widget-title">
						<?php echo esc_html( $blogshammir_ticker_title ); ?>
					</div>
					<?php endif; ?>
					<?php
						$blogshammir_ticker_direction = 'left';
						$blogshammir_ticker_dir       = 'ltr';
					if ( is_rtl() ) {
						$blogshammir_ticker_direction = 'right';
						$blogshammir_ticker_dir       = 'ltr';
					}
					?>
					<?php if ( 'one-ticker' === $blogshammir_ticker_type ) : ?>
					<div class="ticker-slider-box">
						<div class="ticker-slider-wrap" direction="<?php echo esc_attr( $blogshammir_ticker_direction ); ?>" dir="<?php echo esc_attr( $blogshammir_ticker_dir ); ?>">
							<?php echo wp_kses_post( $blogshammir_ticker_items_html ); ?>
						</div>
					</div>
					<div class="ticker-slider-controls">
						<button class="ticker-slider-pause"><i class="fas fa-pause"></i></button>						
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div><!-- END .ticker-slider-items -->
	</div>
</div><!-- END .blogshammir-ticker -->


