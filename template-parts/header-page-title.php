<?php
/**
 * Template part for displaying page header.
 *
 * @package BlogShammir
 * @author Md Shammir Ahmed
 * @since   1.0.0
 */

?>

<div <?php blogshammir_page_header_classes(); ?><?php blogshammir_page_header_atts(); ?>>
	<div class="blogshammir-container">

	<?php do_action( 'blogshammir_page_header_start' ); ?>

	<?php if ( blogshammir_page_header_has_title() ) { ?>

		<div class="blogshammir-page-header-wrapper">

			<div class="blogshammir-page-header-title">
				<?php blogshammir_page_header_title(); ?>
			</div>

			<?php $blogshammir_description = apply_filters( 'blogshammir_page_header_description', blogshammir_get_the_description() ); ?>

			<?php if ( $blogshammir_description ) { ?>

				<div class="blogshammir-page-header-description">
					<?php echo wp_kses( $blogshammir_description, blogshammir_get_allowed_html_tags() ); ?>
				</div>

			<?php } ?>
		</div>

	<?php } ?>

	<?php do_action( 'blogshammir_page_header_end' ); ?>

	</div>
</div>


