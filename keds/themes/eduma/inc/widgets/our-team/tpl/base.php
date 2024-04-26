<?php
$number_post = isset( $instance['number_post'] ) ? $instance['number_post'] : 4;
$columns     = isset( $instance['columns'] ) ? 12 / $instance['columns'] : 4;
$class_demo  = isset( $instance['layout_demo_elegant'] ) && ( ! empty( $instance['layout_demo_elegant'] ) && $instance['layout_demo_elegant'] == 'yes' ) ? ' icon-image-hover' : '';

$our_team_args = array(
	'posts_per_page'      => $number_post,
	'post_type'           => 'our_team',
	'ignore_sticky_posts' => true
);

if ( $instance['cat_id'] && $instance['cat_id'] != 'all' ) {
	if ( get_term( $instance['cat_id'], 'our_team_category' ) ) {
		$our_team_args['tax_query'] = array(
			array(
				'taxonomy' => 'our_team_category',
				'field'    => 'term_id',
				'terms'    => $instance['cat_id']
			),
		);
	}
}
 
$our_team = new WP_Query( $our_team_args );
$html     = $extral_url = '';
if ( $our_team->have_posts() ) {
	$html .= '<div class="wrapper-lists-our-team' . $class_demo . '">';

	if ( is_array( $instance['link'] ) ) {
		$link       = $instance['link']['url'];
		$extral_url = isset( $instance['link']['rel'] ) ? ' rel="nofollow"' : '';
		$extral_url .= isset( $instance['link']['target'] ) ? ' target="_blank"' : '';
	} else {
		$link       = $instance['link'];
		$extral_url = isset( $instance['nofollow'] ) ? ' rel="nofollow"' : '';
		$extral_url .= isset( $instance['is_external'] ) ? ' target="_blank"' : '';
	}
	if ( empty( $link ) ) {
		$link       = "#";
		$extral_url = '';
	}
	if ( $instance['text_link'] && $instance['text_link'] != '' ) {
		$html .= '<a class="join-our-team" href="' . $link . '" title="' . $instance['text_link'] . '"' . $extral_url . '>' . $instance['text_link'] . '</a>';
	}
	$html .= '<div class="row">';
	while ( $our_team->have_posts() ): $our_team->the_post();
		$team_id      = get_the_ID();
		$regency      = get_post_meta( $team_id, 'regency', true );
		$link_face    = get_post_meta( $team_id, 'face_url', true );
		$link_twitter = get_post_meta( $team_id, 'twitter_url', true );
		$skype_url    = get_post_meta( $team_id, 'skype_url', true );
		$dribbble_url = get_post_meta( $team_id, 'dribbble_url', true );
		$linkedin_url = get_post_meta( $team_id, 'linkedin_url', true );

		$html .= '<div class="our-team-item col-sm-' . $columns . '">';
		$html .= '<div class="our-team-image"> <a class="link-img" href="' . esc_url( get_permalink() ) . '"></a>' . thim_get_feature_image( get_post_thumbnail_id(), 'full', apply_filters( 'thim_member_thumbnail_width', 200 ), apply_filters( 'thim_member_thumbnail_height', 200 ) );
		$html .= '<div class="social-team">';
		if ( $link_face <> '' ) {
			$html .= '<a target="_blank" href="' . $link_face . '"><i class="fa fa-facebook"></i></a>';
		}
		if ( $link_twitter <> '' ) {
			$html .= '<a target="_blank" href="' . $link_twitter . '"><i class="fa fa-x-twitter"></i></a>';
		}
		if ( $dribbble_url <> '' ) {
			$html .= '<a target="_blank" href="' . $dribbble_url . '"><i class="fa fa-dribbble"></i></a>';
		}
		if ( $skype_url <> '' ) {
			$html .= '<a target="_blank" href="' . $skype_url . '"><i class="fa fa-skype"></i></a>';
		}
		if ( $linkedin_url <> '' ) {
			$html .= '<a target="_blank" href="' . $linkedin_url . '"><i class="fa fa-linkedin"></i></a>';
		}
		$html .= '</div></div>';
		$html .= '<div class="content-team">';
		if ( ! empty( $instance['link_member'] ) ) {
			$html .= '<h4 class="title"><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h4>';
		} else {
			$html .= '<h4 class="title">' . get_the_title() . '</h4>';
		}

		if ( $regency <> '' ) {
			$html .= '<div class = "regency">' . $regency . '</div>';
		}
		$html .= '</div></div>';
	endwhile;
	$html .= '</div></div>';
}

wp_reset_postdata();

echo ent2ncr( $html );