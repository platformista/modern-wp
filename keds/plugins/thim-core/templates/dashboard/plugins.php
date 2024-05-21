<?php

do_action( 'thim_core_check_update_external_plugins' );

$plugins      = Thim_Plugins_Manager::get_plugins();
$add_ons      = Thim_Plugins_Manager::get_all_add_ons();
$writable     = Thim_Plugins_Manager::get_permission();
$default_desc = thim_core_get_content_json_url( Thim_Admin_Config::get( 'host_downloads_api' ) . 'desc-plugin.json' );
// check required version php when install plugin
$php_requied = array( 'woocommerce' => '7.3' );
?>

<div class="wrap plugin-tab">
	<?php
	do_action( 'thim_dashboard_registration_box' );
	?>

	<h2 class="screen-reader-text"><?php esc_html_e( 'Filter plugins list', 'thim-core' ); ?></h2>
	<div class="wp-filter">
		<ul class="filter-links">
			<li class="all" data-filter="*"><a href="#all" class="current"><?php esc_html_e( 'All ', 'thim-core' ); ?>
					(<span>__</span>)</a></li>
			<li class="required" data-filter=".required"><a href="#required"
															class=""><?php esc_html_e( 'Required ', 'thim-core' ); ?>
					(<span>__</span>)</a></li>
			<li class="recommended" data-filter=".recommended"><a
					href="#recommended"><?php esc_html_e( 'Recommended', 'thim-core' ); ?>(<span>__</span>)</a></li>
			<?php if ( count( $add_ons ) ) : ?>
				<li class="add-ons" data-filter=".add-on"><a
						href="#add-ons"><?php printf( __( 'Add-ons (%s)', 'thim-core' ), count( $add_ons ) ); ?></a>
				</li>
			<?php endif; ?>
			<li class="updates" data-filter=".can-update"><a
					href="#updates"><?php esc_html_e( 'Update Available ', 'thim-core' ); ?>(<span>__</span>)</a>
			</li>
		</ul>

		<div class="search-form search-plugins">
			<input type="hidden" name="tab" value="search">
			<label><span class="screen-reader-text"><?php esc_html_e( 'Search plugins', 'thim-core' ); ?></span>
				<input type="search" name="s" value="" class="wp-filter-search"
					   placeholder="<?php esc_attr_e( 'Search plugins', 'thim-core' ); ?>"
					   aria-describedby="live-search-desc">
			</label>
			<input type="submit" id="search-submit" class="button hide-if-js"
				   value="<?php esc_attr_e( 'Search Plugins', 'thim-core' ); ?>"></div>
	</div>
	<br class="clear">

	<div id="plugin-filter">
		<div class="list-plugins">
			<?php
			foreach ( $plugins as $index => $plugin ) :
				$slug = $plugin->get_slug();
				$status = $plugin->get_status();
				$is_wporg = $plugin->is_wporg();
				$plugin_info = $plugin->get_info();
				$can_update = $plugin->can_update();
				$premium = '1';
				$plugins_info = '';
				$compatible_php = true;
				$plugin_short_desc = $plugin->get_description();
				if ( ! $plugin_short_desc ) {
					$plugin_short_desc = isset( $default_desc[$plugin->get_slug()] ) ? $default_desc[$plugin->get_slug()] : '';
				}
				$plugin_icon = THIM_CORE_ADMIN_URI . '/assets/images/logo.svg';
				if ( $plugin->get_icon() ) {
					$plugin_icon = $plugin->get_icon();
				} elseif ( $is_wporg ) {
					$plugin_icon = 'https://ps.w.org/' . $plugin->get_slug() . '/assets/icon-128x128.png';
					$premium     = '0';
					if ( $status == 'not_installed' && isset( $php_requied[$slug] ) ) {
						$compatible_php = is_php_version_compatible( $php_requied[$slug] );
					}
				}

				$plugin_icon = apply_filters( 'thim_core_plugin_icon_install', $plugin_icon, $plugin );

				$plugin_classes = $plugin->is_required() ? 'required' : 'recommended';
				if ( $plugin->is_add_on() ) {
					$plugin_classes = 'add-on';
				}
				$plugin_classes .= " plugin-card-$slug";

				$current_version = $plugin->get_current_version();
				$version         = $current_version ? $current_version : $plugin->get_require_version();

				$plugin_classes     .= $can_update ? ' can-update' : '';
				$disable_deactivate = $plugin->disable_deactivate();
				// Status
				if ( ! $compatible_php ) {
					$status = 'can_installed';
				}
				// fix update for 2 add-on announcements and asssigments in eduma with old custommer
				if ( $status == 'not_installed' && ( $slug == 'learnpress-announcements' || $slug == 'learnpress-assignments' ) ) {
					continue;
				}
				?>
				<div class="plugin-card <?php echo esc_attr( $plugin_classes ); ?>"
					 data-status="<?php echo esc_attr( $status ); ?>"
					 id="plugin-<?php echo esc_attr( $slug ); ?>">
					<div class="plugin-card-top">
						<div class="name column-name">
							<div class="plugin-icon">
								<img src="<?php echo esc_url( $plugin_icon ); ?>"
									 alt="<?php echo esc_attr( $plugin->get_name() ); ?>">
							</div>

							<h3>
								<span class="data_Name"><?php echo esc_html( $plugin->get_name() ); ?></span>

							</h3>
						</div>
						<div class="action-links">
							<ul class="plugin-action-buttons"
								data-slug="<?php echo esc_attr( $plugin->get_slug() ); ?>">
								<li>
									<?php if ( $can_update ) : ?>
										<button type="button" class="button" data-premium="<?php echo $premium; ?>"
												data-action="update" <?php disabled( $writable, false ); ?> ><?php esc_html_e( 'Update', 'thim-core' ); ?></button>
									<?php elseif ( $status == 'not_installed' ) : ?>
										<button type="button" class="button" data-premium="<?php echo $premium; ?>"
												data-action="install" <?php disabled( $writable, false ); ?> ><?php esc_html_e( 'Install Now', 'thim-core' ); ?></button>
									<?php elseif ( $status == 'inactive' ) : ?>
										<button type="button" class="button"
												data-action="activate"><?php esc_html_e( 'Activate', 'thim-core' ); ?></button>
									<?php elseif ( $status == 'can_installed' ) : ?>
										<button type="button" class="button button-disabled"
												disabled><?php esc_html_e( 'Cannot Install', 'thim-core' ); ?></button>
									<?php else : ?>
										<button type="button" class="button"
											<?php disabled( true, $disable_deactivate, true ); ?>
												data-action="deactivate"><?php esc_html_e( 'Deactivate', 'thim-core' ); ?></button>
									<?php endif; ?>
								</li>
							</ul>
						</div>
						<div class="desc column-description">
							<p class="data_Description"><?php echo $plugin_short_desc; ?></p>
							<?php

							if ( ! $compatible_php ) {
								echo '<p style="background-color: #fcf0f1; border-left: 3px solid red; padding: 5px 5px 5px 10px">';
								_e( 'This plugin does not work with your version of PHP.' );
								if ( current_user_can( 'update_php' ) ) {
									printf(
									/* translators: %s: URL to Update PHP page. */
										' ' . __( '<a href="%s">Learn more about updating PHP</a>.' ),
										esc_url( wp_get_update_php_url() )
									);
								}
								echo '</p>';
							}
							?>
						</div>
					</div>
					<?php if ( $version || $plugin->is_required() ) : ?>
						<div class="plugin-card-bottom">
							<?php if ( $version ): ?>
								<div class="column-downloaded"><?php echo __( 'Version: ', 'thim-core' ); ?><span
										class="data_Version"><?php echo esc_html( $version ); ?></span></div>
							<?php endif; ?>
							<?php if ( $plugin->is_required() ) : ?>
								<div class="column-updated"><span
										class="plugin-required"><?php esc_html_e( 'Required', 'thim-core' ); ?></span>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<span class="spinner"></span>
</div>
