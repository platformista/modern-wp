<?php

/**
 * Class Thim_Notification.
 *
 * @since 0.8.7
 */
if ( ! class_exists( 'Thim_Notification' ) ) {

	class Thim_Notification extends Thim_Singleton {
		/**
		 * @since 0.8.7
		 *
		 * @var string
		 */
		private static $key_options = 'thim_hide_notifications';

		/**
		 * @since 0.8.7
		 *
		 * @var null|array
		 */
		private static $notifications_hidden = null;

		/**
		 * Thim_Notification constructor.
		 *
		 * @since 0.8.7
		 */
		protected function __construct() {
			$this->init_hooks();
		}

		/**
		 * Init hooks.
		 *
		 * @since 0.8.7
		 */
		private function init_hooks() {
			add_action( 'thim_dashboard_notifications', array( __CLASS__, 'print_notifications' ) );
			add_action( 'admin_notices', array( __CLASS__, 'print_global_notifications' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'wp_ajax_thim_hide_notification', array( $this, 'ajax_hide_notification' ) );
		}

		/**
		 * Enqueue scripts.
		 *
		 * @since 0.8.7
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'thim-notifications', THIM_CORE_ADMIN_URI . '/assets/js/notifications.js', array( 'wp-util', 'jquery', 'backbone', 'underscore' ), THIM_CORE_VERSION );
			$this->localize_scripts();
		}

		/**
		 * Localize scripts.
		 *
		 * @since 0.8.7
		 */
		private function localize_scripts() {
			wp_localize_script( 'thim-notifications', 'thim_notifications', array(
				'ajax' => admin_url( 'admin-ajax.php?action=thim_hide_notification' ),
			) );
		}

		/**
		 * Handle ajax hide notifications.
		 *
		 * @since 0.8.7
		 */
		public function ajax_hide_notification() {
			$id = isset( $_POST['id'] ) ? esc_html( $_POST['id'] ) : false;
			self::hide_notification( $id );

			wp_send_json_success();
		}

		/**
		 * Print global notifications.
		 *
		 * @since 0.8.8
		 */
		public static function print_global_notifications() {
			global $thim_notifications;
			$notifications = $thim_notifications;

			foreach ( $notifications as $notification ) {
				if ( ! $notification['global'] ) {
					continue;
				}

				$id = $notification['id'];
				if ( self::is_hidden( $id ) ) {
					continue;
				}

				$type = $notification['type'];

				$class = "tc-$type notice notice-$type";
				if ( $notification['dismissible'] && ! empty( $id ) ) {
					$class .= ' is-dismissible';
				}

				?>
                <div class="tc-notice <?php echo esc_attr( $class ); ?>" data-id="<?php echo esc_attr( $notification['id'] ); ?>">
                    <div class="content"><?php echo $notification['content']; ?></div>
					<?php if ( $notification['dismissible'] ): ?>
                        <button type="button" class="thimcore-notice-dismiss button button-secondary" style="margin: 0 0 0.8em 10px;"><span>Dismiss this notice.</span></button>
					<?php endif; ?>
                </div>
				<?php
			}
		}

		/**
		 * Print notifications.
		 *
		 * @since 0.8.7
		 */
		public static function print_notifications() {
			global $thim_notifications;
			$notifications = $thim_notifications;

			foreach ( $notifications as $notification ) {
				$id = $notification['id'];
				if ( self::is_hidden( $id ) ) {
					continue;
				}

				$type = $notification['type'];

				$class = "tc-$type";
				if ( $notification['dismissible'] && ! empty( $id ) ) {
					$class .= ' is-dismissible';
				}

				?>
                <div class="tc-notice <?php echo esc_attr( $class ); ?>" data-id="<?php echo esc_attr( $notification['id'] ); ?>">
                    <div class="content"><?php echo $notification['content']; ?></div>
					<?php if ( $notification['dismissible'] ): ?>
                        <button type="button" class="thimcore-notice-dismiss button button-secondary" style="margin: 0 0 0.8em 10px;"><span>Dismiss this notice.</span></button>
					<?php endif; ?>
                </div>
				<?php
			}
		}

		/**
		 * Hide notification.
		 *
		 * @since 0.8.7
		 *
		 * @param $id
		 *
		 * @return bool
		 */
		private function hide_notification( $id ) {
			if ( empty( $id ) ) {
				return false;
			}

			if ( self::is_hidden( $id ) ) {
				return false;
			}

			$all   = self::get_notifications_hidden();
			$all[] = $id;

			return update_option( self::$key_options, $all );
		}

		/**
		 * Is notification hidden.
		 *
		 * @since 0.8.7
		 *
		 * @param $notification_id
		 *
		 * @return bool
		 */
		private static function is_hidden( $notification_id ) {
			if ( empty( $notification_id ) ) {
				return false;
			}

			$notifications_hidden = self::get_notifications_hidden();

			foreach ( $notifications_hidden as $id ) {
				if ( $notification_id == $id ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Get all notifications hidden.
		 *
		 * @since 0.8.7
		 *
		 * @return array
		 */
		private static function get_notifications_hidden() {
			if ( self::$notifications_hidden === null ) {
				self::$notifications_hidden = (array) get_option( self::$key_options );
			}

			return self::$notifications_hidden;
		}

		/**
		 * Add notification.
		 *
		 * @since 0.8.7
		 *
		 * @param array $notification
		 * - type: 'success', 'error', 'warning'
		 * - id: unique id
		 * - content: content
		 * - dismissible: is dismissible
		 */
		public static function add_notification( $notification ) {
			$notification = wp_parse_args( $notification, array(
				'id'          => '',
				'type'        => 'success',
				'content'     => '',
				'dismissible' => false,
				'global'      => false,
			) );

			global $thim_notifications;

			$thim_notifications[] = $notification;
		}
	}
}
