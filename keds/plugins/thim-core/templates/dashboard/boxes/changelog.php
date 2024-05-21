<?php
$theme_data     = Thim_Theme_Manager::get_metadata();
$changelog_file = $theme_data['changelog_file'];
?>

<?php if ( $changelog_file ) : ?>
    <div class="tc-box-body">
        <div class="tc-changelog-wrapper">
            <div class="versions">
				<?php include $changelog_file; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
