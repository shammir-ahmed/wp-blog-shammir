<?php
/**
 * The template for displaying theme copyright bar.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

?>

<?php do_action( 'blogshammir_before_copyright' ); ?>
<div id="blogshammir-copyright" <?php blogshammir_copyright_classes(); ?>>
	<div class="blogshammir-container">
		<div class="blogshammir-flex-row">

			<div class="col-xs-12 center-xs col-md flex-basis-auto start-md"><?php do_action( 'blogshammir_copyright_widgets', 'start' ); ?></div>
			<div class="col-xs-12 center-xs col-md flex-basis-auto end-md"><?php do_action( 'blogshammir_copyright_widgets', 'end' ); ?></div>

		</div><!-- END .blogshammir-flex-row -->
	</div>
</div><!-- END #blogshammir-copyright -->
<?php do_action( 'blogshammir_after_copyright' ); ?>


