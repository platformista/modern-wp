<?php
$title_tag = 'h4';
if(isset($instance['title_tag']) && !empty($instance['title_tag'])){
	$title_tag = $instance['title_tag'];
}
if ( ! empty( $instance['text'] ) ) {
	if ( ! empty( $instance['link'] ) ) {
		echo '<'.$title_tag.' class="title"><a href="' . $instance['link'] . '">' . $instance['text'] . '</a></'.$title_tag.'>';
	} else {
		echo '<'.$title_tag.' class="title">' . $instance['text'] . '</'.$title_tag.'>';
	}
}
if ( ! empty( $instance['content'] ) ) {
	echo '<div class="desc">' . $instance['content'] . '</div>';
}
