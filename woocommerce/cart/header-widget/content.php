<?php
/**
 * Header Cart Widget dropdown content.
 *
 * @package BlogShammir
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blogshammir_cart_items = WC()->cart->get_cart();
?>
<div class="wc-cart-widget-content">
	<?php foreach ( $blogshammir_cart_items as $cart_item_key => $cart_item ) { // phpcs:ignore ?>

		<?php
		$blogshammir_product    = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$blogshammir_product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

		if ( $blogshammir_product && $blogshammir_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			$blogshammir_product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $blogshammir_product->is_visible() ? $blogshammir_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
			?>
			<div class="blogshammir-cart-item">
				<div class="blogshammir-cart-image">
					<?php
					$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $blogshammir_product->get_image(), $cart_item, $cart_item_key );

					if ( ! $blogshammir_product_permalink ) {
						echo $thumbnail; // phpcs:ignore
					} else {
						printf( '<a href="%s" class="blogshammir-woo-thumb">%s</a>', esc_url( $blogshammir_product_permalink ), $thumbnail ); // phpcs:ignore
					}
					?>
				</div>

				<div class="blogshammir-cart-item-details">
					<p class="blogshammir-cart-item-title">
						<?php
						if ( ! $blogshammir_product_permalink ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', esc_html( $blogshammir_product->get_name() ), $cart_item, $cart_item_key ) . '&nbsp;' );
						} else {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $blogshammir_product_permalink ), esc_html( $blogshammir_product->get_name() ) ), $cart_item, $cart_item_key ) );
						}
						?>
					</p>
					<div class="blogshammir-cart-item-meta">

					<?php if ( $cart_item['quantity'] > 1 ) { ?>
							<span class="blogshammir-cart-item-quantity"><?php echo esc_html( $cart_item['quantity'] ); ?></span>
						<?php } ?>

						<span class="blogshammir-cart-item-price"><?php echo $blogshammir_product->get_price_html(); // phpcs:ignore ?></span>
					</div>
				</div>

				<?php /* translators: %s is cart item title. */ ?>
				<a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item ) ); ?>" class="blogshammir-remove-cart-item" data-product_key="<?php echo esc_attr( $cart_item['key'] ); ?>" title="<?php echo esc_html( sprintf( __( 'Remove %s from cart', 'blogshammir' ), $blogshammir_product->get_title() ) ); ?>">
					<?php echo blogshammir()->icons->get_svg( 'x', array( 'aria-hidden' => 'true' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php /* translators: %s is cart item title. */ ?>
					<span class="screen-reader-text"><?php echo esc_html( sprintf( __( 'Remove %s from cart', 'blogshammir' ), $blogshammir_product->get_title() ) ); ?></span>
				</a>
			</div>
		<?php } ?>
	<?php } ?>
</div><!-- END .wc-cart-widget-content -->

