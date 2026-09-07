<?php
/**
 * Blogshammir WooCommerce section in Customizer.
 *
 * @package BlogShammir
 * @author Md Shammir Ahmed
 * @since   1.0.0
 */

/**
 * Do not allow direct script access.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Blogshammir_Customizer_WooCommerce' ) ) :
	/**
	 * Blogshammir WooCommerce section in Customizer.
	 */
	class Blogshammir_Customizer_WooCommerce {

		/**
		 * Primary class constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Registers our custom options in Customizer.
			add_filter( 'blogshammir_customizer_options', array( $this, 'register_options' ), 20 );
			add_action( 'customize_register', array( $this, 'customizer_tweak' ), 20 );

			// Add default values for WooCommerce options.
			add_filter( 'blogshammir_default_option_values', array( $this, 'default_customizer_values' ) );

			// Add localized strings to script.
			add_filter( 'blogshammir_customizer_localized', array( $this, 'customizer_localized_strings' ) );
		}

		/**
		 * Add defaults for new WooCommerce customizer options.
		 *
		 * @param  array $defaults Array of default values.
		 * @return array           Array of default values.
		 */
		public function default_customizer_values( $defaults ) {

			$defaults['blogshammir_wc_product_gallery_lightbox'] = true;
			$defaults['blogshammir_wc_product_gallery_zoom']     = true;
			$defaults['blogshammir_shop_product_hover']          = 'none';
			$defaults['blogshammir_product_sale_badge']          = 'percentage';
			$defaults['blogshammir_product_sale_badge_text']     = esc_html__( 'Sale!', 'blogshammir' );
			$defaults['blogshammir_wc_product_slider_arrows']    = true;
			$defaults['blogshammir_wc_product_gallery_style']    = 'default';
			$defaults['blogshammir_wc_product_sidebar_position'] = 'no-sidebar';
			$defaults['blogshammir_wc_sidebar_position']         = 'no-sidebar';
			$defaults['blogshammir_wc_upsell_products']          = true;
			$defaults['blogshammir_wc_upsells_columns']          = 4;
			$defaults['blogshammir_wc_upsells_rows']             = 1;
			$defaults['blogshammir_wc_related_products']         = true;
			$defaults['blogshammir_wc_related_columns']          = 4;
			$defaults['blogshammir_wc_related_rows']             = 1;
			$defaults['blogshammir_wc_cross_sell_products']      = true;
			$defaults['blogshammir_wc_cross_sell_rows']          = 1;
			$defaults['blogshammir_product_catalog_elements']    = array(
				'category' => true,
				'title'    => true,
				'ratings'  => true,
				'price'    => true,
			);

			return $defaults;
		}

		/**
		 * Tweak Customizer.
		 *
		 * @since 1.0.0
		 * @param WP_Customize_Manager $customizer Instance of WP_Customize_Manager class.
		 */
		public function customizer_tweak( $customizer ) {
			// Move WooCommerce panel.
			$customizer->get_panel( 'woocommerce' )->priority = 10;

			return $customizer;
		}

		/**
		 * Registers our custom options in Customizer.
		 *
		 * @since 1.0.0
		 * @param array $options Array of customizer options.
		 */
		public function register_options( $options ) {

			// Shop image hover effect.
			$options['setting']['blogshammir_shop_product_hover'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'section'     => 'woocommerce_product_catalog',
					'label'       => esc_html__( 'Product image hover', 'blogshammir' ),
					'description' => esc_html__( 'Effect for product image on hover', 'blogshammir' ),
					'choices'     => array(
						'none'       => esc_html__( 'No Effect', 'blogshammir' ),
						'image-swap' => esc_html__( 'Image Swap', 'blogshammir' ),
					),
				),
			);

			// Sale badge.
			$options['setting']['blogshammir_product_sale_badge'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'section'     => 'woocommerce_product_catalog',
					'label'       => esc_html__( 'Product sale badge', 'blogshammir' ),
					'description' => esc_html__( 'Choose what to display on the product sale badge.', 'blogshammir' ),
					'choices'     => array(
						'hide'       => esc_html__( 'Hide badge', 'blogshammir' ),
						'percentage' => esc_html__( 'Show percentage', 'blogshammir' ),
						'text'       => esc_html__( 'Show text', 'blogshammir' ),
					),
				),
			);

			// Sale badge text.
			$options['setting']['blogshammir_product_sale_badge_text'] = array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
				'control'           => array(
					'type'        => 'blogshammir-text',
					'label'       => esc_html__( 'Sale badge text', 'blogshammir' ),
					'description' => esc_html__( 'Add custom text for the product sale badge.', 'blogshammir' ),
					'placeholder' => esc_html__( 'Sale!', 'blogshammir' ),
					'section'     => 'woocommerce_product_catalog',
					'required'    => array(
						array(
							'control'  => 'blogshammir_product_sale_badge',
							'value'    => 'text',
							'operator' => '==',
						),
					),
				),
			);

			// Catalog product elements.
			$options['setting']['blogshammir_product_catalog_elements'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_sortable',
				'control'           => array(
					'type'        => 'blogshammir-sortable',
					'section'     => 'woocommerce_product_catalog',
					'label'       => esc_html__( 'Product details', 'blogshammir' ),
					'description' => esc_html__( 'Set order and visibility for product details.', 'blogshammir' ),
					'choices'     => array(
						'title'    => esc_html__( 'Title', 'blogshammir' ),
						'ratings'  => esc_html__( 'Ratings', 'blogshammir' ),
						'price'    => esc_html__( 'Price', 'blogshammir' ),
						'category' => esc_html__( 'Category', 'blogshammir' ),
					),
				),
			);

			// Section.
			$options['section']['blogshammir_woocommerce_single_product'] = array(
				'title'    => esc_html__( 'Single Product', 'blogshammir' ),
				'priority' => 50,
				'panel'    => 'woocommerce',
			);

			// Product Gallery Zoom.
			$options['setting']['blogshammir_wc_product_gallery_zoom'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Gallery Zoom', 'blogshammir' ),
					'description' => esc_html__( 'Enable zoom effect when hovering product gallery.', 'blogshammir' ),
					'section'     => 'blogshammir_woocommerce_single_product',
					'space'       => true,
				),
			);

			// Product Gallery Lightbox.
			$options['setting']['blogshammir_wc_product_gallery_lightbox'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Gallery Lightbox', 'blogshammir' ),
					'description' => esc_html__( 'Open product gallery images in lightbox.', 'blogshammir' ),
					'section'     => 'blogshammir_woocommerce_single_product',
					'space'       => true,
				),
			);

			// Product slider arrows.
			$options['setting']['blogshammir_wc_product_slider_arrows'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Slider Arrows', 'blogshammir' ),
					'description' => esc_html__( 'Enable left and right arrows on product gallery slider.', 'blogshammir' ),
					'section'     => 'blogshammir_woocommerce_single_product',
					'space'       => true,
				),
			);

			// Related Products.
			$options['setting']['blogshammir_wc_related_products'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Related Products', 'blogshammir' ),
					'description' => esc_html__( 'Display related products.', 'blogshammir' ),
					'section'     => 'blogshammir_woocommerce_single_product',
					'space'       => true,
				),
			);

			// Related product column count.
			$options['setting']['blogshammir_wc_related_columns'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_range',
				'control'           => array(
					'type'        => 'blogshammir-range',
					'label'       => esc_html__( 'Related Products Columns', 'blogshammir' ),
					'description' => esc_html__( 'How many related products should be shown per row?', 'blogshammir' ),
					'section'     => 'blogshammir_woocommerce_single_product',
					'min'         => 1,
					'max'         => 6,
					'step'        => 1,
					'required'    => array(
						array(
							'control'  => 'blogshammir_wc_related_products',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Related product row count.
			$options['setting']['blogshammir_wc_related_rows'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_range',
				'control'           => array(
					'type'        => 'blogshammir-range',
					'label'       => esc_html__( 'Related Products Rows', 'blogshammir' ),
					'description' => esc_html__( 'How many rows of related products should be shown?', 'blogshammir' ),
					'section'     => 'blogshammir_woocommerce_single_product',
					'min'         => 1,
					'max'         => 5,
					'step'        => 1,
					'required'    => array(
						array(
							'control'  => 'blogshammir_wc_related_products',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Up-Sell Products.
			$options['setting']['blogshammir_wc_upsell_products'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Up-Sell Products', 'blogshammir' ),
					'description' => esc_html__( 'Display linked upsell products.', 'blogshammir' ),
					'section'     => 'blogshammir_woocommerce_single_product',
					'space'       => true,
				),
			);

			// Up-Sells column count.
			$options['setting']['blogshammir_wc_upsells_columns'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_range',
				'control'           => array(
					'type'        => 'blogshammir-range',
					'label'       => esc_html__( 'Up-Sell Products Columns', 'blogshammir' ),
					'description' => esc_html__( 'How many up-sell products should be shown per row?', 'blogshammir' ),
					'section'     => 'blogshammir_woocommerce_single_product',
					'min'         => 1,
					'max'         => 6,
					'step'        => 1,
					'required'    => array(
						array(
							'control'  => 'blogshammir_wc_upsell_products',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Up-Sells rows count.
			$options['setting']['blogshammir_wc_upsells_rows'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_range',
				'control'           => array(
					'type'        => 'blogshammir-range',
					'label'       => esc_html__( 'Up-Sell Products Rows', 'blogshammir' ),
					'description' => esc_html__( 'How many rows of up-sell products should be shown?', 'blogshammir' ),
					'section'     => 'blogshammir_woocommerce_single_product',
					'min'         => 1,
					'max'         => 6,
					'step'        => 1,
					'required'    => array(
						array(
							'control'  => 'blogshammir_wc_upsell_products',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			// Cross-Sell Products.
			$options['setting']['blogshammir_wc_cross_sell_products'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_toggle',
				'control'           => array(
					'type'        => 'blogshammir-toggle',
					'label'       => esc_html__( 'Cross-Sell Products', 'blogshammir' ),
					'description' => esc_html__( 'Display linked cross-sell products on cart page.', 'blogshammir' ),
					'section'     => 'blogshammir_woocommerce_single_product',
					'space'       => true,
				),
			);

			// Cross-Sells rows count.
			$options['setting']['blogshammir_wc_cross_sell_rows'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_range',
				'control'           => array(
					'type'        => 'blogshammir-range',
					'label'       => esc_html__( 'Cross-Sell Products Rows', 'blogshammir' ),
					'description' => esc_html__( 'How many rows of cross-sell products should be shown?', 'blogshammir' ),
					'section'     => 'blogshammir_woocommerce_single_product',
					'min'         => 1,
					'max'         => 6,
					'step'        => 1,
					'required'    => array(
						array(
							'control'  => 'blogshammir_wc_cross_sells_products',
							'value'    => true,
							'operator' => '==',
						),
					),
				),
			);

			$sidebar_options = array();

			$sidebar_options['blogshammir_wc_sidebar_position'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'label'       => esc_html__( 'WooCommerce', 'blogshammir' ),
					'description' => esc_html__( 'Choose default sidebar position for cart, checkout and catalog pages. You can change this setting per page via metabox settings.', 'blogshammir' ),
					'section'     => 'blogshammir_section_sidebar',
					'choices'     => array(
						'default'       => esc_html__( 'Default', 'blogshammir' ),
						'no-sidebar'    => esc_html__( 'No Sidebar', 'blogshammir' ),
						'left-sidebar'  => esc_html__( 'Left Sidebar', 'blogshammir' ),
						'right-sidebar' => esc_html__( 'Right Sidebar', 'blogshammir' ),
					),
				),
			);

			$sidebar_options['blogshammir_wc_product_sidebar_position'] = array(
				'transport'         => 'refresh',
				'sanitize_callback' => 'blogshammir_sanitize_select',
				'control'           => array(
					'type'        => 'blogshammir-select',
					'label'       => esc_html__( 'WooCommerce - Single Product', 'blogshammir' ),
					'description' => esc_html__( 'Choose default sidebar position layout for product pages. You can change this setting per product via metabox settings.', 'blogshammir' ),
					'section'     => 'blogshammir_section_sidebar',
					'choices'     => array(
						'default'       => esc_html__( 'Default', 'blogshammir' ),
						'no-sidebar'    => esc_html__( 'No Sidebar', 'blogshammir' ),
						'left-sidebar'  => esc_html__( 'Left Sidebar', 'blogshammir' ),
						'right-sidebar' => esc_html__( 'Right Sidebar', 'blogshammir' ),
					),
				),
			);

			$options['setting'] = blogshammir_array_insert( $options['setting'], $sidebar_options, 'blogshammir_archive_sidebar_position' );

			return $options;
		}

		/**
		 * Add localize strings.
		 *
		 * @param  array $strings Array of strings to be localized.
		 * @return array          Modified string array.
		 */
		public function customizer_localized_strings( $strings ) {

			// Preview a random single product for WooCommerce > Single Product section.
			$products = get_posts(
				array(
					'post_type'      => 'product',
					'posts_per_page' => 1,
					'orderby'        => 'rand',
				)
			);

			if ( count( $products ) ) {
				$strings['preview_url_for_section']['blogshammir_woocommerce_single_product'] = get_permalink( $products[0] );
			}

			return $strings;
		}
	}
endif;
new Blogshammir_Customizer_WooCommerce();


