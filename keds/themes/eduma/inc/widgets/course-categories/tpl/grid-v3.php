<?php

$grid_limit     = (int) $instance['grid-options']['grid_limit'];
$grid_column    = (int) $instance['grid-options']['grid_column'];
$taxonomy       = 'course_category';
$sub_categories = $instance['sub_categories'] ? '' : 0;
$grid_class     = '';
if ( $grid_column ) {
	$grid_class = 'columns-' . $grid_column;
}
$args_cat = array(
	'taxonomy' => $taxonomy,
	'parent'   => $sub_categories
);
if ( isset( $instance['image_size'] ) && strpos( $instance['image_size'] , 'x' ) ) {
	$size       = explode( 'x', $instance['image_size'] );
	$img_with   = $size[0];
	$img_height = $size[1];
}
?>
<?php if ( $instance['title'] ) {
	echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
} 
$use_img_icon = $class_extra = '';
if ( isset( $instance['use_img_icon'] ) && $instance['use_img_icon'] == 'img'){
	$use_img_icon 	= 'thim_learnpress_cate_thumnail';
	$class_extra 	= 'layout-image-cats';
}else {
	$use_img_icon = 'thim_learnpress_cate_icon';
}
?>

<?php
$cats = get_categories( $args_cat );
?>
<div class="thim-widget-course-categories-grid <?php echo esc_attr( $class_extra ) ?>">
	<ul class="<?php echo esc_attr( $grid_class ) ?>">
		<?php
		$i = 1;
		foreach ( $cats as $category ) {
			?>
			<li>
				<a href="<?php echo esc_url( get_term_link( $category->term_id ) ); ?>">
					<?php
					$alt  = '';
					$icon = array();
					if ( get_term_meta( $category->term_id, $use_img_icon, true ) ) {
						$icon = get_term_meta( $category->term_id, $use_img_icon, true );
					}
 					if ( ! empty( $icon ) ) {
 						if( isset($img_with) && isset($img_height)){
							echo thim_get_feature_image( $icon['id'], 'full', $img_with, $img_height, $category->name );
						}else{
							if ( is_array( $icon ) ) {
								echo '<img alt="' . $category->name . '" src="' . $icon['url'] . '">';
							}
						}
 					}
					?>
					<?php 
						echo '<span class="category-title">';
						echo $category->name; 
						echo '</span>';
						if ( isset( $instance['count_course'] ) && $instance['count_course'] == 'yes'){
							echo '<p class="count-course"> '. $category->count .' '. esc_html__( 'Courses', 'eduma' ).'</p>';
						}
					?>
				</a>
			</li>
			<?php
			if ( $i == $grid_limit ) {
				break;
			}
			$i ++;
		}
		?>
	</ul>
</div>

