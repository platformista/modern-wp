<?php
$steps       = Thim_Getting_Started::get_steps();
$count_steps = count( $steps );

if ( ! $count_steps ) {
	return;
}
?>

<div class="thim-getting-started">
    <header>
        <ul class="tc-controls" data-max="<?php echo esc_attr( count( $steps ) ); ?>">
			<?php
            foreach ( $steps as $index => $step ) :
				$position = $index + 1;
				?>
                <li>
                    <a class="step" data-position="<?php echo esc_attr( $index ); ?>" data-step="<?php echo esc_attr( $step['key'] ); ?>"
                       title="<?php echo esc_attr( $step['title'] ); ?> <?php printf( __( '(%1$s of %2$s)', 'thim-core' ), $position, $count_steps ); ?>"></a>
                    <span class="label"><?php echo esc_html( $step['title'] ); ?></span>
                </li>
			<?php endforeach; ?>
        </ul>

        <div class="tc-number-step">
            Step <span class="current">1</span> of <span><?php echo esc_attr( $count_steps ); ?></span>
        </div>
    </header>

    <main>
		<?php
		do_action( 'thim_getting_started_main_content' );
		?>
    </main>
</div>
