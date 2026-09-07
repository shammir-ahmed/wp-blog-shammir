<?php

/**
 * Template parts.
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

/**
 * Adds the meta tag to the site header.
 *
 * @since 1.0.0
 */
function blogshammir_meta_viewport() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
}
add_action( 'wp_head', 'blogshammir_meta_viewport', 1 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 *
 * @since 1.0.0
 */
function blogshammir_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'blogshammir_pingback_header' );

/**
 * Adds the meta tag for website accent color.
 *
 * @since 1.0.0
 */
function blogshammir_meta_theme_color() {

	$color = blogshammir_option( 'accent_color' );

	if ( $color ) {
		printf( '<meta name="theme-color" content="%s">', esc_attr( $color ) );
	}
}
add_action( 'wp_head', 'blogshammir_meta_theme_color' );

/**
 * Outputs the theme top bar area.
 *
 * @since 1.0.0
 */
function blogshammir_topbar_output() {

	if ( ! blogshammir_is_top_bar_displayed() ) {
		return;
	}

	get_template_part( 'template-parts/topbar/topbar' );
}
add_action( 'blogshammir_header', 'blogshammir_topbar_output', 10 );

/**
 * Outputs the top bar widgets.
 *
 * @since 1.0.0
 * @param string $location Widget location in top bar.
 */
function blogshammir_topbar_widgets_output( $location ) {

	do_action( 'blogshammir_top_bar_widgets_before_' . $location );

	$blogshammir_top_bar_widgets = blogshammir_option( 'top_bar_widgets' );

	if ( is_array( $blogshammir_top_bar_widgets ) && ! empty( $blogshammir_top_bar_widgets ) ) {
		foreach ( $blogshammir_top_bar_widgets as $widget ) {

			if ( ! isset( $widget['values'] ) ) {
				continue;
			}

			if ( $location !== $widget['values']['location'] ) {
				continue;
			}

			if ( function_exists( 'blogshammir_top_bar_widget_' . $widget['type'] ) ) {

				$classes   = array();
				$classes[] = 'blogshammir-topbar-widget__' . esc_attr( $widget['type'] );
				$classes[] = 'blogshammir-topbar-widget';

				if ( isset( $widget['values']['visibility'] ) && $widget['values']['visibility'] ) {
					$classes[] = 'blogshammir-' . esc_attr( $widget['values']['visibility'] );
				}

				$classes = apply_filters( 'blogshammir_topbar_widget_classes', $classes, $widget );
				$classes = trim( implode( ' ', $classes ) );

				printf( '<div class="%s">', esc_attr( $classes ) );
				call_user_func( 'blogshammir_top_bar_widget_' . $widget['type'], $widget['values'] );
				printf( '</div><!-- END .blogshammir-topbar-widget -->' );
			}
		}
	}

	do_action( 'blogshammir_top_bar_widgets_after_' . $location );
}
add_action( 'blogshammir_topbar_widgets', 'blogshammir_topbar_widgets_output' );

/**
 * Outputs the theme header area.
 *
 * @since 1.0.0
 */
function blogshammir_header_output() {

	if ( ! blogshammir_is_header_displayed() ) {
		return;
	}

	get_template_part( 'template-parts/header/base' );
}
add_action( 'blogshammir_header', 'blogshammir_header_output', 20 );

/**
 * Outputs the header widgets in Header Widget Locations.
 *
 * @since 1.0.0
 * @param string $locations Widget location.
 */
function blogshammir_header_widgets( $locations ) {

	$locations   = (array) $locations;
	$all_widgets = (array) blogshammir_option( 'header_widgets' );

	blogshammir_header_widget_output( $locations, $all_widgets );
}
add_action( 'blogshammir_header_widget_location', 'blogshammir_header_widgets', 1 );

/**
 * Outputs the header widgets in Header Navigation Widget Locations.
 *
 * @since 1.0.0
 * @param string $locations Widget location.
 */
