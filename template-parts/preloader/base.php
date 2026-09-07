<?php
/**
 * The template for displaying page preloader.
 *
 * @see https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BlogShammir
 * @author Md Shammir Ahmed
 * @since   1.0.0
 */

?>

<div id="blogshammir-preloader"<?php blogshammir_preloader_classes(); ?>>
	<?php get_template_part( 'template-parts/preloader/preloader', blogshammir_option( 'preloader_style' ) ); ?>
</div><!-- END #blogshammir-preloader -->


