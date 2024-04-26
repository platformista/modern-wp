<?php
$limit        = (int) $instance['list-categories']['limit'];
$sub_categories = $instance['sub_categories'] ? '' : 0;
$taxonomy     = 'course_category';

$args_cat = array(
	'taxonomy' => $taxonomy,
	'parent'   => $sub_categories
);

$cat_course = get_categories( $args_cat );

$html = '';
if ( $cat_course ) {
	$index = 1;
	$html  = '<div class="thim-list-course-categories">';
	foreach ( $cat_course as $key => $value ) {

		$html .= '<div class="item">';
		$html .= '<h3 class="title"><a href="' . esc_url( get_term_link( (int) $value->term_id, $taxonomy ) ) . '">' . $value->name . '</a></h3>';
		$html .= '</div>';
		if ( $index == $limit ) {
			break;
		}
		$index ++;
	}
	$html .= '</div>';
}

?>
<?php if ( $instance['title'] ) {
	echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
} ?>
<?php
echo ent2ncr( $html );
?>
