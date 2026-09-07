<?php
/**
 * Header Cart Widget.
 *
 * @package BlogShammir
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blogshammir_cart_count = WC()->cart->get_cart_contents_count();
$blogshammir_cart_icon  = apply_filters( 'blogshammir_wc_cart_widget_icon', 'shopping-cart-2' );

$blogshammir_header_widgets = blogshammir_option( 'header_widgets' );
$style_for_cart          = '';

foreach ( $blogshammir_header_widgets as $widget ) {
	// Check if the widget type is 'cart'
	if ( $widget['type'] === 'cart' ) {
		// Check if 'style' key exists and then access the 'style' from the 'values' array
		if ( isset( $widget['values']['style'] ) ) {
			$style_for_cart = $widget['values']['style'];
		} else {
			// Optionally handle the case where 'style' does not exist
			// For example, you could assign a default style
			$style_for_cart = 'default-style'; // This is just an example, adjust as needed
		}
		break; // Stop the loop if the cart widget is found
	}
}

?>
<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="blogshammir-cart <?php echo esc_attr( $style_for_cart ); ?>">
	<?php echo blogshammir()->icons->get_svg( $blogshammir_cart_icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php if ( $blogshammir_cart_count > 0 ) { ?>
		<span class="blogshammir-cart-count"><?php echo esc_html( $blogshammir_cart_count ); ?></span>
	<?php } ?>
</a>