function blogshammir_header_navigation_widgets( $locations ) {

	$locations   = (array) $locations;
	$all_widgets = (array) blogshammir_option( 'header_navigation_widgets' );

	blogshammir_header_widget_output( $locations, $all_widgets );
}
add_action( 'blogshammir_header_navigation_widget_location', 'blogshammir_header_navigation_widgets', 1 );

/**
 * Outputs the content of theme header.
 *
 * @since 1.0.0
 */
function blogshammir_header_content_output() {

	// Get the selected header layout from Customizer.
	$header_layout = blogshammir_option( 'header_layout' );

	?>
	<div id="blogshammir-header-inner">
		<?php

		// Load header layout template.
		get_template_part( 'template-parts/header/header', $header_layout );

		?>
	</div><!-- END #blogshammir-header-inner -->
	<?php
}
add_action( 'blogshammir_header_content', 'blogshammir_header_content_output' );

/**
 * Outputs the main footer area.
 *
 * @since 1.0.0
 */
function blogshammir_footer_output() {

	if ( ! blogshammir_is_footer_displayed() ) {
		return;
	}

	get_template_part( 'template-parts/footer/base' );
}
add_action( 'blogshammir_footer', 'blogshammir_footer_output', 20 );

/**
 * Outputs the copyright area.
 *
 * @since 1.0.0
 */
function blogshammir_copyright_bar_output() {

	if ( ! blogshammir_is_copyright_bar_displayed() ) {
		return;
	}

	get_template_part( 'template-parts/footer/copyright/copyright' );
}
add_action( 'blogshammir_footer', 'blogshammir_copyright_bar_output', 30 );

/**
 * Outputs the copyright widgets.
 *
 * @since 1.0.0
 * @param string $location Widget location in copyright.
 */
function blogshammir_copyright_widgets_output( $location ) {

	do_action( 'blogshammir_copyright_widgets_before_' . $location );

	$blogshammir_widgets = blogshammir_option( 'copyright_widgets' );

	if ( is_array( $blogshammir_widgets ) && ! empty( $blogshammir_widgets ) ) {
		foreach ( $blogshammir_widgets as $widget ) {

			if ( ! isset( $widget['values'] ) ) {
				continue;
			}

			if ( isset( $widget['values'], $widget['values']['location'] ) && $location !== $widget['values']['location'] ) {
				continue;
			}

			if ( function_exists( 'blogshammir_copyright_widget_' . $widget['type'] ) ) {

				$classes   = array();
				$classes[] = 'blogshammir-copyright-widget__' . esc_attr( $widget['type'] );
				$classes[] = 'blogshammir-copyright-widget';

				if ( isset( $widget['values']['visibility'] ) && $widget['values']['visibility'] ) {
					$classes[] = 'blogshammir-' . esc_attr( $widget['values']['visibility'] );
				}

				$classes = apply_filters( 'blogshammir_copyright_widget_classes', $classes, $widget );
				$classes = trim( implode( ' ', $classes ) );

				printf( '<div class="%s">', esc_attr( $classes ) );
				call_user_func( 'blogshammir_copyright_widget_' . $widget['type'], $widget['values'] );
				printf( '</div><!-- END .blogshammir-copyright-widget -->' );
			}
		}
	}

	do_action( 'blogshammir_copyright_widgets_after_' . $location );
}
add_action( 'blogshammir_copyright_widgets', 'blogshammir_copyright_widgets_output' );

/**
 * Outputs the theme sidebar area.
 *
 * @since 1.0.0
 */
function blogshammir_sidebar_output() {

	if ( blogshammir_is_sidebar_displayed() ) {
		get_sidebar();
	}
}
add_action( 'blogshammir_sidebar', 'blogshammir_sidebar_output' );

/**
 * Outputs the back to top button.
 *
 * @since 1.0.0
 */
