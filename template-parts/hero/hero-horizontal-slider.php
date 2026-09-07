<?php
/**
 * The template for displaying Hero Horizontal Slider.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */


// Setup Hero posts.
$blogshammir_hero_slider_orderby = blogshammir_option( 'hero_slider_orderby' );
$blogshammir_hero_slider_order   = explode( '-', $blogshammir_hero_slider_orderby );

$blogshammir_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => blogshammir_option( 'hero_slider_post_number' ), // phpcs:ignore WordPress.WP.PostsPerPage.posts_per_page_posts_per_page
	'order'               => $blogshammir_hero_slider_order[1],
	'orderby'             => $blogshammir_hero_slider_order[0],
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

$blogshammir_hero_categories = array_filter( array_map( 'absint', (array) blogshammir_option( 'hero_slider_category' ) ) );

// If categories are specified
if ( ! empty( $blogshammir_hero_categories ) ) {
	$tax_query[] = array(
		'taxonomy' => 'category',
		'field'    => 'term_id',
		'terms'    => $blogshammir_hero_categories,
		'operator' => 'IN',
	);
}

$blogshammir_args['tax_query'] = $tax_query;

$blogshammir_args = apply_filters( 'blogshammir_hero_slider_query_args', $blogshammir_args );

$blogshammir_posts = new WP_Query( $blogshammir_args );

// No posts found.
if ( ! $blogshammir_posts->have_posts() ) {
	return;
}

$blogshammir_hero_items_html = '';

$blogshammir_hero_elements       = (array) blogshammir_option( 'hero_slider_elements' );
$blogshammir_hero_readmore       = isset( $blogshammir_hero_elements['read_more'] ) && $blogshammir_hero_elements['read_more'] ? ' blogshammir-hero-readmore' : '';
$blogshammir_hero_read_more_text = blogshammir_option( 'hero_slider_read_more' );

while ( $blogshammir_posts->have_posts() ) :
	$blogshammir_posts->the_post();

	// Post items HTML markup.
	ob_start();

	?>
	<div class="swiper-slide">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'blogshammir-article' ); ?><?php blogshammir_schema_markup( 'article' ); ?>>
			<div class="blogshammir-blog-entry-wrapper blogshammir-thumb-hero blogshammir-thumb-left">
				<div class="post-thumb entry-media thumbnail">
					<a href="<?php echo esc_url( blogshammir_entry_get_permalink() ); ?>" class="entry-image-link">
						<?php the_post_thumbnail( get_the_ID(), 'full' ); ?>
					</a>
				</div>
				<div class="blogshammir-entry-content-wrapper">

				<?php if ( isset( $blogshammir_hero_elements['category'] ) && $blogshammir_hero_elements['category'] ) { ?>
					<div class="post-category">
						<?php blogshammir_entry_meta_category( ' ', false, apply_filters( 'blogshammir_hero_horizontal_category_limit', 3 ) ); ?>
					</div>
				<?php } ?>

				<?php if ( get_the_title() ) { ?>
				<header class="entry-header">
					<h4 class="entry-title"><a href="<?php echo esc_url( blogshammir_entry_get_permalink() ); ?>"><?php the_title(); ?></a></h4>
				</header>
				<?php } ?>

				<?php get_template_part( 'template-parts/entry/entry-summary' ); ?>

				<?php if ( $blogshammir_hero_readmore ) { ?>
					<footer class="entry-footer">
						<a href="<?php echo esc_url( blogshammir_entry_get_permalink() ); ?>" class="blogshammir-btn btn-text-1" role="button"><span><?php echo esc_html( $blogshammir_hero_read_more_text ); ?></span></a>
					</footer>
				<?php } ?>

				<?php if ( isset( $blogshammir_hero_elements['meta'] ) && $blogshammir_hero_elements['meta'] ) { ?>
					<?php
						get_template_part( 'template-parts/entry/entry', 'meta', array( 'blogshammir_meta_callback' => 'blogshammir_get_hero_entry_meta_elements' ) );
					?>
					<!-- END .entry-meta -->
				<?php } ?>

			</div><!-- END .slide-inner -->
		</article><!-- END article -->
	</div>
	<?php
	$blogshammir_hero_items_html .= ob_get_clean();
endwhile;

// Restore original Post Data.
wp_reset_postdata();

// Hero container. {"delay": 8000, "disableOnInteraction": false}

?>
<div class="blogshammir-hero-slider blogshammir-blog-horizontal">
	<div class="blogshammir-horizontal-slider">

		<div class="blogshammir-hero-container blogshammir-container">
			<div class="blogshammir-flex-row">
				<div class="col-xs-12">
					<div class="blogshammir-swiper swiper" data-swiper-options='{
						"spaceBetween": 24,
						"slidesPerView": 1,
						"breakpoints": {
							"0": {
								"spaceBetween": 16
							},
							"768": {
								"spaceBetween": 16
							},
							"1200": {
								"spaceBetween": 24
							}
						},
						"loop": true,
						"autoHeight": true,
						"autoplay": {"delay": 12000, "disableOnInteraction": false},
						"speed": 1000,
						"navigation": {"nextEl": ".hero-next", "prevEl": ".hero-prev"}
					}'>
						<div class="swiper-wrapper">
							<?php echo wp_kses( $blogshammir_hero_items_html, blogshammir_get_allowed_html_tags() ); ?> 
						</div>
						<div class="swiper-button-next hero-next"></div>
						<div class="swiper-button-prev hero-prev"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="blogshammir-spinner visible">
			<div></div>
			<div></div>
		</div>
	</div>
</div><!-- END .blogshammir-hero-slider -->


