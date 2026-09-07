<?php
/**
 * The template for displaying theme header search widget.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

$blogshammir_header_widgets = blogshammir_option( 'header_widgets' );
$style_for_search        = '';
foreach ( $blogshammir_header_widgets as $widget ) {
	// Check if the widget type is 'search'
	if ( $widget['type'] === 'search' ) {
		// Access the 'style' from the 'values' array
		$style_for_search = $widget['values']['style'] ?? 'rounded-fill';
		break; // Stop the loop if the search widget is found
	}
}

?>

<div aria-haspopup="true">
	<a href="#" class="blogshammir-search <?php echo esc_attr( $style_for_search ); ?>">
		<?php echo blogshammir()->icons->get_svg( 'search', array( 'aria-label' => esc_html__( 'Search', 'blogshammir' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</a><!-- END .blogshammir-search -->

	<div class="blogshammir-search-simple blogshammir-search-container dropdown-item">
		<?php
			get_search_form(
				array(
					'aria_label' => __( 'Search for:', 'blogshammir' ),
					'icon' => 'arrow'
				)
			);
		?>
	</div><!-- END .blogshammir-search-simple -->
</div>


