<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package BlogShammir
 * @author Md Shammir Ahmed
 * @since   1.0.0
 */

?>

<?php get_header(); ?>

<?php do_action( 'blogshammir_before_container' ); ?>

<div class="blogshammir-container">

	<?php do_action( 'blogshammir_before_content_area', 'before_post_archive' ); ?>

	<div id="primary" class="content-area">

		<?php do_action( 'blogshammir_before_content' ); ?>

		<main id="content" class="site-content" role="main"<?php blogshammir_schema_markup( 'main' ); ?>>

			<?php do_action( 'blogshammir_content_archive' ); ?>

		</main><!-- #content .site-content -->

		<?php do_action( 'blogshammir_after_content' ); ?>

	</div><!-- #primary .content-area -->

	<?php do_action( 'blogshammir_sidebar' ); ?>

	<?php do_action( 'blogshammir_after_content_area' ); ?>

</div><!-- END .blogshammir-container -->

<?php do_action( 'blogshammir_after_container' ); ?>

<?php
get_footer();


