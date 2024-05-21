<?php
$token          = Thim_Product_Registration::get_data_theme_register( 'purchase_token' );
$purchase_code  = Thim_Product_Registration::get_data_theme_register( 'purchase_code' );
$personal_token = Thim_Product_Registration::get_data_theme_register( 'personal_token' );
$my_theme_id    = Thim_Free_Theme::get_theme_id();
$user           = wp_get_current_user();

$theme_data = Thim_Theme_Manager::get_metadata();
$theme      = $theme_data['text_domain'];
$version    = $theme_data['version'];
if ( $my_theme_id ) {
	$find_lince = 'https://thimpress.com/my-account/';
} else {
	$find_lince = 'https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-';
}
$html_personal_tocken = '<tr><th scope="row">' . esc_html__( 'Personal token (optional)', 'thim-core' ) . '</th>
							<td>
								<input type="text" id="personal_token" name="personal_token" value=""
									   placeholder="Enter personal token" autocomplete="off">
								<p>Only use for update theme.</p>
								<ol class="help-info-api">
									<li>' . sprintf( esc_html__( 'Generate an Envato API Personal Token by %s.', 'thim-core' ), '<a href="https://build.envato.com/create-token/?default=t&purchase:download=t&purchase:list=t" target="_blank">' . esc_html__( 'clicking this link', 'thim-core' ) . '</a>' ) . '</li>
									<li>' . esc_html__( 'Name the token eg “My WordPress site”.', 'thim-core' ) . '</li>
									<li>' . esc_html__( 'Ensure the following permissions are enabled:', 'thim-core' ) . '
										<ul>
											<li>' . esc_html__( 'View and search Envato sites', 'thim-core' ) . '</li>
											<li>' . esc_html__( 'Download your purchased items', 'thim-core' ) . '</li>
											<li>' . esc_html__( "List purchases you've made", 'thim-core' ) . '</li>
										</ul>
									</li>
								</ol>
							</td>
						</tr>';
$is_active            = Thim_Product_Registration::is_active();
$site_key             = Thim_Product_Registration::get_site_key();
?>
<div class="tc-box tc-box-theme-license">
	<div class="tc-box-header">
		<h2 class="box-title">Activate your theme license</h2>
	</div>
	<div class="tc-box-body">
		<?php
		if ( $is_active ) :
			if ( $site_key && empty( $token ) ) {
				$link_deregister = Thim_Dashboard::get_link_main_dashboard(
					array(
						'thim-core-deregister' => true,
					)
				);
				?>
				<div class="message-success message">Your theme is activated. Thank you!</div>
				<table class="form-table">
					<tbody>
					<?php if ( ! empty( $site_key ) ) : ?>
						<tr class="license-active">
							<th scope="row">
								<?php esc_html_e( 'Site Key: ', 'thim-core' ); ?>
							</th>
							<td>
								<input type="text"
									   value="<?php echo esc_html( str_repeat( '*', strlen( $site_key ) - 7 ) . substr( $site_key, - 4 ) ); ?>"
									   disabled>
								<button class="deactivate-btn button button-secondary tc-button tc-button-deregister"
										data-url-deregister="<?php echo esc_url( $link_deregister ); ?>"
										data-confirm_deregister="<?php esc_html_e( 'Are you sure to remove theme activation??', 'thim-core' ); ?>">
									<?php esc_html_e( 'Deactivate', 'thim-core' ); ?>
								</button>
							</td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
			<?php } else {
				?>
				<div class="message-success message">Your theme license is activated. Thank you!</div>
				<table class="form-table">
					<tbody>
					<?php if ( ! empty( $purchase_code ) ) : ?>
						<tr class="license-active">
							<th scope="row">
								<?php esc_html_e( 'Purchase code: ', 'thim-core' ); ?>
							</th>
							<td>
								<?php // Show purchase code with **** and last 3 characters of the purchase code with format uuid4 ?>
								<input type="text"
									   value="<?php echo esc_html( str_repeat( '*', strlen( $purchase_code ) - 7 ) . substr( $purchase_code, - 4 ) ); ?>"
									   disabled>
								<button
									class="thim-deactive button button-secondary tc-button deactivate-btn tc-run-step">
									<?php esc_html_e( 'Deactivate', 'thim-core' ); ?>
								</button>
							</td>
						</tr>
					<?php endif; ?>
					<?php if ( ! empty( $personal_token ) && empty( $my_theme_id ) ) : ?>
						<tr>
							<th scope="row">
								<?php esc_html_e( 'Personal token: ', 'thim-core' ); ?>
							</th>
							<td>
								<?php // Show personal token with **** and show last 3 characters of the personal token ?>
								<input type="text"
									   value="<?php echo esc_html( str_repeat( '*', strlen( $personal_token ) - 7 ) . substr( $personal_token, - 4 ) ); ?>"
									   disabled>
							</td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				<?php if ( empty( $personal_token ) && empty( $my_theme_id ) ) : ?>
					<form class="thim-form-personal" action="" method="post">
						<table class="form-table">
							<tbody>
							<?php echo $html_personal_tocken; ?>
							</tbody>
						</table>
						<button class="arrow-personal-token button button-primary tc-button" type="submit">
							<?php esc_html_e( 'Update', 'thim-core' ); ?>
						</button>
					</form>
				<?php endif; ?>
			<?php } ?>
		<?php else: ?>
			<div class="message-notice message">Activate your purchase code for this domain to turn on install plugin
				required and import data demo
			</div>

			<form class="thim-form-license" action="" method="post">
				<table class="form-table">
					<tbody>
					<tr>
						<th scope="row">Purchase code <span class="required">*</span></th>
						<td>
							<input type="text" id="purchase_code" name="purchase_code" value=""
								   placeholder="Enter purchase code" autocomplete="off" required>
							<p class="find-license"><small>
									<a href="<?php echo esc_url( $find_lince ); ?>"
									   target="_blank" rel="noopener">Where can I get my purchase code?</a></small></p>
						</td>
					</tr>

					<?php if ( empty( $personal_token ) && empty( $my_theme_id ) ) : ?>
						<?php echo $html_personal_tocken; ?>
					<?php endif; ?>
					</tbody>
				</table>
				<p>
					<label for="agree_stored" class="agree-label">
						<input type="checkbox" name="agree_stored" id="agree_stored" required>
						I agree that my purchase code and user data will be stored by thimpress.com
					</label>
				</p>

				<input type="hidden" name="domain" value="<?php echo esc_url( site_url() ); ?>">
				<input type="hidden" name="theme" value="<?php echo esc_attr( $theme ); ?>">
				<input type="hidden" name="theme_version" value="<?php echo esc_attr( $version ); ?>">
				<input type="hidden" name="user_email"
					   value="<?php echo esc_attr( $user ? $user->user_email : '' ); ?>">

				<button class="button button-primary tc-button activate-btn tc-run-step" type="submit">
					<?php esc_html_e( 'Submit', 'thim-core' ); ?>
				</button>
			</form>
		<?php endif; ?>

	</div>
	<div class="tc-box-footer">
		<p>Note: 1 Regular theme license can only be activated on 1 Domain Name. If <?php echo $theme_data['name']; ?>
			is the selection for your multiple sites, you can purchase the Extended theme license.</p>
	</div>
</div>
