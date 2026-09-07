<?php
/**
 * The template for displaying header layout 1.
 *
 * @package BlogShammir
 * @author Md Shammir Ahmed
 * @since   1.0.0
 */

?>

<div class="blogshammir-container blogshammir-header-container">

	<?php
	blogshammir_header_logo_template();
	?>

	<span class="blogshammir-header-element blogshammir-mobile-nav">
		<?php blogshammir_hamburger( blogshammir_option( 'main_nav_mobile_label' ), 'blogshammir-primary-nav' ); ?>
	</span>

	<?php
	blogshammir_main_navigation_template();
	do_action( 'blogshammir_header_widget_location', array( 'left', 'right' ) );
	?>

</div><!-- END .blogshammir-container -->


