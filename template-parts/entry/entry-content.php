<?php
/**
 * Template part for displaying entry content.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

/**
 * Do not allow direct script access.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php do_action( 'blogshammir_before_entry_content' ); ?>
<div class="entry-content blogshammir-entry"<?php blogshammir_schema_markup( 'text' ); ?>>
	<?php the_content(); ?>
</div>

<?php blogshammir_link_pages(); ?>

<?php do_action( 'blogshammir_after_entry_content' ); ?>


