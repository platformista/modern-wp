<div class="tc-child-themes-wrapper" data-template="thim-child-themes"></div>

<script type="text/html" id="tmpl-thim-child-themes">
    <div class="tc-loader-wrapper">
        <div class="tc-loader tc-base-color"></div>
    </div>

    <div class="theme-browser rendered">
        <div class="themes wp-clearfix">
            <# if ( _.size(data.themes) > 0 ) { #>
                <# _.each(data.themes, function(theme) { #>
                    <div class="theme child-theme {{theme.status}}" data-slug="{{theme.slug}}">
                        <div class="theme-screenshot thim-screenshot">
                            <img src="{{theme.screenshot}}" alt="{{theme.name}}">
                        </div>

                        <div class="theme-id-container">
                            <h2 class="theme-name">{{theme.name}}</h2>

                            <div class="theme-actions">
                                <# if (theme.status == 'active') { #>
                                    <a class="button button-primary btn-status-{{theme.status}}" href="<?php echo wp_customize_url(); ?>"><?php esc_html_e( 'Customize', 'thim-core' ); ?></a>
                                    <# } else if (theme.status == 'not_installed') { #>
                                        <button class="button button-primary tc-btn-install"><?php esc_html_e( 'Install', 'thim-core' ); ?></button>
                                        <# } else { #>
                                            <button class="button button-secondary tc-btn-activate"><?php esc_html_e( 'Activate', 'thim-core' ); ?></button>
                                            <# } #>
                            </div>
                        </div>
                    </div>
                    <# }); #>
                        <# } else { #>
                            <h3 class="text-center"><?php esc_html_e( 'No child themes.', 'thim-core' ); ?></h3>
                            <# } #>
        </div>
    </div>
</script>
