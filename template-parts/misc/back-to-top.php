<?php
/**
 * The template for displaying scroll to top button.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

?>

<a href="#" id="blogshammir-scroll-top" class="blogshammir-smooth-scroll" title="<?php esc_attr_e( 'Scroll to Top', 'blogshammir' ); ?>" <?php blogshammir_scroll_top_classes(); ?>>
	<span class="blogshammir-scroll-icon" aria-hidden="true">
		<?php echo blogshammir()->icons->get_svg( 'arrow-up', array( 'class' => 'top-icon' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php echo blogshammir()->icons->get_svg( 'arrow-up' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</span>
	<span class="screen-reader-text"><?php esc_html_e( 'Scroll to Top', 'blogshammir' ); ?></span>
</a><!-- END #blogshammir-scroll-to-top -->


