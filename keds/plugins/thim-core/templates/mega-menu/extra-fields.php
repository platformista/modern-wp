<?php
$menu_id           = $args['$menu_id'];
$settings          = $args['$settings'];
$align             = $settings['align'];
$layout_hide_title = $settings['layout_hide_title'] ? true : false;
?>

<div class="thim-wrapper-mega-menu">
    <div class="field-thim-icons description">
        <label>Custom Icon</label>
        <div class="tc-field tc-field-icon <?php echo ( empty( $settings['icon'] ) ) ? esc_attr( 'tc-field-empty' ) : ''; ?>">
            <div class="tc-icon-selector">
                <div class="choose tc-open-modal" data-modal="#tc-megamenu-choose-icons">
					<span class="tc-preview-icon">
						<?php if ( ! empty( $settings['icon'] ) ) : ?>
                            <i class="<?php echo esc_attr( $settings['icon'] ); ?>"></i>
						<?php endif; ?>
					</span>
                    <span class="label">Choose icon</span>
                </div>
                <span class="tc-remove"></span>
                <input type="hidden" class="input-icon" value="<?php echo esc_attr( $settings['icon'] ); ?>" name="tc-mega-menu[<?php echo esc_attr( $menu_id ); ?>][icon]">
            </div>
        </div>
    </div>

    <div class="field-thim-sub-align description">
        <label>Custom Item Align</label>
        <div class="tc-field">
            <label>
                <input type="radio" name="tc-mega-menu[<?php echo esc_attr( $menu_id ); ?>][align]" value="left" <?php checked( $align, 'left' ); ?>>
                <input type="radio" name="tc-mega-menu[<?php echo esc_attr( $menu_id ); ?>][align]" value="right" <?php checked( $align, 'right' ); ?>>
            </label>
        </div>
    </div>

    <div class="wp-clearfix"></div>

    <div class="field-thim-mega-menu description" data-type="<?php echo esc_attr( $settings['layout'] ); ?>" id="thim-mega-menu-item-<?php echo esc_attr( $menu_id ); ?>">
        <div class="tc-menu-extra-field">
            <label>Custom Layout <a class="tc-open-modal help dashicons dashicons-editor-help" href="<?php echo esc_url( Thim_Menu_Manager::get_link_iframe_how_to_use() ); ?>" title="How to use Custom Layout Menu?"></a></label>
            <div class="tc-field tc-field-layout">
                <div class="tc-row">
                    <div class="tc-col-50">
                        <select title="Type layout" class="tc-field-type-layout" id="tc-mega-menu-type-<?php echo esc_attr( $menu_id ); ?>" name="tc-mega-menu[<?php echo esc_attr( $menu_id ); ?>][layout]">
                            <option value="default" <?php selected( 'default', $settings['layout'] ); ?>>Layout Default</option>
                            <option value="column" <?php selected( 'column', $settings['layout'] ); ?>>Column Layout</option>
                            <option value="builder" <?php selected( 'builder', $settings['layout'] ); ?>>Page Builder</option>
                        </select>
                    </div>
                    <div class="tc-col-50">
                        <label class="tc-layout-hide-title tc-hide">
                            <input type="checkbox" <?php checked( true, $layout_hide_title ); ?>
                                   name="tc-mega-menu[<?php echo esc_attr( $menu_id ); ?>][layout_hide_title]">
                            Hide column title?
                        </label>

                        <button type="button" class="tc-open-modal button button-primary open-builder tc-hide" data-modal="#tc-mega-menu-layout-builder">Open</button>
                    </div>
                </div>

                <div class="tc-waring-builder tc-hide"><?php esc_html_e( 'Content in layout builder will override sub-items', 'thim-core' ); ?></div>
            </div>
        </div>
    </div>
</div>
