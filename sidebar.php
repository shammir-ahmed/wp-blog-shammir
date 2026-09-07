<?php
/**
 * The template for displaying theme sidebar.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

if ( ! blogshammir_is_sidebar_displayed() ) {
	return;
}

$blogshammir_sidebar = blogshammir_get_sidebar();
?>

<aside id="secondary" class="widget-area blogshammir-sidebar-container"<?php blogshammir_schema_markup( 'sidebar' ); ?> role="complementary">

	<div class="blogshammir-sidebar-inner">
		<?php do_action( 'blogshammir_before_sidebar' ); ?>

		<?php
		if ( is_active_sidebar( $blogshammir_sidebar ) ) {

			dynamic_sidebar( $blogshammir_sidebar );

		} elseif ( current_user_can( 'edit_theme_options' ) ) {

			$blogshammir_sidebar_name = blogshammir_get_sidebar_name_by_id( $blogshammir_sidebar );
			?>
			<div class="blogshammir-sidebar-widget blogshammir-widget blogshammir-no-widget">

				<div class='h4 widget-title'><?php echo esc_html( $blogshammir_sidebar_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div> 

				<p class='no-widget-text'>
					<?php if ( is_customize_preview() ) { ?>
						<a href='#' class="blogshammir-set-widget" data-sidebar-id="<?php echo esc_attr( $blogshammir_sidebar ); ?>">
					<?php } else { ?>
						<a href='<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>'>
					<?php } ?>
						<?php esc_html_e( 'Click here to assign a widget.', 'blogshammir' ); ?>
					</a>
				</p>
			</div>
			<?php
		}
		?>

		<?php do_action( 'blogshammir_after_sidebar' ); ?>
	</div>

</aside><!--#secondary .widget-area -->

<?php


