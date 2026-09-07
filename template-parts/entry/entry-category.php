<?php
/**
 * Template part for displaying entry category.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

?>

<div class="post-category">

	<?php
	do_action( 'blogshammir_before_post_category' );

	if ( is_singular() ) {
		blogshammir_entry_meta_category( ' ', false );
	} else {
		if ( 'blog-horizontal' === blogshammir_get_article_feed_layout() || 'blog-layout-2' === blogshammir_get_article_feed_layout() ) {
			blogshammir_entry_meta_category( ' ', false, 3 );
		} else {
			blogshammir_entry_meta_category( ', ', false, 3 );
		}
	}

	do_action( 'blogshammir_after_post_category' );
	?>

</div>


