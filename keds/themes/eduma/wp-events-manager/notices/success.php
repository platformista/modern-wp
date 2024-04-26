<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

foreach ( $messages as $message ) : ?>

    <div class="tp-event-notice message message-success"><?php echo sprintf( '%s', $message ); ?></div>

<?php
endforeach;
