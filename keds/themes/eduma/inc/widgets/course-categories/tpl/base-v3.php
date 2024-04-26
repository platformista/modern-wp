<?php
$limit               = isset( $instance['limit'] ) ? $instance['limit'] : 'all';
$show_count          = isset( $instance['list-options']['show_counts'] ) ? $instance['list-options']['show_counts'] : 0;
$hierarchical        = isset( $instance['list-options']['hierarchical'] ) ? $instance['list-options']['hierarchical'] : true;
$sub_categories      = $instance['sub_categories'] ? '' : 0;
$taxonomy            = 'course_category';

if(isset( $instance['click_show_sub'] ) && $instance['click_show_sub'] == 'yes') {
	$sub_categories  = 0;
}
$args_cat            = array(
	'show_count'   => $show_count,
	'hierarchical' => $hierarchical,
	'taxonomy'     => $taxonomy,
	'parent'       => 0 ,
	'title_li'     => '',
);
$format_course_count = isset( $instance['format_count'] ) && $instance['format_count'] ? $instance['format_count'] : '(%s)';

if ( isset( $instance['image_size'] ) && strpos( $instance['image_size'], 'x' ) ) {
	$size       = explode( 'x', $instance['image_size'] );
	$img_with   = $size[0];
	$img_height = $size[1];
}

$use_img_icon = $class_extra = '';
$class_active = 'active';
if ( isset( $instance['use_img_icon'] ) && $instance['use_img_icon'] == 'img' ) {
	$use_img_icon = 'thim_learnpress_cate_thumnail';
	$class_extra .= 'use-img-icon';
} elseif ( isset( $instance['use_img_icon'] ) && $instance['use_img_icon'] == 'icon' ) {
	$use_img_icon = 'thim_learnpress_cate_icon';
	$class_extra .= 'use-img-icon';
}

$class_extra .= isset( $instance['click_show_sub'] ) && $instance['click_show_sub'] == 'yes' ? ' click-show-sub' : ' show-sub';

if ( isset( $instance['title'] ) ) {
	echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
}

if(isset( $instance['click_show_sub'] ) && $instance['click_show_sub'] == 'yes') {
	$show_count  = 0;
}

$cats = get_categories( $args_cat );
?>
<ul class="<?php echo esc_attr( $class_extra ) ?>">
	<?php
	$i = 1;
	foreach ( $cats as $category ) {
		$args_cat_child = array(
			'show_count'   => $show_count,
			'hierarchical' => $hierarchical,
			'taxonomy'     => $taxonomy,
			'child_of'     => $category->cat_ID,
			'title_li'     => '',
		);
		if ( get_categories( $args_cat_child ) && $instance['sub_categories'] == 'yes' ) {
			echo '<li class ="has-child '. esc_attr( $class_active ) .'">';
		} else {
			echo '<li>';
		}
		?>
		<?php if ( isset( $instance['use_img_icon'] ) && $instance['use_img_icon'] != 'none' ) : ?>
			<?php
			$icon = array();
			if ( get_term_meta( $category->term_id, $use_img_icon, true ) ) {
				$icon = get_term_meta( $category->term_id, $use_img_icon, true );
			}
			if ( ! empty( $icon ) ) {
				echo '<a href="' . esc_url( get_term_link( $category->term_id ) ) . '" class="cat-icon">';
				if ( isset( $img_with ) && isset( $img_height ) ) {
					echo thim_get_feature_image( $icon['id'], 'full', $img_with, $img_height, $category->name );
				} else {
					if ( is_array( $icon ) ) {
						echo '<img alt="' . $category->name . '" src="' . $icon['url'] . '">';
					}
				}
				echo '</a>';
			}
			?>
		<?php endif ?>
		<a href="<?php echo esc_url( get_term_link( $category->term_id ) ); ?>" class="cat-name">
			<?php echo $category->name; ?>
		</a>
		<?php
		if ( isset( $instance['list-options']['show_counts'] ) && $instance['list-options']['show_counts'] == true ) { ?>
			<span class="count-course"><?php echo str_replace( '%s', $category->count, $format_course_count ); ?></span>
		<?php } ?>
		<?php
		if( isset( $instance['click_show_sub'] ) && $instance['click_show_sub'] == 'yes' && get_categories( $args_cat_child ) ) {
			echo '<span class="drop-icon"><i aria-hidden="true" class="tk tk-angle-right"></i></span>';
		}
		if ( get_categories( $args_cat_child ) && $instance['sub_categories'] == 'yes' ) {
			echo '<ul>';
			wp_list_categories( $args_cat_child );
			echo '</ul>';
		}
		if ( $i == $limit && $limit != 'all' ) {
			break;
		}
		$i ++;
		$class_active = '';
		?>
		</li>

	<?php } ?>
</ul>
