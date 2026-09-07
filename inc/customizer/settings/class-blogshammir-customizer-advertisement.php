<?php
/**
 * Blogshammir Advertisement Section Settings in Customizer.
 *
 * @package     BlogShammir
 * @author      Md Shammir Ahmed
 * @since       1.0.0
 */

/**
 * Do not allow direct script access.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Blogshammir_Customizer_Advertisement' ) ) :
	/**
	 * Blogshammir Page Title Settings section in Customizer.
	 */
	class Blogshammir_Customizer_Advertisement {

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

			// Advertisement Section.
			$options['section']['blogshammir_section_advertisement'] = array(
				'title'    => esc_html__( 'Advertisements', 'blogshammir' ),
				'priority' => 4,
			);

			// Advertisement widgets.
			$options['setting']['blogshammir_ad_widgets'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_widget',
				'control'           => array(
					'type'       => 'blogshammir-widget',
					'label'      => esc_html__( 'Advertisement Widgets', 'blogshammir' ),
					'section'    => 'blogshammir_section_advertisement',
					'widgets'    => apply_filters(
						'blogshammir_main_ad_widgets',
						array(
							'advertisements' => array(
								'max_uses'      => 2,
								'display_areas' => array(
									'before_header'        => esc_html__( 'Before Header', 'blogshammir' ),
									'after_header'         => esc_html__( 'After Header', 'blogshammir' ),
									'before_post_archive'  => esc_html__( 'Before post archive', 'blogshammir' ),
									'random_post_archives' => esc_html__( 'Random post archives', 'blogshammir' ),
									'before_post_content'  => esc_html__( 'Before post content', 'blogshammir' ),
									'after_post_content'   => esc_html__( 'After post content', 'blogshammir' ),
									'before_footer'        => esc_html__( 'Before footer', 'blogshammir' ),
									'after_footer'         => esc_html__( 'After footer', 'blogshammir' ),
								),
							),
						)
					),
					'visibility' => array(
						'all'                => esc_html__( 'Show on All Devices', 'blogshammir' ),
						'hide-mobile'        => esc_html__( 'Hide on Mobile', 'blogshammir' ),
						'hide-tablet'        => esc_html__( 'Hide on Tablet', 'blogshammir' ),
						'hide-mobile-tablet' => esc_html__( 'Hide on Mobile and Tablet', 'blogshammir' ),
					),
				),
			);
			return $options;
		}
	}
endif;
new Blogshammir_Customizer_Advertisement();