function blogshammir_back_to_top_output() {

	if ( ! blogshammir_option( 'scroll_top' ) ) {
		return;
	}

	get_template_part( 'template-parts/misc/back-to-top' );
}
add_action( 'blogshammir_after_page_wrapper', 'blogshammir_back_to_top_output' );

/**
 * Outputs the cursor dot.
 *
 * @since 1.0.0
 */
function blogshammir_cursor_dot_output() {

	if ( ! blogshammir_option( 'enable_cursor_dot' ) ) {
		return;
	}

	get_template_part( 'template-parts/misc/cursor-dot' );
}
add_action( 'blogshammir_after_page_wrapper', 'blogshammir_cursor_dot_output' );

/**
 * Outputs the theme page content.
 *
 * @since 1.0.0
 */
function blogshammir_page_header_template() {

	do_action( 'blogshammir_before_page_header' );

	if ( blogshammir_is_page_header_displayed() ) {
		if ( is_singular( 'post' ) ) {
			get_template_part( 'template-parts/header-page-title-single' );
		} else {
			get_template_part( 'template-parts/header-page-title' );
		}
	}

	do_action( 'blogshammir_after_page_header' );
}
add_action( 'blogshammir_page_header', 'blogshammir_page_header_template' );


/**
 * Outputs the theme Ticker News content.
 *
 * @since 1.0.0
 */
function blogshammir_blog_ticker() {

	if ( ! blogshammir_is_ticker_displayed() ) {
		return;
	}

	do_action( 'blogshammir_before_ticker' );

	// Enqueue Blogshammir Marquee script.
	if ( 'one-ticker' === blogshammir_option( 'ticker_type' ) ) {
		wp_enqueue_script( 'blogshammir-marquee' );
	}

	?>
	<div id="ticker">
		<?php get_template_part( 'template-parts/ticker/ticker' ); ?>
	</div><!-- END #ticker -->
	<?php

	do_action( 'blogshammir_after_ticker' );
}
add_action( 'blogshammir_after_masthead', 'blogshammir_blog_ticker', 29 );


/**
 * Outputs the theme blog hero content.
 *
 * @since 1.0.0
 */
function blogshammir_blog_hero() {

	if ( ! blogshammir_is_hero_displayed() ) {
		return;
	}

	// Hero type.
	$hero_type = blogshammir_option( 'hero_type' );

	do_action( 'blogshammir_before_hero' );

	// Enqueue Blogshammir Slider script.
	wp_enqueue_script( 'blogshammir-slider' );

	?>
	<div id="hero">
		<?php
			get_template_part( 'template-parts/hero/hero', $hero_type );
		?>
	</div><!-- END #hero -->
	<?php

	do_action( 'blogshammir_after_hero' );
}
add_action( 'blogshammir_after_masthead', 'blogshammir_blog_hero', 30 );


/**
 * Outputs the theme Blog Featured Links content.
 *
 * @since 1.0.0
 */
function blogshammir_blog_featured_links() {

	if ( ! blogshammir_is_featured_links_displayed() ) {
		return;
	}

	// Featured links type.
	$blogshammir_featured_links_type = blogshammir_option( 'featured_links_type' );

	$blogshammir_featured_links = blogshammir_option( 'featured_links' );

	// No items found.
	if ( ! $blogshammir_featured_links ) {
		return;
	}

	$features = array();

	foreach ( $blogshammir_featured_links as $blogshammir_featured_link ) {
		$features[] = array(
			'link'  => $blogshammir_featured_link['link'],
			'image' => $blogshammir_featured_link['image'],
		);
	}

	do_action( 'blogshammir_before_featured_links' );

	?>
	<div id="featured_links">
		<?php get_template_part( 'template-parts/featured-links/featured-links', $blogshammir_featured_links_type, array( 'features' => $features ) ); ?>
	</div><!-- END #featured_links -->
	<?php

	do_action( 'blogshammir_after_featured_links' );
}
add_action( 'blogshammir_after_masthead', 'blogshammir_blog_featured_links', 31 );


/**
 * Outputs the theme Blog PYML content.
 *
 * @since 1.0.0
 */
