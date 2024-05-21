<?php
/**
 * ThimPress Customizer Autoloader
 *
 * Author:          Nhamdv <daonham95@gmail.com>
 * Created on:      28/09/2022
 */

namespace ThimPress\Customizer;

class Autoloader {

	protected $prefixes = array();

	public function register() {
		spl_autoload_register( array( $this, 'load_class' ) );
	}

	public function add_namespace( $prefix, $base_dir, $prepend = false ) {
		$prefix   = trim( $prefix, '\\' ) . '\\';
		$base_dir = rtrim( $base_dir, DIRECTORY_SEPARATOR ) . '/';

		if ( isset( $this->prefixes[ $prefix ] ) === false ) {
			$this->prefixes[ $prefix ] = array();
		}

		if ( $prepend ) {
			array_unshift( $this->prefixes[ $prefix ], $base_dir );
		} else {
			array_push( $this->prefixes[ $prefix ], $base_dir );
		}
	}


	public function load_class( $class ) {
		$prefix = $class;

		while ( false !== strrpos( $prefix, '\\' ) ) {
			$pos    = strrpos( $prefix, '\\' );
			$prefix = substr( $class, 0, $pos + 1 );

			$relative_class = substr( $class, $pos + 1 );

			$mapped_file = $this->load_mapped_file( $prefix, $relative_class );

			if ( $mapped_file ) {
				return $mapped_file;
			}

			$prefix = rtrim( $prefix, '\\' );
		}

		return false;
	}

	protected function load_mapped_file( $prefix, $relative_class ) {
		if ( isset( $this->prefixes[ $prefix ] ) === false ) {
			return false;
		}

		foreach ( $this->prefixes[ $prefix ] as $base_dir ) {
			$relative_class = strtolower( str_replace( '\\', '/', $relative_class ) );
			$file           = $base_dir . $relative_class . '.php';

			if ( $this->require_file( $file ) ) {
				return $file;
			}
		}

		return false;
	}

	protected function require_file( $file ) {
		require $file;
		return true;
	}
}
