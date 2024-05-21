<?php
$theme_data   = Thim_Theme_Manager::get_metadata();
$current_page = Thim_Dashboard::get_current_page_key();
$sub_pages    = Thim_Dashboard::get_sub_pages();
?>

<?php do_action( 'tc_before_dashboard_wrapper' ); ?>

<div class="thim-wrapper">
	<header class="tc-header">
		<div class="title">
			<h1 class="name"><?php echo esc_html( $theme_data['name'] ); ?></h1>
			<span class="version"><?php echo esc_html( $theme_data['version'] ); ?></span>
		</div>
		<input type="checkbox" id="nav_menu_mobile">
		<div class="nav_menu_mobile">
			<label for="nav_menu_mobile"></label>
		</div>

		<nav class="nav-tab-wrapper tc-nav-tab-wrapper">
			<?php
			foreach ( $sub_pages as $key => $sub_page ) :
				if ( $key == 'getting-started' ) {
					continue;
				}
				$prefix     = Thim_Dashboard::$prefix_slug;
				$link       = admin_url( 'admin.php?page=' . $prefix . $key );
				$menu_title = apply_filters( 'thim_core_tab_' . $key . '_menu_title', $sub_page['title'] );
				?>
				<a id="tc-nav-tag-<?php echo esc_attr( $key ); ?>" href="<?php echo esc_url( $link ); ?>"
				   class="nav-tab<?php echo ( $key === $current_page ) ? ' nav-tab-active' : ''; ?>"
				   title="<?php echo esc_attr( $sub_page['title'] ); ?>">
					<?php echo isset( $sub_page['icon'] ) ? $sub_page['icon'] : ''; ?>
					<?php echo( $menu_title ); ?>
				</a>
			<?php endforeach; ?>
		</nav>
	</header>

	<div class="notifications" id="tc-notifications">
		<?php do_action( 'thim_dashboard_notifications', $current_page ); ?>
	</div>

	<div class="tc-main">
		<?php
		do_action( "thim_dashboard_before_page_$current_page" );
		?>

		<?php
		do_action( "thim_dashboard_main_page_$current_page" );
		?>

		<?php
		do_action( "thim_dashboard_after_page_$current_page" );
		?>
	</div>
</div>

<?php do_action( 'tc_after_dashboard_wrapper' ); ?>
