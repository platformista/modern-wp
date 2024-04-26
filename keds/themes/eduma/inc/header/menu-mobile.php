<ul class="nav navbar-nav">
	<?php
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'items_wrap'     => '%3$s'
		) );
	} else {
		wp_nav_menu( array(
			'theme_location' => '',
			'container'      => false,
			'items_wrap'     => '%3$s'
		) );
	}
	//sidebar menu_right

	if ( is_active_sidebar( 'menu_right' ) && get_theme_mod( 'thim_header_style', 'header_v1' ) == 'header_v4'  ) {
		echo '<li class="menu-right ' . get_theme_mod( 'thim_header_style', 'header_v4' ) . '"><ul>';
		dynamic_sidebar( 'menu_right' );
		echo '</ul></li>';
	}

	?>
</ul>