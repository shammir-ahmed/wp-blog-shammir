<?php
/**
 * Header Cart Widget dropdown header.
 *
 * @package BlogShammir
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blogshammir_cart_count    = WC()->cart->get_cart_contents_count();
$blogshammir_cart_subtotal = WC()->cart->get_cart_subtotal();

?>
<div class="wc-cart-widget-header">
	<span class="blogshammir-cart-count">
		<?php
		/* translators: %s: the number of cart items; */
		echo wp_kses_post( sprintf( _n( '%s item', '%s items', $blogshammir_cart_count, 'blogshammir' ), $blogshammir_cart_count ) );
		?>
	</span>

	<span class="blogshammir-cart-subtotal">
		<?php
		/* translators: %s is the cart subtotal. */
		echo wp_kses_post( sprintf( __( 'Subtotal: %s', 'blogshammir' ), '<span>' . $blogshammir_cart_subtotal . '</span>' ) );
		?>
	</span>
</div>