function blogshammir_blog_pyml() {

	if ( ! blogshammir_is_pyml_displayed() ) {
		return;
	}

	$pyml_type = blogshammir_option( 'pyml_type' );

	do_action( 'blogshammir_before_pyml' );

	?>
	<div id="pyml">
		<?php get_template_part( 'template-parts/pyml/pyml', $pyml_type ); ?>
	</div><!-- END #pyml -->
	<?php

	do_action( 'blogshammir_after_pyml' );
}
add_action( 'blogshammir_after_container', 'blogshammir_blog_pyml', 32 );


/**
 * Outputs the theme Body Animation.
 *
 * @since 1.0.0
 */
function blogshammir_body_animation() {

	$body_animation_option = blogshammir_option( 'body_animation' );

	if ( '0' === $body_animation_option ) {
		return;
	}

	do_action( 'blogshammir_before_body_animation' );
	?>
	<?php if ( '1' === $body_animation_option ) : ?>
	<div class="blogshammir-glassmorphism">
		<span class="block one"></span>
		<span class="block two"></span>
	</div>
		<?php
	endif;
	do_action( 'blogshammir_after_body_animation' );
}
add_action( 'blogshammir_main_end', 'blogshammir_body_animation', 33 );

function blogshammir_blog_heading_content() {

	if ( $blog_heading = blogshammir_option( 'blog_heading' ) ) {
		echo '<div id="blogshammir-blog-heading">';
		echo wp_kses( $blog_heading, blogshammir_get_allowed_html_tags() );
		echo '</div>';
	}
}
add_action( 'blogshammir_blog_heading', 'blogshammir_blog_heading_content' );

/**
 * Outputs the queried articles.
 *
 * @since 1.0.0
 */
function blogshammir_content() {
	global $wp_query;
	$blogshammir_blog_layout        = blogshammir_option( 'blog_masonry' ) ? 'masonries' : '';
	$blogshammir_blog_layout_column = 12;

	if ( blogshammir_option( 'blog_layout' ) != 'blog-horizontal' ) :
		$blogshammir_blog_layout_column = blogshammir_option( 'blog_layout_column' );
	endif;

	if ( have_posts() ) :

		if ( is_home() ) {
			do_action( 'blogshammir_blog_heading' );
		}
		echo '<div class="blogshammir-flex-row g-4 ' . $blogshammir_blog_layout . '">';

		$ads_info = blogshammir_algorithm_to_push_ads_in_archive();
		$count    = 0;
		while ( have_posts() ) :
			the_post();

			if ( is_array( $ads_info ) && ! is_null( $ads_info['ads_to_render'] ) ) :
				if ( in_array( $wp_query->current_post, $ads_info['random_numbers'] ) ) :
					echo '<div class="col-md-' . $blogshammir_blog_layout_column . ' col-sm-' . $blogshammir_blog_layout_column . ' col-xs-12">';
					blogshammir_random_post_archive_advertisement_part( is_array( $ads_info['ads_to_render'] ) ? $ads_info['ads_to_render'][ $count ] : $ads_info['ads_to_render'] );
					echo '</div>';
					$count++;
				endif;
			endif;

			echo '<div class="col-md-' . $blogshammir_blog_layout_column . ' col-sm-' . $blogshammir_blog_layout_column . ' col-xs-12">';
			get_template_part( 'template-parts/content/content', blogshammir_get_article_feed_layout() );
			echo '</div>';
		endwhile;
		echo '</div>';
		blogshammir_pagination();

	else :
		get_template_part( 'template-parts/content/content', 'none' );
	endif;
}
add_action( 'blogshammir_content', 'blogshammir_content' );
add_action( 'blogshammir_content_archive', 'blogshammir_content' );
add_action( 'blogshammir_content_search', 'blogshammir_content' );

/**
 * Outputs the theme single content.
 *
 * @since 1.0.0
 */
