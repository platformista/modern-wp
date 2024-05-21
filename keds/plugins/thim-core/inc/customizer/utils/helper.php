<?php
namespace ThimPress\Customizer\Utils;

class Helper {
	public static function prepare_php_array_for_js( $values ) {

		foreach ( $values as $key => $value ) {
			if ( ! is_scalar( $value ) ) {
				continue;
			}

			$values[ $key ] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8' );
		}

		return $values;

	}

	public static function compare_values( $value1, $value2, $operator ) {
		if ( '===' === $operator ) {
			return $value1 === $value2;
		}
		if ( '!==' === $operator ) {
			return $value1 !== $value2;
		}
		if ( ( '!=' === $operator || 'not equal' === $operator ) ) {
			return $value1 != $value2; // phpcs:ignore WordPress.PHP.StrictComparisons
		}
		if ( ( '>=' === $operator || 'greater or equal' === $operator || 'equal or greater' === $operator ) ) {
			return $value2 >= $value1;
		}
		if ( ( '<=' === $operator || 'smaller or equal' === $operator || 'equal or smaller' === $operator ) ) {
			return $value2 <= $value1;
		}
		if ( ( '>' === $operator || 'greater' === $operator ) ) {
			return $value2 > $value1;
		}
		if ( ( '<' === $operator || 'smaller' === $operator ) ) {
			return $value2 < $value1;
		}
		if ( 'contains' === $operator || 'in' === $operator ) {
			if ( is_array( $value1 ) && is_array( $value2 ) ) {
				foreach ( $value2 as $val ) {
					if ( in_array( $val, $value1 ) ) { // phpcs:ignore WordPress.PHP.StrictInArray
						return true;
					}
				}
				return false;
			}
			if ( is_array( $value1 ) && ! is_array( $value2 ) ) {
				return in_array( $value2, $value1 ); // phpcs:ignore WordPress.PHP.StrictInArray
			}
			if ( is_array( $value2 ) && ! is_array( $value1 ) ) {
				return in_array( $value1, $value2 ); // phpcs:ignore WordPress.PHP.StrictInArray
			}
			return ( false !== strrpos( $value1, $value2 ) || false !== strpos( $value2, $value1 ) );
		}
		if ( 'does not contain' === $operator || 'not in' === $operator ) {
			return ! self::compare_values( $value1, $value2, $operator );
		}
		return $value1 == $value2; // phpcs:ignore WordPress.PHP.StrictComparisons
	}

	public static function array_replace_recursive( $array, $array1 ) {
		if ( function_exists( 'array_replace_recursive' ) ) {
			return array_replace_recursive( $array, $array1 );
		}

		$args  = func_get_args(); // phpcs:ignore PHPCompatibility.FunctionUse.ArgumentFunctionsReportCurrentValue
		$array = $args[0];

		if ( ! is_array( $array ) ) {
			return $array;
		}

		$count = count( $args );

		for ( $i = 1; $i < $count; $i++ ) {
			if ( is_array( $args[ $i ] ) ) {
				$array = self::recurse( $array, $args[ $i ] );
			}
		}
		
		return $array;
	}
}
