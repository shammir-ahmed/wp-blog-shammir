<?php
/**
 * Blogshammir About page class.
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

if ( ! class_exists( 'Blogshammir_Dashboard' ) ) :
	/**
	 * Blogshammir Dashboard page class.
	 */
	final class Blogshammir_Dashboard {

		/**
		 * Singleton instance of the class.
		 *
		 * @since 1.0.0
		 * @var object
		 */
		private static $instance;

		/**
		 * Main Blogshammir Dashboard Instance.
		 *
		 * @since 1.0.0
		 * @return Blogshammir_Dashboard
		 */
		public static function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Blogshammir_Dashboard ) ) {
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

			/**
			 * Register admin menu item under Appearance menu item.
			 */
			add_action( 'admin_menu', array( $this, 'add_to_menu' ), 10 );
			add_filter( 'submenu_file', array( $this, 'highlight_submenu' ) );

			/**
			 * Ajax activate & deactivate plugins.
			 */
			add_action( 'wp_ajax_hester-plugin-activate', array( $this, 'activate_plugin' ) );
			add_action( 'wp_ajax_hester-plugin-deactivate', array( $this, 'deactivate_plugin' ) );
		}

		/**
		 * Register our custom admin menu item.
		 *
		 * @since 1.0.0
		 */
		public function add_to_menu() {

			/**
			 * Dashboard page.
			 */
			add_theme_page(
				esc_html__( 'BlogShammir Theme', 'blogshammir' ),
				'BlogShammir Theme',
				apply_filters( 'blogshammir_manage_cap', 'edit_theme_options' ),
				'blogshammir-dashboard',
				array( $this, 'render_dashboard' )
			);

			/**
			 * Plugins page.
			 */
			add_theme_page(
				esc_html__( 'Plugins', 'blogshammir' ),
				'Plugins',
				apply_filters( 'blogshammir_manage_cap', 'edit_theme_options' ),
				'blogshammir-plugins',
				array( $this, 'render_plugins' )
			);

			// Hide from admin navigation.
			remove_submenu_page( 'themes.php', 'blogshammir-plugins' );

			/**
			 * Changelog page.
			 */
			add_theme_page(
				esc_html__( 'Changelog', 'blogshammir' ),
				'Changelog',
				apply_filters( 'blogshammir_manage_cap', 'edit_theme_options' ),
				'blogshammir-changelog',
				array( $this, 'render_changelog' )
			);

			// Hide from admin navigation.
			remove_submenu_page( 'themes.php', 'blogshammir-changelog' );
		}

		/**
		 * Render dashboard page.
		 *
		 * @since 1.0.0
		 */
		public function render_dashboard() {

			// Render dashboard navigation.
			$this->render_navigation();

			?>
			<div class="hester-container">

				<div class="hester-section-title">
					<h2 class="hester-section-title"><?php esc_html_e( 'Getting Started', 'blogshammir' ); ?></h2>
				</div><!-- END .hester-section-title -->

				<div class="hester-section hester-columns">

					<div class="hester-column">
						<div class="hester-box">
							<h4><i class="dashicons dashicons-admin-plugins"></i><?php esc_html_e( 'Install Plugins', 'blogshammir' ); ?></h4>
							<p><?php esc_html_e( 'Explore recommended plugins. These free plugins provide additional features and customization options.', 'blogshammir' ); ?></p>

							<div class="hester-buttons">
								<a href="<?php echo esc_url( menu_page_url( 'blogshammir-plugins', false ) ); ?>" class="hester-btn secondary" role="button"><?php esc_html_e( 'Install Plugins', 'blogshammir' ); ?></a>
							</div><!-- END .hester-buttons -->
						</div>
					</div>

					<div class="hester-column">
						<div class="hester-box">
							<h4><i class="dashicons dashicons-layout"></i><?php esc_html_e( 'Start with a Template', 'blogshammir' ); ?></h4>
							<p><?php esc_html_e( 'Don&rsquo;t want to start from scratch? Import a pre-built demo website in 1-click and get a head start.', 'blogshammir' ); ?></p>

							<div class="hester-buttons plugins">

								<?php
								if ( file_exists( WP_PLUGIN_DIR . '/blogo-core-shammir/blogo-core-shammir.php' ) && is_plugin_inactive( 'blogo-core-shammir/blogo-core-shammir.php' ) ) {
									$class       = 'hester-btn secondary';
									$button_text = __( 'Activate Blogo Core Shammir', 'blogshammir' );
									$link        = '#';
									$data        = ' data-plugin="blogo-core-shammir" data-action="activate" data-redirect="' . esc_url( admin_url( 'admin.php?page=blogshammir-demo-library' ) ) . '"';
								} elseif ( ! file_exists( WP_PLUGIN_DIR . '/blogo-core-shammir/blogo-core-shammir.php' ) ) {
									$class       = 'hester-btn secondary';
									$button_text = __( 'Install Blogo Core Shammir', 'blogshammir' );
									$link        = '#';
									$data        = ' data-plugin="blogo-core-shammir" data-action="install" data-redirect="' . esc_url( admin_url( 'admin.php?page=blogshammir-demo-library' ) ) . '"';
								} else {
									$class       = 'hester-btn secondary active';
									$button_text = __( 'Browse Demos', 'blogshammir' );
									$link        = admin_url( 'admin.php?page=blogshammir-demo-library' );
									$data        = '';
								}

								printf(
									'<a class="%1$s" %2$s %3$s role="button"> %4$s </a>',
									esc_attr( $class ),
									isset( $link ) ? 'href="' . esc_url( $link ) . '"' : '',
									$data, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									esc_html( $button_text )
								);
								?>

							</div><!-- END .hester-buttons -->
						</div>
					</div>

					<div class="hester-column">
						<div class="hester-box">
							<h4><i class="dashicons dashicons-palmtree"></i><?php esc_html_e( 'Upload Your Logo', 'blogshammir' ); ?></h4>
							<p><?php esc_html_e( 'Kick off branding your new site by uploading your logo. Simply upload your logo and customize as you need.', 'blogshammir' ); ?></p>

							<div class="hester-buttons">
								<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[control]=custom_logo' ) ); ?>" class="hester-btn secondary" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Upload Logo', 'blogshammir' ); ?></a>
							</div><!-- END .hester-buttons -->
						</div>
					</div>

					<div class="hester-column">
						<div class="hester-box">
							<h4><i class="dashicons dashicons-welcome-widgets-menus"></i><?php esc_html_e( 'Change Menus', 'blogshammir' ); ?></h4>
							<p><?php esc_html_e( 'Customize menu links and choose what&rsquo;s displayed in available theme menu locations.', 'blogshammir' ); ?></p>

							<div class="hester-buttons">
								<a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" class="hester-btn secondary" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Go to Menus', 'blogshammir' ); ?></a>
							</div><!-- END .hester-buttons -->
						</div>
					</div>

					<div class="hester-column">
						<div class="hester-box">
							<h4><i class="dashicons dashicons-art"></i><?php esc_html_e( 'Change Colors', 'blogshammir' ); ?></h4>
							<p><?php esc_html_e( 'Replace the default theme colors and make your website color scheme match your brand design.', 'blogshammir' ); ?></p>

							<div class="hester-buttons">
								<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=blogshammir_section_colors' ) ); ?>" class="hester-btn secondary" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Change Colors', 'blogshammir' ); ?></a>
							</div><!-- END .hester-buttons -->
						</div>
					</div>

					<div class="hester-column">
						<div class="hester-box">
							<h4><i class="dashicons dashicons-editor-help"></i><?php esc_html_e( 'Need Help?', 'blogshammir' ); ?></h4>
							<p><?php esc_html_e( 'Head over to our site to learn more about the BlogShammir theme, read help articles and get support.', 'blogshammir' ); ?></p>

							<div class="hester-buttons">
								<a href="https://github.com/shammir-ahmed" target="_blank" rel="noopener noreferrer" class="hester-btn secondary"><?php esc_html_e( 'Help Articles', 'blogshammir' ); ?></a>
							</div><!-- END .hester-buttons -->
						</div>
					</div>
				</div><!-- END .hester-section -->

				<div class="hester-section large-section">
					<div class="hester-hero">
						<img src="<?php echo esc_url( BLOGSHAMMIR_THEME_URI . '/assets/images/blogshammir-customize.svg' ); ?>" alt="<?php echo esc_html( 'Customize' ); ?>" />
					</div>

					<h2><?php esc_html_e( 'Let\'s customize your website', 'blogshammir' ); ?></h2>
					<p><?php esc_html_e( 'There are many changes you can make to customize your website. Explore BlogShammir customization options and make it unique.', 'blogshammir' ); ?></p>

					<div class="hester-buttons">
						<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="hester-btn primary large-button"><?php esc_html_e( 'Start Customizing', 'blogshammir' ); ?></a>
					</div><!-- END .hester-buttons -->

				</div><!-- END .hester-section -->

				<?php do_action( 'blogshammir_about_content_after' ); ?>

			</div><!-- END .hester-container -->

			<?php
		}

		/**
		 * Render the recommended plugins page.
		 *
		 * @since 1.0.0
		 */
		public function render_plugins() {

			// Render dashboard navigation.
			$this->render_navigation();

			$plugins = blogshammir_plugin_utilities()->get_recommended_plugins();
			?>
			<div class="hester-container">

				<div class="hester-section-title">
					<h2 class="hester-section-title"><?php esc_html_e( 'Recommended Plugins', 'blogshammir' ); ?></h2>
				</div><!-- END .hester-section-title -->

				<div class="hester-section hester-columns plugins">

					<?php if ( is_array( $plugins ) && ! empty( $plugins ) ) { ?>
						<?php foreach ( $plugins as $plugin ) { ?>

							<?php
							// Check plugin status.
							if ( blogshammir_plugin_utilities()->is_activated( $plugin['slug'] ) ) {
								$btn_class = 'hester-btn secondary';
								$btn_text  = esc_html__( 'Deactivate', 'blogshammir' );
								$action    = 'deactivate';
								$notice    = '<span class="hester-active-plugin"><span class="dashicons dashicons-yes"></span>' . esc_html__( 'Plugin activated', 'blogshammir' ) . '</span>';
							} elseif ( blogshammir_plugin_utilities()->is_installed( $plugin['slug'] ) ) {
								$btn_class = 'hester-btn primary';
								$btn_text  = esc_html__( 'Activate', 'blogshammir' );
								$action    = 'activate';
								$notice    = '';
							} else {
								$btn_class = 'hester-btn primary';
								$btn_text  = esc_html__( 'Install & Activate', 'blogshammir' );
								$action    = 'install';
								$notice    = '';
							}
							?>

							<div class="hester-column column-6">
								<div class="hester-box">

									<div class="plugin-image">
										<img src="<?php echo esc_url( $plugin['thumb'] ); ?>" alt="<?php echo esc_html( $plugin['name'] ); ?>"/>					
									</div>

									<div class="plugin-info">
										<h4><?php echo esc_html( $plugin['name'] ); ?></h4>
										<p><?php echo esc_html( $plugin['desc'] ); ?></p>
										<div class="hester-buttons">
											<?php echo ( wp_kses_post( $notice ) ); ?>
											<a href="#" class="<?php echo esc_attr( $btn_class ); ?>" data-plugin="<?php echo esc_attr( $plugin['slug'] ); ?>" data-action="<?php echo esc_attr( $action ); ?>"><?php echo esc_html( $btn_text ); ?></a>
										</div>
									</div>

								</div>
							</div>
						<?php } ?>
					<?php } ?>

				</div><!-- END .hester-section -->

				<?php do_action( 'blogshammir_recommended_plugins_after' ); ?>

			</div><!-- END .hester-container -->

			<?php
		}

		/**
		 * Render the changelog page.
		 *
		 * @since 1.0.0
		 */
		public function render_changelog() {

			// Render dashboard navigation.
			$this->render_navigation();

			$changelog = BLOGSHAMMIR_THEME_PATH . '/changelog.txt';

			if ( ! file_exists( $changelog ) ) {
				$changelog = esc_html__( 'Changelog file not found.', 'blogshammir' );
			} elseif ( ! is_readable( $changelog ) ) {
				$changelog = esc_html__( 'Changelog file not readable.', 'blogshammir' );
			} else {
				global $wp_filesystem;

				// Check if the the global filesystem isn't setup yet.
				if ( is_null( $wp_filesystem ) ) {
					WP_Filesystem();
				}

				$changelog = $wp_filesystem->get_contents( $changelog );
			}

			?>
			<div class="hester-container">

				<div class="hester-section-title">
					<h2 class="hester-section-title">
						<span><?php esc_html_e( 'BlogShammir Theme Changelog', 'blogshammir' ); ?></span>
						<span class="changelog-version"><?php echo esc_html( sprintf( 'v%1$s', BLOGSHAMMIR_THEME_VERSION ) ); ?></span>
					</h2>

				</div><!-- END .hester-section-title -->

				<div class="hester-section hester-columns">

					<div class="hester-column column-12">
						<div class="hester-box hester-changelog">
							<pre><?php echo esc_html( $changelog ); ?></pre>
						</div>
					</div>
				</div><!-- END .hester-columns -->

				<?php do_action( 'blogshammir_after_changelog' ); ?>

			</div><!-- END .hester-container -->
			<?php
		}

		/**
		 * Render admin page navigation tabs.
		 *
		 * @since 1.0.0
		 */
		public function render_navigation() {

			// Get navigation items.
			$menu_items = $this->get_navigation_items();

			?>
			<div class="hester-container">

				<div class="hester-tabs">
					<ul>
						<?php
						// Determine current tab.
						$base = $this->get_current_page();

						// Display menu items.
						foreach ( $menu_items as $item ) {

							// Check if we're on a current item.
							$current = false !== strpos( $base, $item['id'] ) ? 'current-item' : '';
							?>

							<li class="<?php echo esc_attr( $current ); ?>">
								<a href="<?php echo esc_url( $item['url'] ); ?>">
									<?php echo esc_html( $item['name'] ); ?>

									<?php
									if ( isset( $item['icon'] ) && $item['icon'] ) {
										blogshammir_print_admin_icon( $item['icon'] );
									}
									?>
								</a>
							</li>

						<?php } ?>
					</ul>
				</div><!-- END .hester-tabs -->

			</div><!-- END .hester-container -->
			<?php
		}

		/**
		 * Return the current Blogshammir Dashboard page.
		 *
		 * @since 1.0.0
		 * @return string $page Current dashboard page slug.
		 */
		public function get_current_page() {

			$page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : 'dashboard'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$page = str_replace( 'blogshammir-', '', $page );
			$page = apply_filters( 'blogshammir_dashboard_current_page', $page );

			return esc_html( $page );
		}

		/**
		 * Print admin page navigation items.
		 *
		 * @since 1.0.0
		 * @return array $items Array of navigation items.
		 */
		public function get_navigation_items() {

			$items = array(
				'dashboard' => array(
					'id'   => 'dashboard',
					'name' => esc_html__( 'About', 'blogshammir' ),
					'icon' => '',
					'url'  => menu_page_url( 'blogshammir-dashboard', false ),
				),
				'plugins'   => array(
					'id'   => 'plugins',
					'name' => esc_html__( 'Recommended Plugins', 'blogshammir' ),
					'icon' => '',
					'url'  => menu_page_url( 'blogshammir-plugins', false ),
				),
				'changelog' => array(
					'id'   => 'changelog',
					'name' => esc_html__( 'Changelog', 'blogshammir' ),
					'icon' => '',
					'url'  => menu_page_url( 'blogshammir-changelog', false ),
				),
			);

			return apply_filters( 'blogshammir_dashboard_navigation_items', $items );
		}

		/**
		 * Activate plugin.
		 *
		 * @since 1.0.0
		 */
		public function activate_plugin() {

			// Security check.
			check_ajax_referer( 'blogshammir_nonce' );

			// Plugin data.
			$plugin = isset( $_POST['plugin'] ) ? sanitize_text_field( wp_unslash( $_POST['plugin'] ) ) : '';

			if ( empty( $plugin ) ) {
				wp_send_json_error( esc_html__( 'Missing plugin data', 'blogshammir' ) );
			}

			if ( $plugin ) {

				$response = blogshammir_plugin_utilities()->activate_plugin( $plugin );

				if ( is_wp_error( $response ) ) {
					wp_send_json_error( $response->get_error_message(), $response->get_error_code() );
				}

				wp_send_json_success();
			}

			wp_send_json_error( esc_html__( 'Failed to activate plugin. Missing plugin data.', 'blogshammir' ) );
		}

		/**
		 * Deactivate plugin.
		 *
		 * @since 1.0.0
		 */
		public function deactivate_plugin() {

			// Security check.
			check_ajax_referer( 'blogshammir_nonce' );

			// Plugin data.
			$plugin = isset( $_POST['plugin'] ) ? sanitize_text_field( wp_unslash( $_POST['plugin'] ) ) : '';

			if ( empty( $plugin ) ) {
				wp_send_json_error( esc_html__( 'Missing plugin data', 'blogshammir' ) );
			}

			if ( $plugin ) {
				$response = blogshammir_plugin_utilities()->deactivate_plugin( $plugin );

				if ( is_wp_error( $response ) ) {
					wp_send_json_error( $response->get_error_message(), $response->get_error_code() );
				}

				wp_send_json_success();
			}

			wp_send_json_error( esc_html__( 'Failed to deactivate plugin. Missing plugin data.', 'blogshammir' ) );
		}

		/**
		 * Highlight dashboard page for plugins page.
		 *
		 * @since 1.0.0
		 * @param string $submenu_file The submenu file.
		 */
		public function highlight_submenu( $submenu_file ) {

			global $pagenow;

			// Check if we're on blogshammir plugins or changelog page.
			if ( 'themes.php' === $pagenow ) {
				if ( isset( $_GET['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					if ( 'blogshammir-plugins' === $_GET['page'] || 'blogshammir-changelog' === $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						$submenu_file = 'blogshammir-dashboard';
					}
				}
			}

			return $submenu_file;
		}
	}
endif;

/**
 * The function which returns the one Blogshammir_Dashboard instance.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $blogshammir_dashboard = blogshammir_dashboard(); ?>
 *
 * @since 1.0.0
 * @return object
 */
function blogshammir_dashboard() {
	return Blogshammir_Dashboard::instance();
}

blogshammir_dashboard();


