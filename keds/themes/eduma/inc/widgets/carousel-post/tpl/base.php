<?php
global $post;
$number_posts = 5;
$visible_post = 3;

$navigation = ( $instance['show_nav'] == 'yes' ) ? 1 : 0;
$pagination = ( $instance['show_pagination'] == 'yes' ) ? 1 : 0;
$autoplay   = isset( $instance['auto_play'] ) ? $instance['auto_play'] : 0;

if ( $instance['number_posts'] != '' ) {
	$number_posts = (int) $instance['number_posts'];
}
if ( $instance['visible_post'] != '' ) {
	$visible_post = (int) $instance['visible_post'];
}
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
$id            = uniqid();

if ( $posts_display->have_posts() ) {
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	?>
	<div class="thim-owl-carousel-post thim-carousel-wrapper" data-visible="<?php echo esc_attr( $visible_post ); ?>"
		 data-pagination="<?php echo esc_attr( $pagination ); ?>"
		 data-navigation="<?php echo esc_attr( $navigation ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<?php
		//$index = 1;
		while ( $posts_display->have_posts() ) :
			$posts_display->the_post();
			?>
			<div class="item">
				<?php
				$img = thim_get_feature_image( get_post_thumbnail_id( $post->ID ), 'full', apply_filters( 'thim_carousel_post_thumbnail_width', 450 ), apply_filters( 'thim_carousel_post_thumbnail_height', 267 ), get_the_title() );
				?>
				<div class="image">
					<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ) ?>">
						<?php echo ent2ncr( $img ); ?>
					</a>
				</div>
				<div class="content">
					<div class="info">
						<div class="author">
							<?php echo '<span>' . esc_html( get_the_author() ) . '</span>'; ?>
						</div>
						<div class="date">
							<?php echo get_the_date(); ?>
						</div>
					</div>
					<h4 class="title">
						<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ) ?>"><?php echo esc_attr( get_the_title() ) ?></a>
					</h4>
				</div>
			</div>
		<?php
			//$index ++;
		endwhile;
		?>
	</div>
	<?php
}
wp_reset_postdata();

?>