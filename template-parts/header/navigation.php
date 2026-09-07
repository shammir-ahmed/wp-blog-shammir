<?php
/**
 * The template for displaying header navigation.
 *
 * @package     Blogshammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

?>

<nav class="site-navigation main-navigation blogshammir-primary-nav blogshammir-nav blogshammir-header-element" role="navigation"<?php blogshammir_schema_markup( 'site_navigation' ); ?> aria-label="<?php esc_attr_e( 'Site Navigation', 'blogshammir' ); ?>">

<?php

if ( has_nav_menu( 'blogshammir-primary' ) ) {
	wp_nav_menu(
		array(
			'theme_location' => 'blogshammir-primary',
			'menu_id'        => 'blogshammir-primary-nav',
			'container'      => '',
			'link_before'    => '<span>',
			'link_after'     => '</span>',
		)
	);
} else {
	wp_page_menu(
		array(
			'menu_class'  => 'blogshammir-primary-nav',
			'show_home'   => true,
			'container'   => 'ul',
			'before'      => '',
			'after'       => '',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		)
	);
}

?>
</nav><!-- END .blogshammir-nav -->


