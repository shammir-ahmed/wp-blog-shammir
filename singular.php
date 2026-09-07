<?php
/**
 * The template for displaying all pages, single posts and attachments.
 *
 * This is a new template file that WordPress introduced in
 * version 4.3.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

?>

<?php
get_header();
$class_no_media = ! has_post_thumbnail() ? 'no-entry-media' : '';
do_action( 'blogshammir_before_singular_container' );
?>

<?php do_action( 'blogshammir_before_container' ); ?>

<div class="blogshammir-container">

	<?php do_action( 'blogshammir_before_content_area', 'before_post_archive' ); ?>

	<div id="primary" class="content-area">

		<?php do_action( 'blogshammir_before_content' ); ?>

		<main id="content" class="site-content <?php echo esc_attr( $class_no_media ); ?>" role="main"<?php blogshammir_schema_markup( 'main' ); ?>>

			<?php
			do_action( 'blogshammir_before_singular' );

			do_action( 'blogshammir_content_singular' );

			do_action( 'blogshammir_after_singular' );
			?>

		</main><!-- #content .site-content -->

		<?php do_action( 'blogshammir_after_content' ); ?>

	</div><!-- #primary .content-area -->

	<?php do_action( 'blogshammir_sidebar' ); ?>

	<?php do_action( 'blogshammir_after_content_area' ); ?>

</div><!-- END .blogshammir-container -->

<?php do_action( 'blogshammir_after_container' ); ?>

<?php
do_action( 'blogshammir_after_singular_container' );
get_footer();


