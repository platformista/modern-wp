<?php
wp_enqueue_script( 'search-course-widget' );
$placeholder = $extral_class = '';
if ( $instance['placeholder'] && $instance['placeholder'] <> '' ) {
	$placeholder = $instance['placeholder'];
}

if ( isset( $instance['icon_style_overlay'] ) && $instance['icon_style_overlay'] <> '' ) {
	$extral_class = ' ' . $instance['icon_style_overlay'];
}

?>
<div class="thim-course-search-overlay<?php echo $extral_class ?>">
	<div class="search-toggle"><i class="fab fa-sistrix"></i></div>
	<div class="courses-searching layout-overlay">
		<div class="search-popup-bg"></div>
		<form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'lp_course' ) ); ?>">
			<input type="text" value="" name="c_search" placeholder="<?php echo esc_attr( $placeholder ); ?>"
				   class="thim-s form-control courses-search-input" autocomplete="off"/>
			<input type="hidden" value="course" name="ref"/>
			<button type="submit" aria-label="search"><i class="fa fa-search"></i></button>
			<span class="widget-search-close"></span>
		</form>
		<ul class="courses-list-search list-unstyled"></ul>
	</div>
</div>
