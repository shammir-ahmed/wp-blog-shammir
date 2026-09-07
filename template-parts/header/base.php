<?php
/**
 * The base template for displaying theme header area.
 *
 * @see https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

?>
<?php do_action( 'blogshammir_before_header' ); ?>
<div id="blogshammir-header" <?php blogshammir_header_classes(); ?>>
	<?php do_action( 'blogshammir_header_content' ); ?>
</div><!-- END #blogshammir-header -->
<?php do_action( 'blogshammir_after_header' ); ?>


