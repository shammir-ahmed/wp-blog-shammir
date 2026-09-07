<?php
/**
 * Header Cart Widget empty cart.
 *
 * @package BlogShammir
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="blogshammir-empty-cart">
	<?php echo blogshammir()->icons->get_svg( 'shopping-empty', array( 'aria-hidden' => 'true' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<p><?php esc_html_e( 'No products in the cart.', 'blogshammir' ); ?></p>
</div>

