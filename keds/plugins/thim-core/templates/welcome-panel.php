<?php
$links = $args['links'];
$data  = $args['data'];
list( $display_version ) = explode( '-', get_bloginfo( 'version' ) );
?>

<div class="welcome-panel-content thim-core-welcome-panel">
	<div class="welcome-panel-header">
		<h2><?php _e( 'Welcome to WordPress!' ); ?></h2>
		<p>
			<a href="<?php echo esc_url( admin_url( 'about.php' ) ); ?>">
			<?php
				/* translators: %s: Current WordPress version. */
				printf( __( 'Learn more about the %s version.' ), $display_version );
			?>
			</a>
		</p>
	</div>
    <div class="welcome-panel-column-container">
        <div class="welcome-panel-column">
            <h3><?php _e( 'Create a new', 'thim-core' ); ?></h3>
            <ul>
				<?php if ( current_user_can( 'edit_posts' ) ) : ?>
                    <li>
						<?php printf( '<a href="%s" class="welcome-icon welcome-add-post">' . __( 'Your first blog post', 'thim-core' ) . '</a>', admin_url( 'post-new.php?post_type=post' ) ); ?>

                        <div class="sub">
							<?php
							if ( isset( $data['html_below_post'] ) ) {
								echo $data['html_below_post'];
							}
							?>
                        </div>
                    </li>
				<?php endif; ?>

				<?php if ( current_user_can( 'edit_pages' ) ) : ?>
                    <li>
						<?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Page', 'thim-core' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?>

                        <div class="sub">
							<?php
							if ( isset( $data['html_below_page'] ) ) {
								echo $data['html_below_page'];
							}
							?>
                        </div>
                    </li>
				<?php endif; ?>

				<?php if ( current_user_can( 'install_plugins' ) ) : ?>
                    <li>
						<?php printf( '<a href="%s" class="welcome-icon welcome-add-plugin">' . __( 'Plugin', 'thim-core' ) . '</a>', admin_url( 'plugin-install.php' ) ); ?>

                        <div class="sub">
							<?php if ( isset( $data['html_below_plugin'] ) ) : ?>
                                <div class="recommend-plugins">
									<?php
									echo $data['html_below_plugin'];
									?>
                                </div>
							<?php endif; ?>
                        </div>
                    </li>
				<?php endif; ?>
            </ul>
        </div>

        <div class="welcome-panel-column">
            <h3><?php _e( 'Quick links', 'thim-core' ); ?></h3>

            <ul>
				<?php if ( current_theme_supports( 'widgets' ) || current_theme_supports( 'menus' ) ) : ?>
                    <li>
                        <div class="welcome-icon welcome-widgets-menus">
							<?php
							if ( current_theme_supports( 'widgets' ) && current_theme_supports( 'menus' ) ) {
								printf( __( 'Manage <a href="%1$s">widgets</a> or <a href="%2$s">menus</a>', 'thim-core' ),
									admin_url( 'widgets.php' ),
									admin_url( 'nav-menus.php' )
								);
							} elseif ( current_theme_supports( 'widgets' ) ) {
								echo '<a href="' . admin_url( 'widgets.php' ) . '">' . __( 'Manage widgets' ) . '</a>';
							} else {
								echo '<a href="' . admin_url( 'nav-menus.php' ) . '">' . __( 'Manage menus' ) . '</a>';
							}
							?>
                        </div>
                    </li>
				<?php endif; ?>

				<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                    <li>
                        <a class="welcome-icon welcome-tc-documentation" href="<?php echo esc_url( $links['docs'] ); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'thim-core' ); ?></a>
                    </li>

                    <li>
                        <a class="welcome-icon welcome-tc-support" href="<?php echo esc_url( $links['support'] ); ?>" target="_blank"><?php esc_html_e( 'Support', 'thim-core' ); ?></a>

                        <div class="sub">
							<?php esc_html_e( 'Typical replies in 24 hours - Business day - GMT+7', 'thim-core' ); ?>
                        </div>
                    </li>
				<?php endif; ?>
            </ul>

			<?php if ( current_user_can( 'customize' ) ) : ?>
                <a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?php echo wp_customize_url(); ?>"><?php _e( 'Customize Your Site', 'thim-core' ); ?></a>
			<?php endif; ?>

            <a class="button button-primary button-hero hide-if-customize" href="<?php echo admin_url( 'themes.php' ); ?>"><?php _e( 'Customize Your Site', 'thim-core' ); ?></a>

			<?php
			$args_themes = array(
				'allowed' => true,
			);
			if ( current_user_can( 'install_themes' ) || ( current_user_can( 'switch_themes' ) && count( wp_get_themes( $args_themes ) ) > 1 ) ) :
				?>
                <p class="hide-if-no-customize"><?php printf( __( 'or, <a href="%s">change your theme completely</a>', 'thim-core' ), admin_url( 'themes.php' ) ); ?></p>
			<?php endif; ?>
        </div>

		<?php if ( ! empty( $data['posts'] ) && is_array( $data['posts'] ) ) : ?>
            <div class="welcome-panel-column welcome-panel-last">
                <h3><?php _e( 'Best WordPress, Marketing Tips', 'thim-core' ); ?></h3>
                <div class="sub-description"><?php printf( __( 'Check all of it from <a href="%1$s" target="_blank">%2$s</a>', 'thim-core' ), 'https://thimpress.com/', 'Thimpress' ); ?></div>

                <div class="posts">
					<?php foreach ( $data['posts'] as $index => $post ) : ?>
						
                        <div class="tc-post tc-column-<?php echo esc_attr( $index ); ?>">
							<?php if ( ! empty( $post->thumbnail ) && $index === 0 ) : ?>
                                <div class="thumbnail">
									<?php echo '<a href="'. esc_url( $post->link ) .'" target="_blank">'. $post->thumbnail . '</a>'; ?>
                                </div>
							<?php endif; ?>
                            <h4 class="title"><?php echo '<a href="'. esc_url( $post->link ) .'" target="_blank">'. $post->title. '</a>'; ?></h4>
                            <div class="excerpt"><?php echo esc_html( $post->excerpt ); ?></div>
						</div>
					<?php endforeach; ?>
                </div>
            </div>
		<?php endif; ?>
    </div>
</div>
