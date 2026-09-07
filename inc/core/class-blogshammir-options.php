<?php

/**
 * Blogshammir Options Class.
 *
 * @package  Blogshammir
 * @author   Md Shammir Ahmed
 * @since    1.0.0
 */

/**
 * Do not allow direct script access.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Blogshammir_Options' ) ) :

	/**
	 * Blogshammir Options Class.
	 */
	class Blogshammir_Options {

		/**
		 * Singleton instance of the class.
		 *
		 * @since 1.0.0
		 * @var object
		 */
		private static $instance;

		/**
		 * Options variable.
		 *
		 * @since 1.0.0
		 * @var mixed $options
		 */
		private static $options;

		/**
		 * Main Blogshammir_Options Instance.
		 *
		 * @since 1.0.0
		 * @return Blogshammir_Options
		 */
		public static function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Blogshammir_Options ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Primary class constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Refresh options.
			add_action( 'after_setup_theme', array( $this, 'refresh' ) );
		}

		/**
		 * Set default option values.
		 *
		 * @since  1.0.0
		 * @return array Default values.
		 */
		public function get_defaults() {

			$categories                        = get_categories( array( 'hide_empty' => 1 ) );
			$blogshammir_categories_color_options = array();
			foreach ( $categories as $category ) {
				$blogshammir_categories_color_options[ 'blogshammir_category_color_' . $category->term_id ] = '#F43676';
			}

			$defaults = array(

				/**
				 * General Settings.
				 */

				// Layout.
				'blogshammir_site_layout'                     => 'fw-contained',
				'blogshammir_container_width'                 => 1480,

				// Base Colors.
				'blogshammir_accent_color'                    => '#F43676',
				'blogshammir_dark_mode'                       => false,
				'blogshammir_body_animation'                  => '1',
				'blogshammir_content_text_color'              => '#002050',
				'blogshammir_headings_color'                  => '#302D55',
				'blogshammir_content_link_hover_color'        => '#302D55',
				'blogshammir_body_background_heading'         => true,
				'blogshammir_content_background_heading'      => true,
				'blogshammir_boxed_content_background_color'  => '#FFFFFF',
				'blogshammir_scroll_top_visibility'           => 'all',

				// Base Typography.
				'blogshammir_html_base_font_size'             => array(
					'desktop' => 62.5,
					'tablet'  => 53,
					'mobile'  => 50,
				),
				'blogshammir_font_smoothing'                  => true,
				'blogshammir_typography_body_heading'         => false,
				'blogshammir_typography_headings_heading'     => false,
				'blogshammir_body_font'                       => blogshammir_typography_defaults(
					array(
						'font-family'         => 'Be Vietnam Pro',
						'font-weight'         => 400,
						'font-size-desktop'   => '1.7',
						'font-size-unit'      => 'rem',
						'line-height-desktop' => '1.75',
					)
				),
				'blogshammir_headings_font'                   => blogshammir_typography_defaults(
					array(
						'font-family'     => 'Be Vietnam Pro',
						'font-weight'     => 700,
						'font-style'      => 'normal',
						'text-transform'  => 'none',
						'text-decoration' => 'none',
					)
				),
				'blogshammir_h1_font'                         => blogshammir_typography_defaults(
					array(
						'font-weight'         => 700,
						'font-size-desktop'   => '4',
						'font-size-unit'      => 'rem',
						'line-height-desktop' => '1.4',
					)
				),
				'blogshammir_h2_font'                         => blogshammir_typography_defaults(
					array(
						'font-weight'         => 700,
						'font-size-desktop'   => '3.6',
						'font-size-unit'      => 'rem',
						'line-height-desktop' => '1.4',
					)
				),
				'blogshammir_h3_font'                         => blogshammir_typography_defaults(
					array(
						'font-weight'         => 700,
						'font-size-desktop'   => '2.8',
						'font-size-unit'      => 'rem',
						'line-height-desktop' => '1.4',
					)
				),
				'blogshammir_h4_font'                         => blogshammir_typography_defaults(
					array(
						'font-weight'         => 700,
						'font-size-desktop'   => '2.4',
						'font-size-unit'      => 'rem',
						'line-height-desktop' => '1.4',
					)
				),
				'blogshammir_h5_font'                         => blogshammir_typography_defaults(
					array(
						'font-weight'         => 700,
						'font-size-desktop'   => '2',
						'font-size-unit'      => 'rem',
						'line-height-desktop' => '1.4',
					)
				),
				'blogshammir_h6_font'                         => blogshammir_typography_defaults(
					array(
						'font-weight'         => 600,
						'font-size-desktop'   => '1.8',
						'font-size-unit'      => 'rem',
						'line-height-desktop' => '1.72',
					)
				),
				'blogshammir_heading_em_font'                 => blogshammir_typography_defaults(
					array(
						'font-family' => 'Playfair Display',
						'font-weight' => 'inherit',
						'font-style'  => 'italic',
					)
				),
				'blogshammir_section_heading_style'           => '1',
				'blogshammir_footer_widget_title_font_size'   => array(
					'desktop' => 2,
					'unit'    => 'rem',
				),

				// Primary Button.
				'blogshammir_primary_button_heading'          => false,
				'blogshammir_primary_button_bg_color'         => '',
				'blogshammir_primary_button_hover_bg_color'   => '',
				'blogshammir_primary_button_text_color'       => '#fff',
				'blogshammir_primary_button_hover_text_color' => '#fff',
				'blogshammir_primary_button_border_radius'    => array(
					'top-left'     => '0.8',
					'top-right'    => '0.8',
					'bottom-right' => '0.8',
					'bottom-left'  => '0.8',
					'unit'         => 'rem',
				),
				'blogshammir_primary_button_border_width'     => 0.1,
				'blogshammir_primary_button_border_color'     => 'rgba(0, 0, 0, 0.12)',
				'blogshammir_primary_button_hover_border_color' => 'rgba(0, 0, 0, 0.12)',
				'blogshammir_primary_button_typography'       => blogshammir_typography_defaults(
					array(
						'font-family'         => 'Be Vietnam Pro',
						'font-weight'         => 500,
						'font-size-desktop'   => '1.8',
						'font-size-unit'      => 'rem',
						'line-height-desktop' => '',
					)
				),

				// Secondary Button.
				'blogshammir_secondary_button_heading'        => false,
				'blogshammir_secondary_button_bg_color'       => '#302D55',
				'blogshammir_secondary_button_hover_bg_color' => '#002050',
				'blogshammir_secondary_button_text_color'     => '#FFFFFF',
				'blogshammir_secondary_button_hover_text_color' => '#FFFFFF',
				'blogshammir_secondary_button_border_radius'  => array(
					'top-left'     => '',
					'top-right'    => '',
					'bottom-right' => '',
					'bottom-left'  => '',
					'unit'         => 'rem',
				),
				'blogshammir_secondary_button_border_width'   => .1,
				'blogshammir_secondary_button_border_color'   => 'rgba(0, 0, 0, 0.12)',
				'blogshammir_secondary_button_hover_border_color' => 'rgba(0, 0, 0, 0.12)',
				'blogshammir_secondary_button_typography'     => blogshammir_typography_defaults(
					array(
						'font-family'         => 'Be Vietnam Pro',
						'font-weight'         => 500,
						'font-size-desktop'   => '1.8',
						'font-size-unit'      => 'rem',
						'line-height-desktop' => '1.6',
					)
				),

				// Text button.
				'blogshammir_text_button_heading'             => false,
				'blogshammir_text_button_text_color'          => '#302D55',
				'blogshammir_text_button_hover_text_color'    => '',
				'blogshammir_text_button_typography'          => blogshammir_typography_defaults(
					array(
						'font-family'         => 'Be Vietnam Pro',
						'font-weight'         => 500,
						'font-size-desktop'   => '1.6',
						'font-size-unit'      => 'rem',
						'line-height-desktop' => '1.5',
					)
				),

				// Misc Settings.
				'blogshammir_enable_schema'                   => true,
				'blogshammir_custom_input_style'              => true,
				'blogshammir_preloader_heading'               => false,
				'blogshammir_preloader'                       => false,
				'blogshammir_preloader_style'                 => '1',
				'blogshammir_preloader_visibility'            => 'all',
				'blogshammir_scroll_top_heading'              => false,
				'blogshammir_scroll_top'                      => true,
				'blogshammir_scroll_top_visibility'           => 'all',
				'blogshammir_cursor_dot_heading'              => false,
				'blogshammir_cursor_dot'                      => false,

				/**
				 * Logos & Site Title.
				 */
				'blogshammir_logo_default_retina'             => '',
				'blogshammir_logo_max_height'                 => array(
					'desktop' => 45,
				),
				'blogshammir_logo_margin'                     => array(
					'desktop' => array(
						'top'    => 27,
						'right'  => 10,
						'bottom' => 27,
						'left'   => 10,
					),
					'tablet'  => array(
						'top'    => 25,
						'right'  => 1,
						'bottom' => 25,
						'left'   => 0,
					),
					'mobile'  => array(
						'top'    => '',
						'right'  => '',
						'bottom' => '',
						'left'   => '',
					),
					'unit'    => 'px',
				),
				'blogshammir_display_tagline'                 => false,
				'blogshammir_logo_heading_site_identity'      => true,
				'blogshammir_typography_logo_heading'         => false,
				'blogshammir_logo_text_font_size'             => array(
					'desktop' => 3,
					'unit'    => 'rem',
				),

				/**
				 * Header.
				 */

				// Top Bar.
				'blogshammir_top_bar_enable'                  => false,
				'blogshammir_top_bar_container_width'         => 'content-width',
				'blogshammir_top_bar_visibility'              => 'all',
				'blogshammir_top_bar_heading_widgets'         => true,
				'blogshammir_top_bar_widgets'                 => array(
					array(
						'classname' => 'blogshammir_customizer_widget_text',
						'type'      => 'text',
						'values'    => array(
							'content'    => wp_kses( '<i class="far fa-calendar-alt fa-lg blogshammir-icon"></i><strong><span id="blogshammir-date"></span> - <span id="blogshammir-time"></span></strong>', blogshammir_get_allowed_html_tags() ),
							'location'   => 'left',
							'visibility' => 'all',
						),
					),
					array(
						'classname' => 'blogshammir_customizer_widget_text',
						'type'      => 'text',
						'values'    => array(
							'content'    => wp_kses( '<i class="far fa-location-arrow fa-lg blogshammir-icon"></i> Subscribe to our blogshammirter & never miss our best posts. <a href="#"><strong>Subscribe Now!</strong></a>', blogshammir_get_allowed_html_tags() ),
							'location'   => 'right',
							'visibility' => 'all',
						),
					),
				),
				'blogshammir_top_bar_widgets_separator'       => 'regular',
				'blogshammir_top_bar_heading_design_options'  => false,
				'blogshammir_top_bar_background'              => blogshammir_design_options_defaults(
					array(
						'background' => array(
							'color'    => array(
								'background-color' => 'rgba(247,229,183,0.35)',
							),
							'gradient' => array(
								'gradient-color-1' => 'rgba(247,229,183,0.35)',
								'gradient-color-2' => 'rgba(226,181,181,0.39)',
							),
						),
					)
				),
				'blogshammir_top_bar_text_color'              => blogshammir_design_options_defaults(
					array(
						'color' => array(
							'text-color'       => '#002050',
							'link-color'       => '#302D55',
							'link-hover-color' => '#F43676',
						),
					)
				),
				'blogshammir_top_bar_border'                  => blogshammir_design_options_defaults(
					array(
						'border' => array(
							'border-top-width' => '',
							'border-style'     => 'solid',
							'border-color'     => '',
							'separator-color'  => '#cccccc',
						),
					)
				),

				// Main Header.
				'blogshammir_header_layout'                   => 'layout-1',

				'blogshammir_header_container_width'          => 'content-width',
				'blogshammir_header_heading_widgets'          => true,
				'blogshammir_header_widgets'                  => array(
					array(
						'classname' => 'blogshammir_customizer_widget_socials',
						'type'      => 'socials',
						'values'    => array(
							'style'      => 'rounded-border',
							'size'       => 'standard',
							'location'   => 'left',
							'visibility' => 'hide-mobile-tablet',
						),
					),
					array(
						'classname' => 'blogshammir_customizer_widget_darkmode',
						'type'      => 'darkmode',
						'values'    => array(
							'style'      => 'rounded-border',
							'location'   => 'right',
							'visibility' => 'hide-mobile-tablet',
						),
					),
					array(
						'classname' => 'blogshammir_customizer_widget_search',
						'type'      => 'search',
						'values'    => array(
							'style'      => 'rounded-fill',
							'location'   => 'right',
							'visibility' => 'hide-mobile-tablet',
						),
					),
					array(
						'classname' => 'blogshammir_customizer_widget_button',
						'type'      => 'button',
						'values'    => array(
							'text'       => '<i class="far fa-bell mr-1 blogshammir-icon"></i> Subscribe',
							'url'        => '#',
							'class'      => 'btn-small',
							'target'     => '_self',
							'location'   => 'right',
							'visibility' => 'hide-mobile-tablet',
						),
					),
				),

				// Ad Widget
				'blogshammir_ad_widgets'                      => array(
					array(
						'classname' => 'blogshammir_customizer_widget_advertisements',
						'type'      => 'advertisements',
					),
				),

				'blogshammir_header_widgets_separator'        => 'none',
				'blogshammir_header_heading_design_options'   => false,
				'blogshammir_header_background'               => blogshammir_design_options_defaults(
					array(
						'background' => array(
							'color'    => array(
								'background-color' => '#FFFFFF',
							),
							'gradient' => array(),
							'image'    => array(),
						),
					)
				),
				'blogshammir_header_border'                   => blogshammir_design_options_defaults(
					array(
						'border' => array(
							'border-bottom-width' => 1,
							'border-color'        => 'rgba(185, 185, 185, 0.4)',
							'separator-color'     => '#cccccc',
						),
					)
				),
				'blogshammir_header_text_color'               => blogshammir_design_options_defaults(
					array(
						'color' => array(
							'text-color' => '#66717f',
							'link-color' => '#131315',
						),
					)
				),

				// Header navigation widgets
				'blogshammir_header_navigation_heading_widgets' => true,
				'blogshammir_header_navigation_widgets'       => array(),

				// Transparent Header.
				'blogshammir_tsp_header'                      => false,
				'blogshammir_tsp_header_disable_on'           => array(
					'404',
					'posts_page',
					'archive',
					'search',
				),

				// Sticky Header.
				'blogshammir_sticky_header'                   => false,
				'blogshammir_sticky_header_hide_on'           => array( '' ),

				// Main Navigation.
				'blogshammir_main_nav_heading_animation'      => false,
				'blogshammir_main_nav_hover_animation'        => 'underline',
				'blogshammir_main_nav_heading_sub_menus'      => true,
				'blogshammir_main_nav_sub_indicators'         => true,
				'blogshammir_main_nav_heading_mobile_menu'    => false,
				'blogshammir_main_nav_mobile_breakpoint'      => 960,
				'blogshammir_main_nav_mobile_label'           => '',
				'blogshammir_nav_design_options'              => false,
				'blogshammir_main_nav_background'             => blogshammir_design_options_defaults(
					array(
						'background' => array(
							'color'    => array(
								'background-color' => '#FFFFFF',
							),
							'gradient' => array(),
						),
					)
				),
				'blogshammir_main_nav_border'                 => blogshammir_design_options_defaults(
					array(
						'border' => array(
							'border-top-width'    => 1,
							'border-bottom-width' => 0,
							'border-style'        => 'solid',
							'border-color'        => 'rgba(185, 185, 185, 0.4)',
						),
					)
				),
				'blogshammir_main_nav_font_color'             => blogshammir_design_options_defaults(
					array(
						'color' => array(),
					)
				),
				'blogshammir_typography_main_nav_heading'     => false,
				'blogshammir_main_nav_font'                   => blogshammir_typography_defaults(
					array(
						'font-family'         => 'Inter Tight',
						'font-weight'         => 600,
						'font-size-desktop'   => '1.7',
						'font-size-unit'      => 'rem',
						'line-height-desktop' => '1.5',
					)
				),

				// Page Header.
				'blogshammir_page_header_enable'              => true,
				'blogshammir_page_header_alignment'           => 'left',
				'blogshammir_page_header_spacing'             => array(
					'desktop' => array(
						'top'    => 30,
						'bottom' => 30,
					),
					'tablet'  => array(
						'top'    => '',
						'bottom' => '',
					),
					'mobile'  => array(
						'top'    => '',
						'bottom' => '',
					),
					'unit'    => 'px',
				),
				'blogshammir_page_header_background'          => blogshammir_design_options_defaults(
					array(
						'background' => array(
							'color'    => array( 'background-color' => 'rgba(244,54,118,0.1)' ),
							'gradient' => array(),
							'image'    => array(),
						),
					)
				),
				'blogshammir_page_header_text_color'          => blogshammir_design_options_defaults(
					array(
						'color' => array(),
					)
				),
				'blogshammir_page_header_border'              => blogshammir_design_options_defaults(
					array(
						'border' => array(
							'border-bottom-width' => 1,
							'border-style'        => 'solid',
							'border-color'        => 'rgba(0,0,0,.062)',
						),
					)
				),
				'blogshammir_typography_page_header'          => false,
				'blogshammir_page_header_font_size'           => array(
					'desktop' => 2.6,
					'unit'    => 'rem',
				),

				// Breadcrumbs.
				'blogshammir_breadcrumbs_enable'              => true,
				'blogshammir_breadcrumbs_hide_on'             => array( 'home' ),
				'blogshammir_breadcrumbs_position'            => 'in-page-header',
				'blogshammir_breadcrumbs_alignment'           => 'left',
				'blogshammir_breadcrumbs_spacing'             => array(
					'desktop' => array(
						'top'    => 15,
						'bottom' => 15,
					),
					'tablet'  => array(
						'top'    => '',
						'bottom' => '',
					),
					'mobile'  => array(
						'top'    => '',
						'bottom' => '',
					),
					'unit'    => 'px',
				),
				'blogshammir_breadcrumbs_heading_design'      => false,
				'blogshammir_breadcrumbs_background'          => blogshammir_design_options_defaults(
					array(
						'background' => array(
							'color'    => array(),
							'gradient' => array(),
							'image'    => array(),
						),
					)
				),
				'blogshammir_breadcrumbs_text_color'          => blogshammir_design_options_defaults(
					array(
						'color' => array(),
					)
				),
				'blogshammir_breadcrumbs_border'              => blogshammir_design_options_defaults(
					array(
						'border' => array(
							'border-top-width'    => 0,
							'border-bottom-width' => 0,
							'border-color'        => '',
							'border-style'        => 'solid',
						),
					)
				),

				/**
				 * Hero.
				 */
				'blogshammir_enable_hero'                     => true,
				'blogshammir_hero_type'                       => 'horizontal-slider',
				'blogshammir_hero_slider_align'			   => 'center',
				'blogshammir_hero_enable_on'                  => array( 'home' ),
				'blogshammir_hero_slider'                     => false,
				'blogshammir_hero_slider_orderby'             => 'date-desc',
				'blogshammir_hero_slider_title_font_size'     => array(
					'desktop' => 2.4,
					'unit'    => 'rem',
				),
				'blogshammir_hero_slider_elements'            => array(
					'category'  => true,
					'meta'      => true,
					'read_more' => true,
				),
				'blogshammir_hero_entry_meta_elements'        => array(
					'author'   => true,
					'date'     => true,
					'comments' => false,
				),
				'blogshammir_hero_slider_posts'               => false,
				'blogshammir_hero_slider_post_number'         => 6,
				'blogshammir_hero_slider_category'            => array(),
				'blogshammir_hero_slider_read_more'           => esc_html__( 'Continue Reading', 'blogshammir' ),

				/**
				 * Featured Links
				 */
				'blogshammir_enable_featured_links'           => false,
				'blogshammir_featured_links_title'            => esc_html__( 'Today Best Trending Topics', 'blogshammir' ),
				'blogshammir_featured_links_enable_on'        => array( 'home' ),
				'blogshammir_featured_links_style'            => false,
				'blogshammir_featured_links_type'             => 'one',
				'blogshammir_featured_links_title_type'       => '1',
				'blogshammir_featured_links_card_border'      => true,
				'blogshammir_featured_links_card_shadow'      => true,
				'blogshammir_featured_links'                  => apply_filters(
					'blogshammir_featured_links_default',
					array(
						array(
							'link'  => '',
							'image' => array(),
						),
						array(
							'link'  => '',
							'image' => array(),
						),
						array(
							'link'  => '',
							'image' => array(),
						),
					),
				),

				/**
				 * PYML
				 */
				'blogshammir_enable_pyml'                     => true,
				'blogshammir_pyml_title'                      => esc_html__( 'You May Have Missed', 'blogshammir' ),
				'blogshammir_pyml_enable_on'                  => array( 'home' ),
				'blogshammir_pyml_style'                      => false,
				'blogshammir_pyml_type'                       => '1',
				'blogshammir_pyml_orderby'                    => 'date-desc',
				'blogshammir_pyml_card_border'                => true,
				'blogshammir_pyml_card_shadow'                => true,
				'blogshammir_pyml_elements'                   => array(
					'category' => true,
					'meta'     => true,
				),
				'blogshammir_pyml_posts'                      => true,
				'blogshammir_pyml_post_number'                => 4,
				'blogshammir_pyml_post_title_font_size'       => array(
					'desktop' => 2,
					'unit'    => 'rem',
				),
				'blogshammir_pyml_category'                   => array(),

				/**
				 * Ticker Slider
				 */
				'blogshammir_enable_ticker'                   => true,
				'blogshammir_ticker_title'                    => esc_html__( 'Top Stories', 'blogshammir' ),
				'blogshammir_ticker_enable_on'                => array( 'home' ),
				'blogshammir_ticker_type'                     => 'one-ticker',
				'blogshammir_ticker_elements'                 => array(
					'meta' => true,
				),
				'blogshammir_ticker_posts'                    => false,
				'blogshammir_ticker_post_number'              => 100,
				'blogshammir_ticker_category'                 => array(),

				/**
				 * Blog.
				 */

				// Blog Page / Archive.
				'blogshammir_blog_entry_elements'             => array(
					'thumbnail'      => true,
					'header'         => true,
					'meta'           => true,
					'summary'        => true,
					'summary-footer' => true,
				),
				'blogshammir_blog_entry_meta_elements'        => array(
					'author'   => true,
					'date'     => true,
					'category' => false,
					'tag'      => false,
					'comments' => false,
				),
				'blogshammir_related_posts'                   => false,
				'blogshammir_related_posts_enable'            => false,
				'blogshammir_related_posts_heading'           => esc_html__( 'Related posts', 'blogshammir' ),
				'blogshammir_related_post_number'             => 3,
				'blogshammir_related_posts_column'            => 4,
				'blogshammir_entry_meta_icons'                => true,
				'blogshammir_excerpt_length'                  => 30,
				'blogshammir_excerpt_more'                    => '&hellip;',
				'blogshammir_blog_layout'                     => 'blog-horizontal',
				'blogshammir_blog_image_wrap'                 => true,
				'blogshammir_blog_zig_zag'                    => false,
				'blogshammir_blog_masonry'                    => false,
				'blogshammir_blog_layout_column'              => 6,
				'blogshammir_blog_image_position'             => 'left',
				'blogshammir_blog_image_size'                 => 'large',
				'blogshammir_blog_card_border'                => true,
				'blogshammir_blog_card_shadow'                => true,
				'blogshammir_blog_heading'                    => '',
				'blogshammir_blog_read_more'                  => esc_html__( 'Read More', 'blogshammir' ),
				'blogshammir_blog_horizontal_post_categories' => true,
				'blogshammir_blog_horizontal_read_more'       => false,

				// Single Post.
				'blogshammir_single_post_layout_heading'      => false,
				'blogshammir_single_title_position'           => 'in-content',
				'blogshammir_single_title_alignment'          => 'left',
				'blogshammir_single_title_spacing'            => array(
					'desktop' => array(
						'top'    => 152,
						'bottom' => 100,
					),
					'tablet'  => array(
						'top'    => 90,
						'bottom' => 55,
					),
					'mobile'  => array(
						'top'    => '',
						'bottom' => '',
					),
					'unit'    => 'px',
				),
				'blogshammir_single_content_width'            => 'wide',
				'blogshammir_single_narrow_container_width'   => 700,
				'blogshammir_single_post_elements_heading'    => false,
				'blogshammir_single_post_meta_elements'       => array(
					'author'   => true,
					'date'     => true,
					'comments' => true,
					'category' => false,
				),
				'blogshammir_single_post_thumb'               => true,
				'blogshammir_single_post_categories'          => true,
				'blogshammir_single_post_tags'                => true,
				'blogshammir_single_last_updated'             => true,
				'blogshammir_single_about_author'             => true,
				'blogshammir_single_post_next_prev'           => true,
				'blogshammir_single_post_elements'            => array(
					'thumb'          => true,
					'category'       => true,
					'tags'           => true,
					'last-updated'   => true,
					'about-author'   => true,
					'prev-next-post' => true,
				),
				'blogshammir_single_toggle_comments'          => false,
				'blogshammir_single_entry_meta_icons'         => true,
				'blogshammir_typography_single_post_heading'  => false,
				'blogshammir_single_content_font_size'        => array(
					'desktop' => '1.6',
					'unit'    => 'rem',
				),

				/**
				 * Sidebar.
				 */

				'blogshammir_sidebar_position'                => 'right-sidebar',
				'blogshammir_single_post_sidebar_position'    => 'default',
				'blogshammir_single_page_sidebar_position'    => 'default',
				'blogshammir_archive_sidebar_position'        => 'default',
				'blogshammir_sidebar_options_heading'         => false,
				'blogshammir_sidebar_style'                   => '2',
				'blogshammir_sidebar_width'                   => 30,
				'blogshammir_sidebar_sticky'                  => 'sidebar',
				'blogshammir_typography_sidebar_heading'      => false,
				'blogshammir_sidebar_widget_title_font_size'  => array(
					'desktop' => 2.4,
					'unit'    => 'rem',
				),

				/**
				 * Footer.
				 */

				// Copyright.
				'blogshammir_enable_copyright'                => true,
				'blogshammir_copyright_layout'                => 'layout-1',
				'blogshammir_copyright_separator'             => 'contained-separator',
				'blogshammir_copyright_visibility'            => 'all',
				'blogshammir_copyright_heading_widgets'       => true,
				'blogshammir_copyright_widgets'               => array(
					array(
						'classname' => 'blogshammir_customizer_widget_text',
						'type'      => 'text',
						'values'    => array(
							'content'    => wp_kses( 'Copyright {{the_year}} &mdash; <b>{{site_title}}</b>. All rights reserved. <b>{{theme_link}}</b>', blogshammir_get_allowed_html_tags() ),
							// 'content'    => esc_html__( '', 'blogshammir' ),
							'location'   => 'start',
							'visibility' => 'all',
						),
					),
				),
				'blogshammir_copyright_heading_design_options' => false,
				'blogshammir_copyright_background'            => blogshammir_design_options_defaults(
					array(
						'background' => array(
							'color'    => array(
								'background-color' => '',
							),
							'gradient' => array(),
						),
					)
				),
				'blogshammir_copyright_text_color'            => blogshammir_design_options_defaults(
					array(
						'color' => array(
							'text-color'       => '#d9d9d9',
							'link-color'       => '#ffffff',
							'link-hover-color' => '#F43676',
						),
					)
				),

				// Main Footer.
				'blogshammir_enable_footer'                   => true,
				'blogshammir_footer_layout'                   => 'layout-2',
				'blogshammir_footer_widgets_align_center'     => false,
				'blogshammir_footer_visibility'               => 'all',
				'blogshammir_footer_widget_heading_style'     => '0',
				'blogshammir_footer_heading_design_options'   => false,
				'blogshammir_footer_background'               => blogshammir_design_options_defaults(
					array(
						'background' => array(
							'color'    => array(
								'background-color' => '#302d55',
							),
							'gradient' => array(),
							'image'    => array(),
						),
					)
				),
				'blogshammir_footer_text_color'               => blogshammir_design_options_defaults(
					array(
						'color' => array(
							'text-color'         => '#d9d9d9',
							'link-color'         => '#d9d9d9',
							'link-hover-color'   => '#F43676',
							'widget-title-color' => '#ffffff',
						),
					)
				),
				'blogshammir_footer_border'                   => blogshammir_design_options_defaults(
					array(
						'border' => array(
							'border-top-width'    => 1,
							'border-bottom-width' => 0,
							'border-color'        => 'rgba(255,255,255,0.1)',
							'border-style'        => 'solid',
						),
					)
				),
				'blogshammir_typography_main_footer_heading'  => false,
			);

			$defaults = array_merge( $defaults, $blogshammir_categories_color_options );

			$defaults = apply_filters( 'blogshammir_default_option_values', $defaults );
			return $defaults;
		}

		/**
		 * Get the options from static array()
		 *
		 * @since  1.0.0
		 * @return array    Return array of theme options.
		 */
		public function get_options() {
			return self::$options;
		}

		/**
		 * Get the options from static array().
		 *
		 * @since  1.0.0
		 * @param string $id Options jet to get.
		 * @return array Return array of theme options.
		 */
		public function get( $id ) {
			$value = isset( self::$options[ $id ] ) ? self::$options[ $id ] : self::get_default( $id );
			$value = apply_filters("theme_mod_{$id}", $value); // phpcs:ignore
			return $value;
		}

		/**
		 * Set option.
		 *
		 * @since  1.0.0
		 * @param string $id Option key.
		 * @param any    $value Option value.
		 * @return void
		 */
		public function set( $id, $value ) {
			set_theme_mod( $id, $value );
			self::$options[ $id ] = $value;
		}

		/**
		 * Refresh options.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function refresh() {
			self::$options = wp_parse_args(
				get_theme_mods(),
				self::get_defaults()
			);
		}

		/**
		 * Returns the default value for option.
		 *
		 * @since  1.0.0
		 * @param  string $id Option ID.
		 * @return mixed      Default option value.
		 */
		public function get_default( $id ) {
			$defaults = self::get_defaults();
			return isset( $defaults[ $id ] ) ? $defaults[ $id ] : false;
		}
	}

endif;


