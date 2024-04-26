<?php
$title          = $link_face = $link_twitter = $link_google = $link_dribble = $link_pinterest = $link_youtube = $link_instagram = $link_linkedin = $link_snapchat = '';
$title          = $instance['title'];
$link_face      = $instance['link_face'];
$link_twitter   = $instance['link_twitter'];
$link_google    = $instance['link_google'];
$link_dribble   = $instance['link_dribble'];
$link_linkedin  = $instance['link_linkedin'];
$link_pinterest = $instance['link_pinterest'];
$link_instagram = $instance['link_instagram'];
$link_youtube   = $instance['link_youtube'];
$link_snapchat  = !empty( $instance['link_snapchat'] ) ? $instance['link_snapchat'] : '';
$style          = !empty( $instance['style'] ) ? ' ' . $instance['style'] : '';
$show_label     = !empty( $instance['show_label'] ) ? true : false;
$text_face      = $text_twitter = $text_google = $text_dribble = $text_pinterest = $text_youtube = $text_instagram = $text_linkedin = '';
if ( $show_label ) {
	$text_face      = esc_html__( 'Facebook', 'eduma' );
	$text_twitter   = esc_html__( 'Twitter', 'eduma' );
	$text_google    = esc_html__( 'Google Plus', 'eduma' );
	$text_dribble   = esc_html__( 'Dribbble', 'eduma' );
	$text_pinterest = esc_html__( 'Pinterest', 'eduma' );
	$text_youtube   = esc_html__( 'Youtube', 'eduma' );
	$text_instagram = esc_html__( 'Instagram', 'eduma' );
	$text_linkedin  = esc_html__( 'LinkedIn', 'eduma' );
	$text_snapchat  = esc_html__( 'Snapchat', 'eduma' );
}

?>
<div class="thim-social<?php echo esc_attr( $style ); ?>">
	<?php
	if ( $title ) {
		echo ent2ncr( $args['before_title'] . esc_attr( $title ) . $args['after_title'] );
	}
	?>
	<ul class="social_link">
		<?php
		if ( $link_face != '' ) {
			echo '<li><a class="facebook hasTooltip" href="' . $link_face . '" target="' . $instance['link_target'] . '"><i class="fa fa-facebook"></i>'.$text_face.'</a></li>';
		}
		if ( $link_twitter != '' ) {
			echo '<li><a class="twitter hasTooltip" href="' . $link_twitter . '" target="' . $instance['link_target'] . '" ><i class="fa fa-x-twitter"></i>'.$text_twitter.'</a></li>';
		}
		if ( $link_google != '' ) {
			echo '<li><a class="google-plus hasTooltip" href="' . $link_google . '" target="' . $instance['link_target'] . '" ><i class="fa fa-google-plus"></i>'.$text_google.'</a></li>';
		}
		if ( $link_dribble != '' ) {
			echo '<li><a class="dribbble hasTooltip" href="' . $link_dribble . '" target="' . $instance['link_target'] . '" ><i class="fa fa-dribbble"></i>'.$text_dribble.'</a></li>';
		}
		if ( $link_linkedin != '' ) {
			echo '<li><a class="linkedin hasTooltip" href="' . $link_linkedin . '" target="' . $instance['link_target'] . '" ><i class="fa fa-linkedin"></i>'.$text_linkedin.'</a></li>';
		}

		if ( $link_pinterest != '' ) {
			echo '<li><a class="pinterest hasTooltip" href="' . $link_pinterest . '" target="' . $instance['link_target'] . '" ><i class="fa fa-pinterest"></i>'.$text_pinterest.'</a></li>';
		}
		if ( $link_instagram != '' ) {
			echo '<li><a class="instagram hasTooltip" href="' . $link_instagram . '" target="' . $instance['link_target'] . '" ><i class="fa fa-instagram"></i>'.$text_instagram.'</a></li>';
		}
		if ( $link_youtube != '' ) {
			echo '<li><a class="youtube hasTooltip" href="' . $link_youtube . '" target="' . $instance['link_target'] . '" ><i class="fa fa-youtube"></i>'.$text_youtube.'</a></li>';
		}
		if ( $link_snapchat != '' ) {
			echo '<li><a class="snapchat hasTooltip" href="' . $link_snapchat . '" target="' . $instance['link_target'] . '" ><i class="fa fa-snapchat"></i>'.$text_snapchat.'</a></li>';
		}
		?>
	</ul>
</div>