function blogshammir_content_singular() {

	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();

			if ( is_singular( 'post' ) ) {
				do_action( 'blogshammir_content_single' );
			} else {
				do_action( 'blogshammir_content_page' );
			}

		endwhile;
	else :
		get_template_part( 'template-parts/content/content', 'none' );
	endif;
}
add_action( 'blogshammir_content_singular', 'blogshammir_content_singular' );


/**
 * Outputs the theme 404 page content.
 *
 * @since 1.0.0
 */
function blogshammir_404_page_content() {

	get_template_part( 'template-parts/content/content', '404' );
}
add_action( 'blogshammir_content_404', 'blogshammir_404_page_content' );

/**
 * Outputs the theme page content.
 *
 * @since 1.0.0
 */
function blogshammir_content_page() {

	get_template_part( 'template-parts/content/content', 'page' );
}
add_action( 'blogshammir_content_page', 'blogshammir_content_page' );

/**
 * Outputs the theme single post content.
 *
 * @since 1.0.0
 */
function blogshammir_content_single() {

	get_template_part( 'template-parts/content/content', 'single' );
}
add_action( 'blogshammir_content_single', 'blogshammir_content_single' );

/**
 * Outputs the comments template.
 *
 * @since 1.0.0
 */
function blogshammir_output_related_posts() {

	if ( 'post' == get_post_type() ) {
		get_template_part( 'template-parts/related-posts/related', 'posts' );
	}
}
add_action( 'blogshammir_after_singular', 'blogshammir_output_related_posts' );

/**
 * Outputs the comments template.
 *
 * @since 1.0.0
 */
function blogshammir_output_comments() {
	comments_template();
}
add_action( 'blogshammir_after_singular', 'blogshammir_output_comments' );

/**
 * Outputs the theme archive page info.
 *
 * @since 1.0.0
 */
function blogshammir_archive_info() {

	// Author info.
	if ( is_author() ) {
		get_template_part( 'template-parts/entry/entry', 'about-author' );
	}
}
add_action( 'blogshammir_before_content', 'blogshammir_archive_info' );

/**
 * Outputs more posts button to author description box.
 *
 * @since 1.0.0
 */
function blogshammir_add_author_posts_button() {
	if ( ! is_author() ) {
		get_template_part( 'template-parts/entry/entry', 'author-posts-button' );
	}
}
add_action( 'blogshammir_entry_after_author_description', 'blogshammir_add_author_posts_button' );

/**
 * Outputs Comments Toggle button.
 *
 * @since 1.0.0
 */
function blogshammir_comments_toggle() {

	if ( blogshammir_comments_toggle_displayed() ) {
		get_template_part( 'template-parts/entry/entry-show-comments' );
	}
}
add_action( 'blogshammir_before_comments', 'blogshammir_comments_toggle' );

/**
 * Outputs Page Preloader.
 *
 * @since 1.0.0
 */
function blogshammir_preloader() {

	if ( ! blogshammir_is_preloader_displayed() ) {
		return;
	}

	get_template_part( 'template-parts/preloader/base' );
}
add_action( 'blogshammir_before_page_wrapper', 'blogshammir_preloader' );

/**
 * Outputs breadcrumbs after header.
 *
 * @since  1.0.0
 * @return void
 */
function blogshammir_breadcrumb_after_header_output() {

	if ( 'below-header' === blogshammir_option( 'breadcrumbs_position' ) && blogshammir_has_breadcrumbs() ) {

		$alignment = 'blogshammir-text-align-' . blogshammir_option( 'breadcrumbs_alignment' );

		$args = array(
			'container_before' => '<div class="blogshammir-breadcrumbs"><div class="blogshammir-container ' . $alignment . '">',
			'container_after'  => '</div></div>',
		);

		blogshammir_breadcrumb( $args );
	}
}
add_action( 'blogshammir_main_start', 'blogshammir_breadcrumb_after_header_output' );

/**
 * Outputs breadcumbs in page header.
 *
 * @since  1.0.0
 * @return void
 */
