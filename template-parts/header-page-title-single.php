<?php
/**
 * Template part for displaying page header for single post.
 *
 * @package BlogShammir
 * @author Md Shammir Ahmed
 * @since   1.0.0
 */

?>

<div <?php blogshammir_page_header_classes(); ?><?php blogshammir_page_header_atts(); ?>>

	<?php do_action( 'blogshammir_page_header_start' ); ?>

	<?php if ( 'in-page-header' === blogshammir_option( 'single_title_position' ) ) { ?>

		<div class="blogshammir-container">
			<div class="blogshammir-page-header-wrapper">

				<?php
				if ( blogshammir_single_post_displays( 'category' ) ) {
					get_template_part( 'template-parts/entry/entry', 'category' );
				}

				if ( blogshammir_page_header_has_title() ) {
					echo '<div class="blogshammir-page-header-title">';
					blogshammir_page_header_title();
					echo '</div>';
				}

				if ( blogshammir_has_entry_meta_elements() ) {
					get_template_part( 'template-parts/entry/entry', 'meta' );
				}
				?>

			</div>
		</div>

	<?php } ?>

	<?php do_action( 'blogshammir_page_header_end' ); ?>

</div>


