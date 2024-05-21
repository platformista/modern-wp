<?php

$colors = $args['colors'];
if ( count( $colors ) < 4 ) {
	return;
}
$background_color = $colors[0];
$base_color       = $colors[2];
?>

<style id="thim-core-admin-styles">
    .tc-base-color {
        color: <?php echo esc_attr( $base_color ); ?>
    }

    .tc-base-color:hover {
        background-color: <?php echo esc_attr( $base_color ); ?>;
        color: #fff;
    }

    .tc-background-color {
        background-color: <?php echo esc_attr( $base_color ); ?> !important;
    }

    /* Getting started */
    .tc-controls .step.active:before {
        border-color: <?php echo esc_attr( $base_color ); ?> !important;
        background-color: <?php echo esc_attr( $base_color ); ?> !important;
    }

    .tc-controls li .active ~ .label {
        color: <?php echo esc_attr( $base_color ); ?> !important;
    }

    .tc-controls .step.active {
        background-color: <?php echo esc_attr( $base_color ); ?> !important;;
    }

    /* Import demo */
    .tc-importer-wrapper .thim-demo .status {
        background-color: <?php echo esc_attr( $base_color ); ?> !important;
    }

    .tc-importer-wrapper .thim-demo .status:hover {
        background-color: <?php echo esc_attr( $background_color ); ?> !important;
    }

    /* Mega menu */
    .thim-wrapper-mega-menu .field-thim-sub-align input:checked {
        color: <?php echo esc_attr( $base_color ); ?> !important;
    }

    #tc-megamenu-choose-icons .tc-icon:hover, #tc-megamenu-choose-icons .tc-icon.active {
        border-color: <?php echo esc_attr( $base_color ); ?> !important;
        color: <?php echo esc_attr( $base_color ); ?> !important;
    }

    .tc-modal-importer .main .options .package .package-progress-bar {
        background-color: <?php echo esc_attr( $base_color ); ?> !important;
    }
</style>
