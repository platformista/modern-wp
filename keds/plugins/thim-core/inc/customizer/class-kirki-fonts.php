<?php
/**
 * Use for back-compatibility.
 * 
 * TODO: Remove "Kirki_Fonts::get_all_variants()" on theme.
 */
if ( ! class_exists( 'Kirki_Fonts' ) ) {
	class Kirki_Fonts {
		public static function get_all_variants() {
			return array(
				'100'       => esc_html__( 'Ultra-Light 100', 'kirki' ),
				'100light'  => esc_html__( 'Ultra-Light 100', 'kirki' ),
				'100italic' => esc_html__( 'Ultra-Light 100 Italic', 'kirki' ),
				'200'       => esc_html__( 'Light 200', 'kirki' ),
				'200italic' => esc_html__( 'Light 200 Italic', 'kirki' ),
				'300'       => esc_html__( 'Book 300', 'kirki' ),
				'300italic' => esc_html__( 'Book 300 Italic', 'kirki' ),
				'400'       => esc_html__( 'Normal 400', 'kirki' ),
				'regular'   => esc_html__( 'Normal 400', 'kirki' ),
				'italic'    => esc_html__( 'Normal 400 Italic', 'kirki' ),
				'500'       => esc_html__( 'Medium 500', 'kirki' ),
				'500italic' => esc_html__( 'Medium 500 Italic', 'kirki' ),
				'600'       => esc_html__( 'Semi-Bold 600', 'kirki' ),
				'600bold'   => esc_html__( 'Semi-Bold 600', 'kirki' ),
				'600italic' => esc_html__( 'Semi-Bold 600 Italic', 'kirki' ),
				'700'       => esc_html__( 'Bold 700', 'kirki' ),
				'700italic' => esc_html__( 'Bold 700 Italic', 'kirki' ),
				'800'       => esc_html__( 'Extra-Bold 800', 'kirki' ),
				'800bold'   => esc_html__( 'Extra-Bold 800', 'kirki' ),
				'800italic' => esc_html__( 'Extra-Bold 800 Italic', 'kirki' ),
				'900'       => esc_html__( 'Ultra-Bold 900', 'kirki' ),
				'900bold'   => esc_html__( 'Ultra-Bold 900', 'kirki' ),
				'900italic' => esc_html__( 'Ultra-Bold 900 Italic', 'kirki' ),
			);
		}
	}
}
