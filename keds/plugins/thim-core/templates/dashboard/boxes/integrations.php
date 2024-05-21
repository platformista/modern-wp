<?php
$theme_data     = Thim_Theme_Manager::get_metadata();
$integrations_file = $theme_data['integrations_file'];
?>

<?php if ( $integrations_file ) : ?>
    <div class="tc-box-body">
        <div class="tc-integrations-wrapper">
 			<?php include $integrations_file; ?>
         </div>
    </div>
<?php endif; ?>
