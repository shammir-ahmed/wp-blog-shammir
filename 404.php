<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

?>

<?php get_header(); ?>

<div class="blogshammir-container">

	<?php do_action( 'blogshammir_before_content_area', 'before_post_archive' ); ?>

	<div id="primary" class="content-area">

		<?php do_action( 'blogshammir_before_content' ); ?>

		<main id="content" class="site-content" role="main"<?php blogshammir_schema_markup( 'main' ); ?>>

			<?php do_action( 'blogshammir_content_404' ); ?>

		</main><!-- #content .site-content -->

		<?php do_action( 'blogshammir_after_content' ); ?>

	</div><!-- #primary .content-area -->

	<?php do_action( 'blogshammir_after_content_area' ); ?>

</div><!-- END .blogshammir-container -->

<?php
get_footer();


