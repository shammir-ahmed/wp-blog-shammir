<?php
/**
 * Header Cart Widget cart & checkout buttons.
 *
 * @package BlogShammir
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="blogshammir-cart-buttons">
	<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="blogshammir-btn btn-text-1" role="button">
		<span><?php esc_html_e( 'View Cart', 'blogshammir' ); ?></span>
	</a>

	<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="blogshammir-btn btn-fw" role="button">
		<span><?php esc_html_e( 'Checkout', 'blogshammir' ); ?></span>
	</a>
</div>

