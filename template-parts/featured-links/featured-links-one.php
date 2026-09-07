<?php
/**
 * The template for displaying Featured Links.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */


$blogshammir_featured_links_title_type = blogshammir_option( 'featured_links_title_type' );
$blogshammir_featured_links_items_html = '';

$blogshammir_featured_column = 'col-md-4 col-sm-6 col-xs-12';
foreach ( $args['features'] as $key => $feature ) :

	// Post items HTML markup.
	ob_start();

	?>
	
	<div id="bloghsah-featured-item-<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $blogshammir_featured_column ); ?>">
		<div class="blogshammir-post-item style-1 center">
			<div class="blogshammir-post-thumb">
				<div class="inner bloghsah-featured-item-image">
					<?php
					if ( ! empty( $feature['image']['id'] ) ) :
						echo wp_get_attachment_image( $feature['image']['id'], 'large' );
					endif;
					?>
				</div>
			</div><!-- END .blogshammir-post-thumb-->
			<div class="blogshammir-post-content">

				<?php
				if ( ! empty( $feature['link'] ) ) :
					if ( '1' == $blogshammir_featured_links_title_type ) :
						printf( '<a href="%1$s" class="blogshammir-btn btn-small btn-white" title="%2$s" target="%3$s">%4$s</a>', esc_url_raw( $feature['link']['url'] ), esc_attr( $feature['link']['title'] ), esc_attr( $feature['link']['target'] ), esc_html( $feature['link']['title'] ) );
						?>
						<?php
					endif;
				endif;
				?>
			</div><!-- END .blogshammir-post-content -->
		</div><!-- END .blogshammir-post-item -->
	</div>
	<?php
	$blogshammir_featured_links_items_html .= ob_get_clean();
endforeach;

// Restore original Post Data.
wp_reset_postdata();

// Title.
$blogshammir_featured_links_title = blogshammir_option( 'featured_links_title' );

// Classes.
$blogshammir_classes  = '';
$blogshammir_classes .= blogshammir_option( 'featured_links_card_border' ) ? ' blogshammir-card__boxed' : '';
$blogshammir_classes .= blogshammir_option( 'featured_links_card_shadow' ) ? ' blogshammir-card-shadow' : '';

?>

<div class="blogshammir-featured featured-one slider-overlay-1 <?php echo esc_attr( $blogshammir_classes ); ?>">
	<div class="blogshammir-featured-container blogshammir-container">
		<div class="blogshammir-flex-row g-0">
			<div class="col-xs-12">
				<div class="blogshammir-card-items">
					<?php if ( $blogshammir_featured_links_title ) : ?>
					<div class="h4 widget-title">							
						<span><?php echo esc_html( $blogshammir_featured_links_title ); ?></span>
					</div>
					<?php endif; ?>
					<div class="blogshammir-flex-row gy-4">
						<?php echo wp_kses_post( $blogshammir_featured_links_items_html ); ?>
					</div>
				</div>
			</div>
		</div><!-- END .blogshammir-card-items -->
	</div>
</div><!-- END .blogshammir-featured -->


