<?php
wp_enqueue_script( 'search-course-widget' );
$title = $description = $placeholder = '';
if ( $instance['title'] && $instance['title'] <> '' ) {
	$title = $instance['title'];
}
if ( $instance['description'] && $instance['description'] <> '' ) {
	$description = $instance['description'];
}
if ( $instance['placeholder'] && $instance['placeholder'] <> '' ) {
	$placeholder = $instance['placeholder'];
}

if ( '' != $title ) {
	echo '<h3 class="search-course-title">' . esc_attr( $title ) . '</h3>';
}
if ( '' != $description ) {
	echo '<div class="search-course-description">' . esc_attr( $description ) . '</div>';
}
?>
<div class="courses-searching">
	<form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'lp_course' ) ); ?>">
		<input type="text" value="" name="c_search" placeholder="<?php echo esc_attr( $placeholder ); ?>"
			   class="thim-s form-control courses-search-input" autocomplete="off"/>
		<input type="hidden" value="course" name="ref"/>
		<button type="submit" aria-label="search"><i class="fa fa-search"></i></button>
		<span class="widget-search-close"></span>
	</form>
	<ul class="courses-list-search list-unstyled"></ul>
</div>
