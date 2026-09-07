<?php
/**
 * Template part for displaying entry tags.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

$blogshammir_entry_elements    = blogshammir_option( 'single_post_elements' );
$blogshammir_entry_footer_tags = isset( $blogshammir_entry_elements['tags'] ) && $blogshammir_entry_elements['tags'] && has_tag();
$blogshammir_entry_footer_date = isset( $blogshammir_entry_elements['last-updated'] ) && $blogshammir_entry_elements['last-updated'] && get_the_time( 'U' ) !== get_the_modified_time( 'U' );

$blogshammir_entry_footer_tags = apply_filters( 'blogshammir_display_entry_footer_tags', $blogshammir_entry_footer_tags );
$blogshammir_entry_footer_date = apply_filters( 'blogshammir_display_entry_footer_date', $blogshammir_entry_footer_date );

// Nothing is enabled, don't display the div.
if ( ! $blogshammir_entry_footer_tags && ! $blogshammir_entry_footer_date ) {
	return;
}
?>

<?php do_action( 'blogshammir_before_entry_footer' ); ?>

<div class="entry-footer">

	<?php
	// Post Tags.
	if ( $blogshammir_entry_footer_tags ) {
		blogshammir_entry_meta_tag(
			'<div class="post-tags"><span class="cat-links">',
			'',
			'</span></div>',
			0,
			false
		);
	}

	// Last Updated Date.
	if ( $blogshammir_entry_footer_date ) {

		$blogshammir_before = '<span class="last-updated blogshammir-iflex-center">';

		if ( true === blogshammir_option( 'single_entry_meta_icons' ) ) {
			$blogshammir_before .= blogshammir()->icons->get_svg( 'edit-3' );
		}

		blogshammir_entry_meta_date(
			array(
				'show_published' => false,
				'show_modified'  => true,
				'before'         => $blogshammir_before,
				'after'          => '</span>',
			)
		);
	}
	?>

</div>

<?php do_action( 'blogshammir_after_entry_footer' ); ?>


