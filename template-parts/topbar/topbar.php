<?php
/**
 * The template for displaying theme top bar.
 *
 * @see https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BlogShammir
 * @author Md Shammir Ahmed
 * @since   1.0.0
 */

?>

<?php do_action( 'blogshammir_before_topbar' ); ?>
<div id="blogshammir-topbar" <?php blogshammir_top_bar_classes(); ?>>
	<div class="blogshammir-container">
		<div class="blogshammir-flex-row">
			<div class="col-md flex-basis-auto start-sm"><?php do_action( 'blogshammir_topbar_widgets', 'left' ); ?></div>
			<div class="col-md flex-basis-auto end-sm"><?php do_action( 'blogshammir_topbar_widgets', 'right' ); ?></div>
		</div>
	</div>
</div><!-- END #blogshammir-topbar -->
<?php do_action( 'blogshammir_after_topbar' ); ?>


