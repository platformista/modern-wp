<?php

/**
 * Class Thim_Getting_Started
 *
 * @since 0.8.3
 */
class Thim_Getting_Started extends Thim_Admin_Sub_Page {
    /**
     * @var string
     *
     * @since 0.8.5
     */
    public $key_page = 'getting-started';

    /**
     * Get steps.
     *
     * @since 0.8.3
     *
     * @return array
     */
    public static function get_steps() {
        $steps = array();

        $steps[] = array(
            'key'   => 'welcome',
            'title' => __( 'Welcome', 'thim-core' ),
        );

        $steps[] = array(
            'key'   => 'quick-setup',
            'title' => __( 'Setup', 'thim-core' ),
        );


        $is_active = Thim_Product_Registration::is_active();
        if ( ! $is_active && ! Thim_Free_Theme::get_theme_id() ) {
            $envato_id = Thim_Theme_Manager::get_data( 'envato_item_id', false );
            if ( $envato_id ) {
                $steps[] = array(
                    'key'   => 'updates',
                    'title' => __( 'Updates', 'thim-core' ),
                );
            }
        }

        $plugins = Thim_Plugins_Manager::get_required_plugins_inactive();
        if ( count( $plugins ) > 0 ) {
            $steps[] = array(
                'key'   => 'install-plugins',
                'title' => __( 'Plugins', 'thim-core' ),
            );
        }

        $steps[] = array(
            'key'   => 'import-demo',
            'title' => __( 'Import', 'thim-core' ),
        );

        $steps[] = array(
            'key'   => 'customize',
            'title' => __( 'Customize', 'thim-core' ),
        );

        $steps[] = array(
            'key'   => 'support',
            'title' => __( 'Support', 'thim-core' ),
        );

        $steps[] = array(
            'key'   => 'finish',
            'title' => __( 'Ready', 'thim-core' ),
        );

        return $steps;
    }

    /**
     * Get link redirect to step.
     *
     * @since 0.8.9
     *
     * @param $step
     *
     * @return string
     */
    public static function get_link_redirect_step( $step ) {
        $self = self::instance();
        $base = Thim_Dashboard::get_link_page_by_slug( $self->key_page );

        return add_query_arg( array( 'redirect' => $step ), $base );
    }

    /**
     * Thim_Getting_Started constructor.
     *
     * @since 0.8.3
     */
    protected function __construct() {
        parent::__construct();

        $this->init_hooks();
    }

