<?php
/**
 * The template for displaying theme footer.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

?>

<?php do_action( 'blogshammir_before_footer' ); ?>
<div id="blogshammir-footer" <?php blogshammir_footer_classes(); ?>>
	<div class="blogshammir-container">
		<div class="blogshammir-flex-row" id="blogshammir-footer-widgets">

			<?php blogshammir_footer_widgets(); ?>

		</div><!-- END .blogshammir-flex-row -->
	</div><!-- END .blogshammir-container -->
</div><!-- END #blogshammir-footer -->
<?php do_action( 'blogshammir_after_footer' ); ?>


