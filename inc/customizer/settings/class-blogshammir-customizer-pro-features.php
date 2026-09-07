<?php
/**
 * BlogShammir Pro Features section in Customizer.
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

if ( ! class_exists( 'Blogshammir_Customizer_Pro_Features' ) ) :
	/**
	 * Blogshammir PYML section in Customizer.
	 */
	class Blogshammir_Customizer_Pro_Features {

		/**
		 * Primary class constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			/**
			 * Registers our custom options in Customizer.
			 */
			add_filter( 'blogshammir_customizer_options', array( $this, 'register_options' ) );
		}

		/**
		 * Registers our custom options in Customizer.
		 *
		 * @since 1.0.0
		 * @param array $options Array of customizer options.
		 */
		public function register_options( $options ) {
			// Pro features section
			$options['section']['blogshammir_section_blogshammir_pro'] = array(
				'title'    => esc_html__( 'View Pro Features', 'blogshammir' ),
				'priority' => 0,
			);

			$options['setting']['blogshammir_section_blogshammir_pro_features'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
				'control'           => array(
					'type'       => 'blogshammir-pro',
					'section'    => 'blogshammir_section_blogshammir_pro',
					'screenshot' => apply_filters( 'blogshammir_pro_theme_screenshot', esc_url( get_template_directory_uri() ) . '/assets/images/blogshammir-lapi.webp' ),
					'features'   => apply_filters(
						'blogshammir_pro_theme_features',
						array(
							esc_html_x( 'All starter sites included', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Advance header layout options', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Advance FrontPage slider layouts', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Unlimited \'Advertisement\' widgets', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Option to ad AdSesne code in advertisement widget', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Body and H1 to H6 typography options', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Primary, seconday and text buttons color and typography options', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Post advance features', 'pro feature' , 'blogshammir' ),
							esc_html_x( '\'Post Like â¤ï¸\' feature', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Ajax load more posts', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Infinite load posts', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Unlimited \'Featured links\' + some additional features', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Meta category options', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Site layouts options e.g. Boxed, Framed etc', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Archive layout options', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Advance color scheme', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Author widgets', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Title design settings', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Masonry grid & multi post options', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Full width Post/Page options', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Single Post/Page layout options', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Footer advance features', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Footer widgets options', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Call to action / Pre-Footer', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Site width manage options', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Parallax footer', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Site pre-loader', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'SEO Meta', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'AMP compatibility', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Coming soon/Maintenance mode option', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Regular premium updates', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'Quick support', 'pro feature' , 'blogshammir' ),
							esc_html_x( 'And much more...', 'pro feature' , 'blogshammir' ),
						)
					),
				),
			);

			return $options;
		}

	}
endif;
new Blogshammir_Customizer_Pro_Features();