    /**
     * Initialize hooks.
     *
     * @since 0.8.3
     */
    private function init_hooks() {
        add_action( 'admin_init', array( $this, 'redirect_to_tep' ) );
        add_action( 'tc_after_dashboard_wrapper', array( $this, 'add_modals_importer' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'thim_getting_started_main_content', array( $this, 'render_step_templates' ) );
        add_action( 'wp_ajax_thim-get-started', array( $this, 'handle_ajax' ) );
        add_filter( 'thim_dashboard_sub_pages', array( $this, 'add_sub_page' ) );
        add_action( 'admin_init', array( $this, 'notice_visited' ) );
    }

    /**
     * Notice customer has already visited.
     *
     * @since 0.8.9
     */
    public function notice_visited() {
        if ( ! $this->is_myself() ) {
            return;
        }

        if ( ! $this->already_visited() ) {
            return;
        }

        Thim_Notification::add_notification(
            array(
                'id'          => 'gs-visited',
                'type'        => 'warning',
                'content'     => __( 'Oops! It seems you already setup your site.', 'thim-core' ),
                'dismissible' => true,
                'global'      => false,
            )
        );
    }

    /**
     * Redirect to step.
     *
     * @since 0.8.9
     */
    public function redirect_to_tep() {
        if ( ! $this->is_myself() ) {
            return;
        }

        $step_redirect = ! empty( $_GET['redirect'] ) ? $_GET['redirect'] : false;
        if ( ! $step_redirect ) {
            return;
        }

        $steps = self::get_steps();
        foreach ( $steps as $index => $step ) {
            if ( $step['key'] == $step_redirect ) {
                $url = $this->get_link_myself() . "#step-$index";

                thim_core_redirect( $url );
            }
        }
    }

    /**
     * Check already visited.
     *
     * @since 1.2.1
     *
     * @return bool
     */
    public function already_visited() {
        $option = Thim_Admin_Settings::get( 'getting_started_visited', false );

        return (bool) $option;
    }

    /**
     * Add modals importer.
     *
     * @since 0.8.5
     */
    public function add_modals_importer() {
        if ( ! $this->is_myself() ) {
            return;
        }

        Thim_Dashboard::get_template( 'partials/importer-modal.php' );
        Thim_Dashboard::get_template( 'partials/importer-uninstall-modal.php' );
    }

    /**
     * Add sub page.
     *
     * @since 0.8.5
     *
     * @param $sub_pages
     *
     * @return mixed
     */
    public function add_sub_page( $sub_pages ) {
        $sub_pages['getting-started'] = array(
            'title' => '',
        );

        return $sub_pages;
    }

	/**
	 * Enqueue scripts.
	 *
	 * @since 0.8.3
	 */
	public function enqueue_scripts() {
		if ( ! $this->is_myself() ) {
			return;
		}

//		$min = '.min';
		$ver = THIM_CORE_VERSION;
		if ( TP::is_debug() ) {
//			$min = '';
			$ver = uniqid();
		}
		$extend =  '.min.js';

		wp_enqueue_script( 'thim-plugins', THIM_CORE_ADMIN_URI . '/assets/js/plugins/thim-plugins.js', array( 'jquery' ),THIM_CORE_VERSION );
		wp_enqueue_script( 'thim-importer', THIM_CORE_ADMIN_URI . '/assets/js/importer/importer'. $extend, array(
			'wp-util',
			'jquery',
			'backbone',
			'underscore'
		) ,$ver);
		wp_enqueue_script( 'thim-getting-started', THIM_CORE_ADMIN_URI . '/assets/js/getting-started/getting-started-v2' . $extend, array(
			'thim-plugins',
			'thim-importer',
			'thim-video-youtube'
		),$ver );

		$this->localize_script();
	}

    /**
     * Localize script.
     *
     * @since 0.8.3
     */
    private function localize_script() {
        wp_localize_script( 'thim-getting-started', 'thim_gs', array(
            'url_ajax' => admin_url( 'admin-ajax.php?action=thim-get-started&step=' ),
            'steps'    => self::get_steps()
        ) );

        $thim_plugins_manager = Thim_Plugins_Manager::instance();
        $thim_plugins_manager->localize_script();

        $thim_importer = Thim_Importer::instance();
        $thim_importer->localize_script();
    }

    /**
     * Handle ajax.
     *
     * @since 0.8.3
     */
    public function handle_ajax() {
        $step = ! empty( $_REQUEST['step'] ) ? $_REQUEST['step'] : false;

        switch ( $step ) {
            case 'quick-setup':
                $this->handle_quick_setup();
                break;

            case 'finish':
                $this->handle_finish();
                break;

            default:
                break;
        }

        wp_die();
    }

    /**
     * Handle finish getting started.
     *
     * @since 1.2.1
     */
    private function handle_finish() {
        Thim_Admin_Settings::set( 'getting_started_visited', true );
        wp_send_json_success();
    }

    /**
     * Handle quick setup.
     *
     * @since 0.8.3
     */
    private function handle_quick_setup() {
        $blog_name = isset( $_POST['blogname'] ) ? esc_html( $_POST['blogname'] ) : false;
        if ( $blog_name !== false ) {
            update_option( 'blogname', $blog_name );
        }

        $blog_description = isset( $_POST['blogdescription'] ) ? esc_html( $_POST['blogdescription'] ) : false;
        if ( $blog_description !== false ) {
            update_option( 'blogdescription', $blog_description );
        }

        wp_send_json_success( __( 'Saving successful!', 'thim-core' ) );
    }

    /**
     * Render step templates.
     *
     * @since 0.8.3
     */
    public function render_step_templates() {
        $steps = self::get_steps();

        foreach ( $steps as $index => $step ) {
            $key = strtolower( $step['key'] );
            $this->render_step_template( $key );
        }
    }

    /**
     * Get step template by slug.
     *
     * @since 0.8.3
     *
     * @param string $slug
     *
     * @return bool
     */
    public function render_step_template( $slug ) {
        $template_path = 'dashboard/gs-steps/' . $slug . '.php';
        $template_path = apply_filters( "thim_core_path_template_getting_started_$slug", $template_path, $slug );

        $html = Thim_Template_Helper::template( $template_path );

        return Thim_Template_Helper::template( 'dashboard/gs-steps/master.php', array(
            'slug' => $slug,
            'html' => $html
        ), true );
    }
}
