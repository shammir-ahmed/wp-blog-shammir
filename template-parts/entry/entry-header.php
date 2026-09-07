<?php
/**
 * Template part for displaying entry header.
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

<?php do_action( 'blogshammir_before_entry_header' ); ?>
<header class="entry-header">

	<?php
	$blogshammir_tag = is_single( get_the_ID() ) && ! blogshammir_page_header_has_title() ? 'h1' : 'h4';
	$blogshammir_tag = apply_filters( 'blogshammir_entry_header_tag', $blogshammir_tag );

	$blogshammir_title_string = '%2$s%1$s';

	if ( 'link' === get_post_format() ) {
		$blogshammir_title_string = '<a href="%3$s" title="%3$s" rel="bookmark">%2$s%1$s</a>';
	} elseif ( ! is_single( get_the_ID() ) ) {
		$blogshammir_title_string = '<a href="%3$s" title="%4$s" rel="bookmark">%2$s%1$s</a>';
	}

	$blogshammir_title_icon = apply_filters( 'blogshammir_post_title_icon', '' );
	$blogshammir_title_icon = blogshammir()->icons->get_svg( $blogshammir_title_icon );
	?>

	<<?php echo tag_escape( $blogshammir_tag ); ?> class="entry-title"<?php blogshammir_schema_markup( 'headline' ); ?>>
		<?php
		echo sprintf(
			wp_kses_post( $blogshammir_title_string ),
			wp_kses_post( get_the_title() ),
			wp_kses_post( (string) $blogshammir_title_icon ),
			esc_url( blogshammir_entry_get_permalink() ),
			the_title_attribute( array( 'echo' => false ) )
		);
		?>
	</<?php echo tag_escape( $blogshammir_tag ); ?>>

</header>
<?php do_action( 'blogshammir_after_entry_header' ); ?>


