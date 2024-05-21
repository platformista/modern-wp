<?php

/**
 * Class Thim_Check_Update_My_Theme.
 *
 * @since 1.7.1
 */
class Thim_Check_Update_My_Theme {
    /**
     * Slug.
     *
     * @since 1.7.1
     *
     * @var string
     */
    private $slug = '';

    /**
     * Theme id.
     *
     * @since 1.7.1
     *
     * @var string
     */
    private $id = '';

    /**
     * Theme data.
     *
     * @since 1.1.0
     *
     * @var array
     */
    private $theme_data = null;

    /**
     * Theme current version.
     *
     * @since 1.7.1
     *
     * @var string
     */
    private $local_version = null;

    /**
     * Thim_Check_Update_My_Theme constructor.
     *
     * @since 1.7.1
     *
     * @param $slug
     * @param $id
     * @param $local_version
     */
    public function __construct( $slug, $local_version, $id = '' ) {
        $this->slug          = $slug;
        $this->id            = $id;
        $this->local_version = $local_version;
    }

    /**
     * Check theme update by item id.
     *
     * @since 1.1.0
     *
     * @return bool
     */
    public function can_update() {
        $remote_version = $this->get_remote_version();
        if ( ! $remote_version ) {
            return false;
        }

        $local_version = $this->local_version;

        return version_compare( $remote_version, $local_version, '>' );
    }

    /**
     * Get remote version.
     *
     * @since 1.7.1
     *
     * @return false|string
     */
    public function get_remote_version() {
        $data = $this->get_theme_data();
        if ( ! $data ) {
            return false;
        }

        return $data['version'];
    }

    /**
     * Get theme data.
     *
     * @since 1.7.1
     *
     * @return false|array
     */
    public function get_theme_data() {
        if ( $this->theme_data === null ) {
            $this->theme_data = $this->get_theme_data_remote();
        }

        return $this->theme_data;
    }

    /**
     * Get theme data form api.
     *
     * @since 1.7.1
     *
     * @return false|array
     */
    private function get_theme_data_remote() {
        $data = Thim_Market_Service::get_theme_detail( $this->slug, $this->id );

        if ( is_wp_error( $data ) ) {
            return false;
        }

        return $data;
    }
}
