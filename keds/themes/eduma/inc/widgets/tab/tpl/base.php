<?php

$rand = time() . '-1-' . rand( 0, 100 );
echo '<ul class="nav nav-tabs" role="tablist">';
//$active = $content_active ='';

$j = $k = 1;
if ( $instance['tab'] ) {
	switch ( count( $instance['tab'] ) ) {
		case 1:
			$class = 'tab-col-1';
			break;
		case 2:
			$class = 'tab-col-2';
			break;
		case 3:
			$class = 'tab-col-3';
			break;
		case 4:
			$class = 'tab-col-4';
			break;
		case 5:
			$class = 'tab-col-5';
			break;
		case 6:
			$class = 'tab-col-6';
			break;
		default:
			$class = 'tab-col-1';
	}
	foreach ( $instance['tab'] as $i => $tab ) {
		if ( $j == '1' ) {
			$active = "class='active " . $class . "'";
		} else {
			$active = "class='" . $class . "'";
		}
		echo '<li role="presentation" ' . $active . '><a href="#thim-widget-tab-' . $j . $rand . '"  role="tab" data-toggle="tab">' . $tab['title'] . '</a></li>';
		$j ++;
	}
}

echo '</ul>';

echo '<div class="tab-content">';
if ( $instance['tab'] ) {
	foreach ( $instance['tab'] as $i => $tab ) {
		if ( $k == '1' ) {
			$content_active = " active";
		} else {
			$content_active = '';
		}

		$text_button = ( isset( $tab['text_button'] ) && $tab['text_button'] ) ? $tab['text_button'] : '';
		$rel         = 'nofollow';
		$target      = '_self';

		if ( array_key_exists( "link", $tab ) ) {
			if ( is_array( $tab['link'] ) ) {
				$link   = $tab['link']['url'];
				$rel    = isset( $tab['link']['rel'] ) ? 'nofollow' : 'dofollow';
				$target = isset( $tab['link']['target'] ) ? '_blank' : '_self';
			} else {
				$link   = $tab['link'];
				$rel    = isset( $tab['nofollow'] ) ? 'nofollow' : 'dofollow';
				$target = isset( $tab['is_external'] ) ? '_blank' : '_self';
			}
		}

		echo ' <div role="tabpanel" class="tab-pane' . $content_active . '" id="thim-widget-tab-' . $k . $rand . '">' . $tab['content'];
		if ( array_key_exists( "link", $tab ) && $text_button ) {
			echo '<p><a href="' . $link . '" class="readmore" target="' . $rel . '" rel="' . $target . '">' . $text_button . ' <i class="lnr icon-arrow-right"></i></a></p>';
		}
		echo '</div>';
		$k ++;
	}
}
echo '</div>';
