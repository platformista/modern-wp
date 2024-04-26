<?php

$height = '10';
if ( $instance['height'] <> '' ) {
	$height = $instance['height'];
}
echo '<div class="empty_space" style="height:' . $height . 'px"></div>';
