<?php
/**
 * BlogShammir Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/advanced-topics/child-themes/
 *
 * @package BlogShammir_Child
 */

/**
 * Enqueue scripts and styles.
 */
function blogshammir_child_enqueue_styles() {
	wp_enqueue_style( 
		'blogshammir-parent-style', 
		get_parent_theme_file_uri( '/style.css' ) 
	);
}
add_action( 'wp_enqueue_scripts', 'blogshammir_child_enqueue_styles' );
