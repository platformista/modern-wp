<?php
add_action( 'pmpro_membership_level_after_other_settings', 'thim_add_icon_package_membership', 11, 1 );
function thim_add_icon_package_membership() {
	$val = get_option( 'thim_level_' . $_GET['edit'] ) ? get_option( 'thim_level_' . $_GET['edit'] ) : '';
	?>
	<table class="form-table">
		<tbody>
		<tr class="membership_categories">
			<th scope="row" valign="top"><label><?php _e( 'Select Icon ', 'eduma' ); ?>:</label></th>
			<td>
				<input type="text" name="image_level" id="image_level" size="30" value="<?php echo $val; ?>">
			</td>
		</tr>
		</tbody>
	</table>
	<?php
}

add_action( 'pmpro_save_membership_level', 'thim_save_icon_package_membership', 10, 1 );
function thim_save_icon_package_membership( $level_id ) {
	$img = isset( $_POST['image_level'] ) ? $_POST['image_level'] : '';
	if ( get_option( 'thim_level_' . $level_id ) !== false ) {
		update_option( 'thim_level_' . $level_id, $img );
	} else {
		add_option( 'thim_level_' . $level_id, $img );
	}
}
/**
 * Filter level cost text paid membership pro
 */
add_filter( 'pmpro_level_cost_text', 'thim_pmpro_getLevelCost', 10, 4 );
if ( ! function_exists( 'thim_pmpro_getLevelCost' ) ) {
	function thim_pmpro_getLevelCost( $r, $level, $tags, $short ) {
		//initial payment
		if ( ! $short ) {
			$r = sprintf( __( 'The price for membership is <p class="price">%s</p>', 'eduma' ), pmpro_formatPrice( $level->initial_payment ) );
		} else {
			$r = sprintf( __( '%s', 'eduma' ), pmpro_formatPrice( $level->initial_payment ) );
		}

		//recurring part
		if ( $level->billing_amount != '0.00' ) {
			if ( $level->billing_limit > 1 ) {
				if ( $level->cycle_number == '1' ) {
					$r .= sprintf( __( '<p class="expired">then %s per %s for %d more %s</p>', 'eduma' ), pmpro_formatPrice( $level->billing_amount ), pmpro_translate_billing_period( $level->cycle_period ), $level->billing_limit, pmpro_translate_billing_period( $level->cycle_period, $level->billing_limit ) );
				} else {
					$r .= sprintf( __( '<p class="expired">then %s every %d %s for %d more payments</p>', 'eduma' ), pmpro_formatPrice( $level->billing_amount ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ), $level->billing_limit );
				}
			} elseif ( $level->billing_limit == 1 ) {
				$r .= sprintf( __( '<p class="expired">then %s after %d %s</p>', 'eduma' ), pmpro_formatPrice( $level->billing_amount ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
			} else {
				if ( $level->billing_amount === $level->initial_payment ) {
					if ( $level->cycle_number == '1' ) {
						if ( ! $short ) {
							$r = sprintf( __( 'The price for membership is <strong>%s per %s</strong>', 'eduma' ), pmpro_formatPrice( $level->initial_payment ), pmpro_translate_billing_period( $level->cycle_period ) );
						} else {
							$r = sprintf( __( '<p class="expired">%s per %s</p>', 'eduma' ), pmpro_formatPrice( $level->initial_payment ), pmpro_translate_billing_period( $level->cycle_period ) );
						}
					} else {
						if ( ! $short ) {
							$r = sprintf( __( 'The price for membership is <strong>%s every %d %s</strong>', 'eduma' ), pmpro_formatPrice( $level->initial_payment ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
						} else {
							$r = sprintf( __( '<p class="expired">%s every %d %s</p>', 'eduma' ), pmpro_formatPrice( $level->initial_payment ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
						}
					}
				} else {
					if ( $level->cycle_number == '1' ) {
						$r .= sprintf( __( '<p class="expired">then %s per %s</p>', 'eduma' ), pmpro_formatPrice( $level->billing_amount ), pmpro_translate_billing_period( $level->cycle_period ) );
					} else {
						$r .= sprintf( __( '<p class="expired">and then %s every %d %s</p>', 'eduma' ), pmpro_formatPrice( $level->billing_amount ), $level->cycle_number, pmpro_translate_billing_period( $level->cycle_period, $level->cycle_number ) );
					}
				}
			}
		}

		//trial part
		if ( $level->trial_limit ) {
			if ( $level->trial_amount == '0.00' ) {
				if ( $level->trial_limit == '1' ) {
					$r .= ' ' . __( 'After your initial payment, your first payment is Free.', 'eduma' );
				} else {
					$r .= ' ' . sprintf( __( 'After your initial payment, your first %d payments are Free.', 'eduma' ), $level->trial_limit );
				}
			} else {
				if ( $level->trial_limit == '1' ) {
					$r .= ' ' . sprintf( __( 'After your initial payment, your first payment will cost %s.', 'eduma' ), pmpro_formatPrice( $level->trial_amount ) );
				} else {
					$r .= ' ' . sprintf( __( 'After your initial payment, your first %d payments will cost %s.', 'eduma' ), $level->trial_limit, pmpro_formatPrice( $level->trial_amount ) );
				}
			}
		}

		//taxes part
		$tax_state = pmpro_getOption( "tax_state" );
		$tax_rate  = pmpro_getOption( "tax_rate" );

		if ( $tax_state && $tax_rate && ! pmpro_isLevelFree( $level ) ) {
			$r .= sprintf( __( 'Customers in %s will be charged %s%% tax.', 'eduma' ), $tax_state, round( $tax_rate * 100, 2 ) );
		}

		if ( ! $tags ) {
			$r = strip_tags( $r );
		}

		return $r;
	}
}

/**
 * Filters Paid Membership pro login redirect & register redirect
 */
remove_filter( 'login_redirect', 'pmpro_login_redirect', 10 );
add_filter( 'pmpro_register_redirect', '__return_false' );
add_filter( 'learn_press_pmpro_style_header', 'learn_press_pmpro_custom_icon_header', 10, 2 );
function learn_press_pmpro_custom_icon_header( $string, $level_id ) {
	$icon = get_option( 'thim_level_' . $level_id ) ? get_option( 'thim_level_' . $level_id ) : '';
	if ( $icon ) {
		return 'style="background-image: url(' . $icon . ');"';
	}
}
