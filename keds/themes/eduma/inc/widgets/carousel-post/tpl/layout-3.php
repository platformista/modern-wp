<?php
global $post;

//return;
$navigation = ( $instance['show_nav'] == 'yes' ) ? 1 : 0;
$pagination = ( $instance['show_pagination'] == 'yes' ) ? 1 : 0;
$autoplay   = isset( $instance['auto_play'] ) ? $instance['auto_play'] : 0;
$layout     = ! empty( $instance['layout'] ) ? $instance['layout'] : '';

$number_posts = ! empty( $instance['number_posts'] ) ? $instance['number_posts'] : 8;
$visible_post = ! empty( $instance['visible_post'] ) ? $instance['visible_post'] : 2;

$query_args = array(
	'posts_per_page'      => $number_posts,
	'post_type'           => 'post',
	'order'               => $instance['order'] == 'asc' ? 'asc' : 'desc',
	'ignore_sticky_posts' => true
);

if ( $instance['cat_id'] && $instance['cat_id'] != 'all' ) {
	if ( get_term( $instance['cat_id'], 'category' ) ) {
		$query_args['cat'] = $instance['cat_id'];
	}
}
switch ( $instance['orderby'] ) {
	case 'recent' :
		$query_args['orderby'] = 'post_date';
		break;
	case 'title' :
		$query_args['orderby'] = 'post_title';
		break;
	case 'popular' :
		$query_args['orderby'] = 'comment_count';
		break;
	default : //random
		$query_args['orderby'] = 'rand';
}

$posts_display = new WP_Query( $query_args );
$number        = count( $posts_display->posts );

wp_enqueue_script( 'magnific-popup' );

if ( $posts_display->have_posts() ) {
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	?>
	<div class="thim-owl-carousel-post thim-carousel-wrapper <?php echo esc_attr( $layout ); ?>"
		 data-visible="<?php echo esc_attr( $visible_post ); ?>"
		 data-pagination="<?php echo esc_attr( $pagination ); ?>"
		 data-navigation="<?php echo esc_attr( $navigation ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
		 data-navigation-text="2">
		<?php
		$index = 1;
		while ( $posts_display->have_posts() ) :
			$posts_display->the_post();
			if ( $index == 1 || $index > 5 ) {
				echo '<div class="item">';
			} else if ( $index == 2 ) {
				echo '<div class="item item-contain">';
			}
			$format = get_post_format();
			if ( $format == 'video' ) {
				$icon = '<span class="fa fa-play"></span>';
			} elseif ( $format == 'gallery' ) {
				$icon = '<span class="fa fa-photo"></span>';
			} else {
				$icon = '<span class="fa fa-edit"></span>';
			}
			?>
			<div class="post-inner">
				<?php
				$img = thim_get_feature_image( get_post_thumbnail_id( $post->ID ), 'full', 420, 420, get_the_title() );
				echo ent2ncr( $icon );
				?>
				<div class="image">
					<a href="<?php echo esc_url( get_permalink() ) ?>" class="thim-gallery-popup"
					   data-id="<?php echo get_the_ID(); ?>">
						<?php echo ent2ncr( $img ); ?>
					</a>
				</div>
				<div class="content">
					<p class="date"><?php echo get_the_date( 'Y' ); ?></p>
					<p class="title"><?php echo get_the_title(); ?></p>
				</div>
			</div>
			<?php
			if ( $index == 1 || $index >= 5 || $index == $number ) {
				echo '</div>';
			}
			$index ++;
		endwhile;
		?>
	</div>
	<div class="thim-gallery-show"></div>

	<?php
}
wp_reset_postdata();