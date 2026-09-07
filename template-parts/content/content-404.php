<?php
/**
 * Template part for displaying 404 page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

?>

<section class="error-404 not-found">

	<?php do_action( 'blogshammir_before_404_content' ); ?>

	<header class="page-header">
		<h1 class="page-title"><?php echo wp_kses( __( '404', 'blogshammir' ), blogshammir_get_allowed_html_tags() ); ?></h1>
		<p class="h2"><?php echo wp_kses( __( 'Oops! Page not found.', 'blogshammir' ), blogshammir_get_allowed_html_tags() ); ?></p>
	</header><!-- .page-header -->

	<div class="page-content blogshammir-entry">
		<p><?php echo wp_kses( __( 'We couldn&rsquo;t find the page you are looking for. Perhaps you can try searching:', 'blogshammir' ), blogshammir_get_allowed_html_tags() ); ?></p>

		<?php get_search_form(); ?>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="blogshammir-btn btn-left-icon btn-reveal" role="button">
			<span><?php esc_html_e( 'Return to Home', 'blogshammir' ); ?></span>
			<?php echo blogshammir()->icons->get_svg( 'arrow-left', array( 'aria-hidden' => 'true' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</a>
	</div><!-- .page-content -->

	<?php do_action( 'blogshammir_after_404_content' ); ?>

</section><!-- .error-404 -->