function blogshammir_breadcrumb_page_header_output() {

	if ( blogshammir_page_header_has_breadcrumbs() ) {

		if ( is_singular( 'post' ) ) {
			$args = array(
				'container_before' => '<div class="blogshammir-container blogshammir-breadcrumbs">',
				'container_after'  => '</div>',
			);
		} else {
			$args = array(
				'container_before' => '<div class="blogshammir-breadcrumbs">',
				'container_after'  => '</div>',
			);
		}

		blogshammir_breadcrumb( $args );
	}
}
add_action( 'blogshammir_page_header_end', 'blogshammir_breadcrumb_page_header_output' );

/**
 * Output the main navigation template.
 */
function blogshammir_main_navigation_template() {
	get_template_part( 'template-parts/header/navigation' );
}

/**
 * Output the Header logo template.
 */
function blogshammir_header_logo_template() {
	get_template_part( 'template-parts/header/logo' );
}

function blogshammir_about_button() {
	$button_widgets = blogshammir_option( 'about_widgets' );

	if ( empty( $button_widgets ) ) {
		return;
	}
	foreach ( $button_widgets as $widget ) {
		call_user_func( 'blogshammir_about_widget_' . $widget['type'], $widget['values'] );
	}
}

function blogshammir_cta_widgets() {
	$widgets = blogshammir_option( 'cta_widgets' );

	if ( empty( $widgets ) ) {
		return;
	}
	foreach ( $widgets as $widget ) {
		call_user_func( 'blogshammir_cta_widget_' . $widget['type'], $widget['values'] );
	}
}

function blogshammir_advertisement_part( $arg = '' ) {

	if ( $arg === '' ) {
		return;
	}

	$ad_widgets = blogshammir_option( 'ad_widgets' );

	// get all array elements from $ad_widgets in which 'display_area' key has value $arg = 'before_post_content'
	$arr_widgets = array_filter(
		$ad_widgets,
		function( $widget ) use ( $arg ) {
			return isset( $widget['values']['display_area'] ) && in_array( $arg, $widget['values']['display_area'] );
		}
	);

	if ( ! empty( $arr_widgets ) ) :
		foreach ( $arr_widgets as $widget ) {
			if ( function_exists( 'blogshammir_ad_widget_' . $widget['type'] ) ) {
				$classes   = array();
				$classes[] = 'blogshammir-promo-widget__' . blogshammir_get_promo_widget_type_class( $widget['type'] );
				$classes[] = 'blogshammir-promo-widget';

				if ( isset( $widget['values']['visibility'] ) && $widget['values']['visibility'] ) {
					$classes[] = 'blogshammir-' . esc_attr( $widget['values']['visibility'] );
				}

				$classes = apply_filters( 'blogshammir_ad_widget_classes', $classes, $widget );
				$classes = trim( implode( ' ', $classes ) );

				printf( '<div class="%s">', esc_attr( $classes ) );
				call_user_func( 'blogshammir_ad_widget_' . $widget['type'], $widget['values'] );
				printf( '</div>' );
			}
		}
	endif;

}
add_action( 'blogshammir_before_single_content', 'blogshammir_advertisement_part', 10, 1 );
add_action( 'blogshammir_after_single_content', 'blogshammir_advertisement_part', 10, 1 );
add_action( 'blogshammir_before_masthead', 'blogshammir_advertisement_part', 10, 1 );
add_action( 'blogshammir_after_masthead', 'blogshammir_advertisement_part', 10, 1 );
add_action( 'blogshammir_before_colophon', 'blogshammir_advertisement_part', 10, 1 );
add_action( 'blogshammir_after_colophon', 'blogshammir_advertisement_part', 10, 1 );
add_action( 'blogshammir_header_4_ad', 'blogshammir_advertisement_part', 10, 1 );
add_action( 'blogshammir_before_content_area', 'blogshammir_advertisement_part', 10, 1 );


