<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

foreach ( $messages as $message ) : ?>

    <div class="message message-error"><?php echo sprintf( '%s', $message ); ?></div>

<?php
endforeach;
