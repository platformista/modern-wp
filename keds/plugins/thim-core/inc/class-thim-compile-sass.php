<?php

/**
 * Class Thim_Compile_SASS
 *
 * @package   Thim_Core
 * @since     0.1.0
 */

use Leafo\ScssPhp\Compiler;

if ( ! class_exists( 'Thim_Compile_SASS' ) ) {

    class Thim_Compile_SASS extends Thim_Singleton {
        /**
         * Thim_Compile_SASS constructor.
         *
         * @since 0.1.0
         */
        protected function __construct() {
            $this->init();
        }

        /**
         * Init class.
         *
         * @since 0.1.0
         */
        private function init() {
            $this->libraries();
        }

        /**
         * Includes libraries.
         *
         * @since 0.1.0
         */
        private function libraries() {
            if ( class_exists( 'Leafo\ScssPhp\Compiler' ) ) {
                return;
            }

            require_once THIM_CORE_INC_PATH . '/includes/sass/scss.inc.php';
        }

        /**
         * Get custom css in theme.
         *
         * @since 1.0.5
         *
         * @return string
         */
        private function get_custom_css_field() {
            $field_custom_css = apply_filters( 'thim_core_field_name_custom_css_theme', 'custom_css_field' );
            $custom_css       = trim( get_theme_mod( $field_custom_css, '' ) );

            return $custom_css;
        }

        /**
         * Get css from scss.
         *
         * @param array $scss_config
         * @param array $variables_sass
         *
         * @return string|WP_Error
         * @since 0.1.0
         */
        private function get_css( $scss_config, $variables_sass ) {
            try {
                $dir  = $scss_config['dir'];
                $name = $scss_config['name'];

                if ( ! file_exists( trailingslashit( $dir ) . $name ) ) {
                    Thim_Core_Customizer::message_customize_error( 'File ' . $name . ' not exist!' );

                    return new WP_Error( 'TC_FILE_NOT_FOUND', 'File ' . $name . ' not exist!' );
                }

                $scss = new Compiler();
                $scss->setImportPaths( $dir );
                $scss->setFormatter( 'Leafo\ScssPhp\Formatter\Compressed' );

                $scss->setVariables( $variables_sass );

                $css        = $scss->compile( '@import "' . $name . '";' );
                $custom_css = $this->get_custom_css_field();

                return $css . $custom_css;
            } catch ( Exception $e ) {
                Thim_Core_Customizer::message_customize_error( $e->getMessage() );

                return new WP_Error( 'TC_COMPILE_SCSS_FAILED', $e->getMessage() );
            }
        }

        /**
         * Compile scss to css.
         *
         * @param array $scss_config
         * @param array $variables_sass
         *
         * @return string|WP_Error
         * @since 0.1.0
         */
        public function compile_scss( $scss_config, $variables_sass ) {
            do_action( 'tc_before_compile_scss_theme' );

            if ( TP::is_debug() ) {
                try {
                    $this->put_file_variables_scss( $scss_config['dir'], $variables_sass );
                } catch ( Exception $e ) {
                    Thim_Core_Customizer::message_customize( 'Put file variables SCSS error!' . '(' . $e->getMessage() . ')' );
                }
            }

            return $this->get_css( $scss_config, $variables_sass );
        }

        /**
         * Put file variables scss.
         *
         * @param $dir string
         * @param $variables array
         *
         * @since 0.1.0
         */
        private function put_file_variables_scss( $dir, $variables ) {
            if ( empty( $variables ) ) {
                return;
            }

            $scss = '';
            foreach ( $variables as $key => $value ) {
                $variable = '$' . $key;

                $scss .= $variable . ':' . $value . ";\n";
            }

            Thim_File_Helper::put_file( $dir, '_thim_customize.scss', $scss );
        }
    }
}
