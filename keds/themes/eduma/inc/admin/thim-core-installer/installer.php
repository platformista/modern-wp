<?php

/**
 * @version 1.0.1
 */
if ( ! class_exists( 'Thim_Core_Installer' ) ) {
	/**
	 * Class Thim_Core_Installer.
	 *
	 * @since 1.0.0
	 */
	class Thim_Core_Installer {
		/**
		 * @var array
		 *
		 * @since 1.0.0
		 */
		private $theme = array(
			'name'    => 'Eduma',
			'slug'    => 'eduma',
			'support' => 'https://thimpress.com/forums/forum/eduma/'
		);

		/**
		 * @var array
		 *
		 * @since 1.0.0
		 */
		private $package = array(
			'slug'   => 'thim-core',
			'name'   => 'Thim Core',
			//			'source' => 'https://thimpresswp.github.io/thim-core/thim-core.zip'
			'source' => 'https://downloads.thimpress.com/thim-envato-market/download-plugin/?plugin=thim-core.zip'
		);

		/**
		 * @var Thim_Plugin
		 *
		 * @since 1.0.0
		 */
		private $plugin = null;

		/**
		 * @var array
		 *
		 * @since 1.0.0
		 */
		private $environments = null;

		/**
		 * @var string
		 *
		 * @since 1.0.0
		 */
		private $slug = 'thim-core-installer';

		/**
		 * let_to_num function.
		 *
		 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
		 *
		 * @param $size
		 *
		 * @return int
		 * @since 1.0.0
		 *
		 */
		private static function let_to_num( $size ) {
			$l   = substr( $size, - 1 );
			$ret = substr( $size, 0, - 1 );
			switch ( strtoupper( $l ) ) {
				case 'P':
					$ret *= 1024;
				case 'T':
					$ret *= 1024;
				case 'G':
					$ret *= 1024;
				case 'M':
					$ret *= 1024;
				case 'K':
					$ret *= 1024;
			}

			return $ret;
		}

		/**
		 * Redirect.
		 *
		 * @param $url
		 *
		 * @since 1.0.0
		 *
		 */
		private static function redirect( $url ) {
			if ( headers_sent() ) {
				echo "<meta http-equiv='refresh' content='0;URL=$url' />";
			} else {
				wp_redirect( $url );
			}

			exit();
		}

		/**
		 * Call $wp_filesystem
		 *
		 * @since 1.0.1
		 */
		private static function call_wp_file_system() {
			/**
			 * Call $wp_filesystem
			 */
			global $wp_filesystem;
			if ( empty( $wp_filesystem ) ) {
				require_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();
			}
		}

		/**
		 * Put file.
		 *
		 * @param $dir
		 * @param $file_name
		 * @param $content
		 *
		 * @return bool
		 * @since 1.0.1
		 *
		 */
		private static function put_file( $dir, $file_name, $content ) {
			self::call_wp_file_system();
			global $wp_filesystem;

			if ( ! $wp_filesystem->is_dir( $dir ) ) {
				wp_mkdir_p( $dir );
			}

			if ( ! wp_is_writable( $dir ) ) {
				return false;
			}

			$put_file = $wp_filesystem->put_contents(
				trailingslashit( $dir ) . $file_name,
				$content,
				FS_CHMOD_FILE
			);

			return $put_file;
		}

		/**
		 * Thim_Core_Installer constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->init();
			$this->hooks();
		}

		/**
		 * Init.
		 *
		 * @since 1.0.0
		 */
		private function init() {
			if ( ! class_exists( 'Thim_Plugin' ) ) {
				require_once 'class-thim-plugin.php';
			}
		}

		/**
		 * Get object plugin Thim Core.
		 *
		 * @return Thim_Plugin
		 * @since 1.0.0
		 *
		 */
		private function get_thim_core() {
			if ( $this->plugin === null ) {
				$plugin = new Thim_Plugin();
				$plugin->set_args( $this->package );
				$this->plugin = $plugin;
			}

			return $this->plugin;
		}

		/**
		 * Is this page.
		 *
		 * @return bool
		 * @since 1.0.0
		 *
		 */
		private function is_this_page() {
			$page = isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : false;

			return $page == $this->slug;
		}

		/**
		 * Get link step.
		 *
		 * @param string $step
		 *
		 * @return string
		 * @since 1.0.0
		 *
		 */
		private function get_link_step( $step = '' ) {
			$page = $this->get_link_page();

			return add_query_arg( array( 'step' => $step ), $page );
		}

		/**
		 * Get environments.
		 *
		 * @return array
		 * @since 1.0.0
		 *
		 */
		private function get_environments() {
			if ( $this->environments === null ) {
				$info = array();

				// Test GET requests
				//				$get_response            = wp_safe_remote_get( 'https://foobla.bitbucket.io/thim-core/dist/ping.json' );
				$get_response_successful = true;
				$remote_get_response     = '';
				//				if ( is_wp_error( $get_response ) ) {
				//					$get_response_successful = false;
				//					$remote_get_response     = $get_response->get_error_message();
				//				}
				//				$info['remote_get_response']   = $remote_get_response;
				//				$info['remote_get_successful'] = $get_response_successful;

				// WP memory limit
				$wp_memory_limit = self::let_to_num( WP_MEMORY_LIMIT );
				if ( function_exists( 'memory_get_usage' ) ) {
					$wp_memory_limit = max( $wp_memory_limit, self::let_to_num( @ini_get( 'memory_limit' ) ) );
				}
				$info['memory_limit'] = $wp_memory_limit;

				$info['server_info'] = $_SERVER['SERVER_SOFTWARE'];

				$info['php_version'] = phpversion();

				// Figure out cURL version, if installed.
				$curl_version = '';
				if ( function_exists( 'curl_version' ) ) {
					$curl_version = curl_version();
					$curl_version = $curl_version['version'] . ', ' . $curl_version['ssl_version'];
				}
				$info['curl_version'] = $curl_version;

				// Writable
				$info['plugins_writable']  = self::put_file( WP_PLUGIN_DIR, '.installer.txt', 'hello' );
				$info['plugins_directory'] = WP_PLUGIN_DIR;
				$info['plugins_chmod']     = substr( sprintf( '%o', fileperms( WP_PLUGIN_DIR ) ), - 4 );

				$this->environments = $info;
			}

			return $this->environments;
		}

		/**
		 * Check require to install.
		 *
		 * @return bool
		 * @since 1.0.0
		 *
		 */
		private function check_require() {
			$environments = $this->get_environments();

			if ( version_compare( $environments['php_version'], '5.4', '<' ) ) {
				return false;
			}

			//			if ( ! $environments['remote_get_successful'] ) {
			//				return false;
			//			}

			if ( ! $environments['plugins_writable'] ) {
				return false;
			}

			if ( $environments['memory_limit'] < 134217728 ) {
				return false;
			}

			return true;
		}

		/**
		 * Get link page.
		 *
		 * @return string
		 * @since 1.0.0
		 *
		 */
		private function get_link_page() {
			return admin_url( 'themes.php?page=' . $this->slug );
		}

		/**
		 * Add hooks.
		 *
		 * @since 1.0.0
		 */
		private function hooks() {
			add_action( 'thim_core_installer_head', array( $this, 'add_head' ) );
			add_action( 'thim_core_installer_head', 'print_admin_styles' );
			add_action( 'admin_menu', array( $this, 'add_menu_installer' ) );
			add_action( 'admin_init', array( $this, 'setup_page' ) );
			add_action( 'thim_core_installer_footer', array( $this, 'add_footer' ) );
			add_action( 'thim_core_install_enqueue_script', array( $this, 'enqueue_scripts' ) );
			add_action( 'wp_ajax_thim_core_installer', array( $this, 'ajax_install' ) );
			add_action( 'after_switch_theme', array( $this, 'after_switch_theme' ) );
			add_action( 'admin_init', array( $this, 'redirect_to_installer' ) );
			add_action( 'admin_notices', array( $this, 'notice_install' ) );
			add_action( 'admin_init', array( $this, 'redirect_to_theme_dashboard' ) );

			add_action( 'thim_core_installer_step_start', array( $this, 'prepare_installation' ) );
			add_action( 'thim_core_installer_step_install', array( $this, 'step_install' ) );
			add_action( 'thim_core_installer_step_activate', array( $this, 'step_activate' ) );
		}

		/**
		 * Redirect to theme dashboard.
		 *
		 * @since 1.0.0
		 */
		public function redirect_to_theme_dashboard() {
			$request = isset( $_GET['thim-redirect-to-theme-dashboard'] );

			if ( ! $request ) {
				return;
			}

			do_action( 'thim_core_installer_complete' );

			if ( is_callable( array( 'Thim_Core_Admin', 'go_to_theme_dashboard' ) ) ) {
				call_user_func( array( 'Thim_Core_Admin', 'go_to_theme_dashboard' ) );
			}

			wp_safe_redirect( admin_url() );
			exit();
		}

		/**
		 * Notice install Thim Core.
		 *
		 * @since 1.0.0
		 */
		public function notice_install() {
			if ( class_exists( 'Thim_Core' ) ) {
				return;
			}

			$theme = $this->theme;
			$link  = esc_url( $this->get_link_page() );
			?>
			<div class="notice notice-success">
				<h3><?php printf( __( '%s Theme notice!', 'eduma' ), $theme['name'] ) ?></h3>
				<p>
					<?php printf( __( 'Installed the theme successfully. <a href="%s">Enable Thim Core to start now!</a>', 'eduma' ), $link ) ?>
				</p>
			</div>
			<?php
		}

		/**
		 * Redirect to page installer
		 *
		 * @since 1.0.0
		 */
		public function redirect_to_installer() {
			$redirect = get_transient( 'thim_core_installer' );
			$redirect = apply_filters( 'thim_core_installer_redirect', $redirect );
			if ( ! $redirect ) {
				return;
			}

			if ( ob_get_length() > 0 ) {
				ob_end_clean();
			}
			delete_transient( 'thim_core_installer' );
			wp_safe_redirect( $this->get_link_page() );
			exit();
		}

		/**
		 * Action after switch theme.
		 *
		 * @since 1.0.0
		 */
		public function after_switch_theme() {
			$thim_core = $this->get_thim_core();
			if ( $thim_core->get_status() != 'active' ) {
				set_transient( 'thim_core_installer', true );
			}
		}

		/**
		 * Handle ajax.
		 *
		 * @since 1.0.0
		 */
		public function ajax_install() {
			$plugin = $this->get_thim_core();

			$result = $plugin->install();

			if ( ! $result ) {
				wp_send_json_error( $plugin->get_messages() );
			}

			wp_send_json_success( $plugin->get_messages() );
		}

		/**
		 * Enqueue script.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'wp-admin' );
			wp_enqueue_style( 'dashicons' );
			wp_enqueue_style( 'common' );
			wp_enqueue_style( 'buttons' );
		}

		/**
		 * Add menu installer.
		 *
		 * @since 1.0.0
		 */
		public function add_menu_installer() {
			$hidden = apply_filters( 'thim_core_installer_hidden_menu', false );
			if ( $hidden ) {
				return;
			}

			add_theme_page(
				__( 'Thim Core Installer', 'eduma' ),
				'Thim Core Installer',
				'edit_theme_options',
				$this->slug,
				'__return_empty_string'
			);
		}

		/**
		 * Add to footer.
		 *
		 * @since 1.0.0
		 */
		public function add_footer() {
			?>
			<script>
				(function ($) {
					$(document).ready(function () {
						$('.thim-button-link').on('click', function () {
							var $button = $(this);
							$button.addClass('updating-message').attr('disabled', true);
							window.location.href = $button.attr('data-href');
						})
					});
				})(jQuery);
			</script>
			<?php
		}

		/**
		 * Add to head.
		 *
		 * @since 1.0.0
		 */
		public function add_head() {
			?>
			<style>
				.thim-core-installer {
					margin: 30px auto 0;
					box-shadow: none;
					background: #ddd;
					padding: 0;
					font-size: 14px;
					max-width: 800px;
				}

				.thim-setup-content {
					box-shadow: 0 1px 3px rgba(0, 0, 0, .13);
					padding: 24px;
					background: #f3f3f3;
					overflow: hidden;
					zoom: 1;
					position: relative;
				}

				.thim-setup-content .close {
					display: inline-block;
					position: absolute;
					top: 10px;
					right: 7px;
					font-size: 20px;
					text-decoration: none;
					color: #333;
				}

				.thim-setup-content .close:before {
					content: "\f335";
					font-family: Dashicons;
				}

				.thim-setup-content .header {
					border-bottom: 1px solid #ddd;
					padding-bottom: 20px;
					margin-bottom: 20px;
				}

				.thim-setup-content .header .title {
					color: #666;
					margin: 0 0 30px;
					font-size: 40px;
				}

				.text-center {
					text-align: center;
				}

				mark {
					background-color: transparent;
				}

				mark.yes {
					color: #8BC34A;
				}

				mark.error {
					color: #F44336;
				}

				mark.warning {
					color: #FFC107;
				}

				.thim-setup-content table {
					margin-bottom: 20px;
				}

				.thim-setup-content table th {
					font-size: 16px;
				}

				.thim-core-active > h2 {
					color: #8BC34A;
				}

				.thim-setup-content .notice {
					margin-left: 0;
					margin-right: 0;
				}

				.thim-setup-content .updating-message p:before {
					margin-right: 10px;
				}

				.footer .brand {
					color: rgba(0, 0, 0, 0.1);
					font-size: 20px;
					line-height: 100px;
				}
			</style>
			<?php
		}

		/**
		 * Setup page installer.
		 *
		 * @since 1.0.0
		 */
		public function setup_page() {
			if ( ! $this->is_this_page() ) {
				return;
			}

			if ( ob_get_length() > 0 ) {
				ob_end_clean();
			}

			do_action( 'thim_core_install_enqueue_script' );

			$this->setup_header();
			$this->setup_content();
			$this->setup_footer();

			exit();
		}

		/**
		 * Setup content.
		 *
		 * @since 1.0.0
		 */
		private function setup_content() {
			$theme = $this->theme;

			$thim_core   = $this->get_thim_core();
			$status      = $thim_core->get_status();
			$can_install = $this->check_require();
			$step        = isset( $_REQUEST['step'] ) ? $_REQUEST['step'] : 'start';
			?>
			<div class="thim-setup-content">
				<a class="close" href="<?php echo esc_url( admin_url() ) ?>"></a>

				<div class="header text-center">
					<h1 class="title"><?php esc_html_e( 'Thim Core Installer', 'eduma' ) ?></h1>
					<div class="sub-title">
						<?php printf( __( 'Welcome to the Thim Core Installer where you set up %1$s - the first step to build your own online LMS Website. Thank you for choosing %1$s!.', 'eduma' ), $theme['name'] ); ?>
					</div>
				</div>

				<?php if ( $status !== 'active' || $step != 'start' ) : ?>

					<?php if ( ! $can_install ) {
						$this->setup_environments();
					} else {
						do_action( "thim_core_installer_step_$step" );
					} ?>

				<?php else: ?>

					<div class="thim-core-active">
						<h2><?php esc_html_e( 'Your site have already installed Thim Core!', 'eduma' ); ?></h2>

						<div><?php printf( __( '<button data-href="%s" class="thim-button-link button button-primary">Return to Dashboard</button>', 'eduma' ), admin_url( 'admin.php?page=thim-dashboard' ) ) ?></div>
					</div>

				<?php endif; ?>

			</div>
			<?php
		}

		/**
		 * Prepare installation Thim Core.
		 *
		 * @since 1.0.0
		 */
		public function prepare_installation() {
			$thim_core = $this->get_thim_core();
			$status    = $thim_core->get_status();

			$step = ( $status == 'inactive' ) ? 'activate' : 'install';
			$link = $this->get_link_step( $step );
			?>
			<div class="install-container text-center">
				<button class="thim-button-link button button-primary"
						data-href="<?php echo esc_url( $link ) ?>"><?php esc_html_e( 'Install and activate', 'eduma' ) ?></button>
			</div>
			<?php
		}

		/**
		 * Step install.
		 *
		 * @since 1.0.0
		 */
		public function step_install() {
			$link = $this->get_link_step( 'activate' );

			$plugin = $this->get_thim_core();
			$status = $plugin->get_status();
			if ( $status != 'not_installed' ) {
				self::redirect( $link );
			}

			$result = $plugin->install();

			$messages = $plugin->get_messages();
			$notice   = $result ? 'success' : 'error';
			?>
			<h3><?php esc_html_e( 'Installing Thim Core', 'eduma' ) ?></h3>

			<div class="messages notice notice-<?php echo esc_attr( $notice ) ?>">
				<?php foreach ( $messages as $message ): ?>
					<p><?php echo $message ?></p>
				<?php endforeach;; ?>
			</div>

			<h3><?php esc_html_e( 'Activating Thim Core', 'eduma' ) ?></h3>
			<div class="updating-message notice notice-success">
				<p><?php esc_html_e( 'Activating...', 'eduma' ) ?></p>
			</div>
			<?php

			if ( $result ) {
				do_action( 'thim_core_installer_install_success' );

				self::redirect( $link );
			}
		}

		/**
		 * Step active.
		 *
		 * @since 1.0.0
		 */
		public function step_activate() {
			$plugin = $this->get_thim_core();
			$theme  = $this->theme;

			if ( $plugin->activate( true ) || $plugin->is_active() ) {
				?>
				<h3><?php esc_html_e( 'Activating Thim Core successfully!', 'eduma' ) ?></h3>
				<div class="updating-message notice notice-success">
					<p><?php printf( __( 'You are redirecting to %s theme dashboard...', 'eduma' ), $theme['name'] ) ?></p>
				</div>
				<?php

				$this->reload_to_redirect_dashboard();

				return;
			}

			$link = $this->get_link_step( 'activate' );

			?>
			<h3><?php esc_html_e( 'Activating Thim Core failed!', 'eduma' ) ?></h3>
			<div class="notice notice-error">
				<p><?php esc_html_e( 'Something went wrong!', 'eduma' ) ?></p>
				<p>
					<button data-href="<?php echo esc_url( $link ) ?>"
							class="thim-button-link button button-primary"><?php esc_html_e( 'Activate again', 'eduma' ) ?></button>
				</p>
			</div>

			<?php
		}

		/**
		 * Reload to redirect to theme dashboard.
		 *
		 * @since 1.0.0
		 */
		private function reload_to_redirect_dashboard() {
			$url = admin_url( '?thim-redirect-to-theme-dashboard' );

			self::redirect( $url );
		}

		/**
		 * Setup environments.
		 *
		 * @since 1.0.0
		 */
		private function setup_environments() {
			$args  = $this->get_environments();
			$theme = $this->theme;
			?>
			<table class="widefat striped" cellspacing="0">
				<thead>
				<tr>
					<th colspan="2"><?php esc_html_e( 'Configuration Check', 'eduma' ) ?></th>
				</tr>
				</thead>

				<tbody>
				<tr>
					<td><?php esc_html_e( 'Server Info', 'eduma' ); ?></td>
					<td><?php echo esc_html( $args['server_info'] ); ?></td>
				</tr>

				<tr>
					<td><?php esc_html_e( 'PHP Version', 'eduma' ); ?></td>
					<td>
						<?php
						if ( version_compare( $args['php_version'], '5.6', '<' ) ) {
							echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( __( '%1$s - We recommend a minimum PHP version of 5.6. See: %2$s', 'eduma' ), esc_html( $args['php_version'] ), '<a href="https://goo.gl/WRBYv3" target="_blank">' . __( 'How to update your PHP version', 'eduma' ) . '</a>' ) . '</mark>';
						} else {
							echo '<mark class="yes">' . esc_html( $args['php_version'] ) . '</mark>';
						}
						?>
					</td>
				</tr>

				<tr>
					<td><?php esc_html_e( 'PHP Memory Limit', 'eduma' ); ?></td>
					<td>
						<?php
						if ( $args['memory_limit'] < 134217728 ) {
							echo '<mark class="warning">' . sprintf( __( '<strong>%s</strong> - We recommend setting memory to at least <strong>128MB</strong>. To learn how, see: <a href="%s" target="_blank">Increasing memory allocated to PHP.</a>', 'eduma' ), size_format( $args['memory_limit'] ), 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP' ) . '</mark>';
						} else {
							echo '<mark class="yes">' . size_format( $args['memory_limit'] ) . '</mark>';
						}
						?>
					</td>
				</tr>

				<tr>
					<td><?php _e( 'cURL version', 'eduma' ); ?>:</td>
					<td><?php echo esc_html( $args['curl_version'] ) ?></td>
				</tr>


				<tr>
					<td><?php _e( 'Plugins directory', 'eduma' ); ?></td>
					<td>
						<mark><code><?php echo esc_html( $args['plugins_directory'] ); ?></code></mark>
					</td>

				</tr>

				<tr>
					<td><?php _e( 'Plugins directory writable', 'eduma' ); ?></td>

					<td><?php if ( $args['plugins_writable'] ) {
							printf( '<mark class="yes"><span class="dashicons dashicons-yes"></span><code>%s</code></mark>', $args['plugins_chmod'] );
						} else {
							printf( '<mark class="error"><span class="dashicons dashicons-warning"></span> Can not put file to folder <code data-chmod="%s">%s</code>. <a href="%s" target="_blank">How to change file or folder permissions in WordPress.</a></mark>', $args['plugins_chmod'], $args['plugins_directory'], 'https://goo.gl/guirO5' );
						} ?>
					</td>
				</tr>
				</tbody>
			</table>

			<div class="notice notice-error">
				<p><?php printf( __( 'Please follow those instructions above to make sure your server is ready to use %s theme. If you need assistance, please get our support <a href="%s" target="_blank">here</a>.', 'eduma' ), $theme['name'], $theme['support'] ) ?></p>
			</div>
			<?php
		}

		/**
		 * Setup header.
		 *
		 * @since 1.0.0
		 */
	private function setup_header() {
		$theme     = $this->theme;
		$thim_core = $this->get_thim_core();
		$status    = $thim_core->get_status();
		?>
		<!DOCTYPE html>
		<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
		<head>
			<meta name="viewport" content="width=device-width"/>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			<title><?php printf( __( 'Thim Core Installer &lsaquo; %s', 'eduma' ), $theme['name'] ) ?></title>
			<?php do_action( 'admin_print_scripts' ); ?>
			<?php do_action( 'thim_core_installer_head' ); ?>
		</head>
		<body class="thim-core-installer wp-core-ui thim-core-status-<?php echo esc_attr( $status ) ?>">
		<?php
		}

		/**
		 * Setup footer.
		 *
		 * @since 1.0.0
		 */
		private function setup_footer() {
		?>
		<div class="footer text-center">
			<div class="brand">
				<?php echo '&copy; ThimPress ' . date( 'Y' ) . '. All rights reserved. Powered by WordPress.'; ?>
			</div>
		</div>
		</body>
		<?php
		do_action( 'admin_footer' );
		do_action( 'admin_print_footer_scripts' );
		do_action( 'thim_core_installer_footer' );
		?>
		</html>
		<?php
	}
	}
}

function thim_core_installer() {
	new Thim_Core_Installer();
}

add_action( 'after_setup_theme', 'thim_core_installer' );

