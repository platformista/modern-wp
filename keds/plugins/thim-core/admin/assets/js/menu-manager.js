'use strict';

(function ($) {
    var Menu_Manager = Backbone.View.extend({
        el: '#menu-to-edit',

        removable_item: false,

        modal_choose_icon: null,

        modal_layout_builder: null,

        $item: null,

        item_id: false,

        events: {
            'click .item-controls': 'onClickControls',
            'change .tc-field-type-layout': 'onChangeType',
            'click .tc-icon-selector .tc-open-modal': 'onClickChooseIcon',
            'click .tc-remove': 'onRemoveIcon',
            'click .open-builder': 'onOpenLayoutBuilder'
        },

        tempSubs: [],

        initialize: function () {
            $(window).on('thim_mega_menu_update_icon', this.onUpdateIcon.bind(this));
            this.modal_choose_icon = new Modal_Choose_Icon();
            this.modal_layout_builder = new Modal_Layout_Builder();
        },

        onOpenLayoutBuilder: function (e) {
            this.detectItem(e);

            $(window).trigger('tc_open_layout_builder', this.item_id);
        },

        onRemoveIcon: function (e) {
            this.detectItem(e);

            this.$item.find('.input-icon').val('');
            this.$item.find('.tc-preview-icon').html('');
            this.$item.find('.tc-field-icon').addClass('tc-field-empty');
        },

        onUpdateIcon: function (e, icon) {
            if (icon) {
                this.$item.find('.tc-field-icon').removeClass('tc-field-empty');
            } else {
                this.$item.find('.tc-field-icon').addClass('tc-field-empty');
            }
            this.$item.find('.input-icon').val(icon);
            var html_icon = '<i class="' + icon + '"></i>';
            this.$item.find('.tc-preview-icon').html(html_icon);
        },

        onClickChooseIcon: function (e) {
            this.detectItem(e);
            var icon = this.$item.find('.input-icon').val();
            $(window).trigger('thim_menu_menu_choose_icon', icon);
        },

        onChangeType: function (e) {
            this.detectItem(e);

            var $current = this.$(e.currentTarget);
            var layout = $current.val();

            this.$item.find('.field-thim-mega-menu').attr('data-type', layout);

            if (layout == 'builder') {
                console.log(this.$item.find('.open-builder'));
                this.$item.find('.open-builder').click();
            }
        },

        detectItem: function (e) {
            var $current = this.$(e.currentTarget);
            this.$item = $current.closest('.menu-item');
            this.item_id = this.$item.find('.menu-item-data-db-id').val();
        },

        onClickControls: function (e) {
            if (e.offsetX >= 0) {
                return;
            }

            if (!this.removable_item) {
                var r = confirm(thim_menu_manager.confirm);
                if (!r) {
                    return;
                }
            }

            this.removable_item = true;

            var $current = this.$(e.currentTarget);
            var $menu_item = $current.closest('.menu-item');
            var menu_id = $menu_item.find('.menu-item-data-db-id').val();
            this.removeItem(menu_id);
        },

        removeItem: function (id) {
            var $menu_item = this.$('#menu-item-' + id);
            var $delete_item = $menu_item.find('.item-delete');
            if ($delete_item) {
                $delete_item.click();
            }
        },

        removeAllSubItems: function (id) {
            id = parseInt(id);
            if (id <= 0) {
                return false;
            }

            this.tempSubs = [];
            this._getAllSubItemIDs([id]);
            var self = this;

            if (!this.tempSubs.length) {
                return true;
            }

            var r = confirm('You need remove all sub menu items because content of layout builder will overwrite them?');
            if (!r) {
                return false;
            }

            this.tempSubs.forEach(function (item_id) {
                self.removeItem(item_id);
            });

            return true;
        },

        _getAllSubItemIDs: function (parents) {
            if (!parents.length) {
                return false;
            }

            var self = this;
            var parent = parents[0];

            var $inputs = this.$('.menu-item-data-parent-id[value="' + parent + '"]');
            $inputs.each(function (index) {
                var $input = $(this);
                var $menu = $input.closest('.menu-item');
                var menu_id = $menu.find('.menu-item-data-db-id').val();
                parents.push(menu_id);
                self.tempSubs.push(menu_id);
            });

            parents.shift();
            this._getAllSubItemIDs(parents);
        }
    });

    var Modal_Layout_Builder = Backbone.View.extend({
        el: '#tc-mega-menu-layout-builder',
        events: {},

        menu_id: false,

        initialize: function () {
            $(window).on('tc_open_layout_builder', this.onOpen.bind(this));
        },

        template: function (data) {
            var id = this.$el.attr('data-template');

            return wp.template(id)(data);
        },

        render: function () {
            this.$el.html(this.template({
                menu_id: this.menu_id
            }));
        },

        onOpen: function (e, menu_id) {
            this.menu_id = menu_id;
            this.render();
        }
    });


    var Modal_Choose_Icon = Backbone.View.extend({
        el: '#tc-megamenu-choose-icons',

        events: {
            'change .package-selector': 'onChangePackage',
            'click .tc-icon': 'onClickIcon',
            'input .search': 'onChangeSearch'
        },

        packages: [],

        package: false,

        currentPackage: [],

        icon: false,

        initialize: function () {
            $(window).on('thim_menu_menu_choose_icon', this.onChooseIcon.bind(this));
            this.packages = thim_menu_manager.packages;
            this.initDefaults();
        },

        initDefaults: function () {
            if (!this.packages.length) {
                return;
            }

            this.icon = '';
            this.package = this.packages[0].key;
            this.currentPackage = this.packages[0].fonts;
        },

        template: function (data) {
            var id = this.$el.attr('data-template');

            return wp.template(id)(data);
        },

        render: function () {
            this.$el.html(this.template({
                packages: this.packages,
                package: this.package,
                currentPackage: this.currentPackage,
                icon: this.icon
            }));
        },

        captureIcon: function (text) {
            if (!text) {

                return;
            }

            var self = this;

            text = text.trim();
            var arr = text.split(' ');
            if (arr.length != 2) {
                return;
            }

            this.package = arr[0];
            this.icon = arr[1];
            this.packages.forEach(function (p) {
                if (p.key == self.package) {
                    self.currentPackage = p.fonts;
                }
            });
        },

        onChangePackage: function (e) {
            var self = this;
            this.package = this.$('.package-selector').val();
            this.packages.forEach(function (p) {
                if (p.key == self.package) {
                    self.currentPackage = p.fonts;
                }
            });

            this.render();
        },

        onChangeSearch: function (e) {
            var search = this.$('.search').val();
            search = search.trim().toLowerCase();

            this.$('.search').val(search);

            if (!search) {
                this.$('.tc-icon').addClass('show');
                return;
            }

            this.$('.tc-icon').removeClass('show');
            this.$('.tc-icon[data-icon*="' + search + '"]').addClass('show');
        },

        onClickIcon: function (e) {
            var $current = this.$(e.currentTarget);

            this.$('.tc-icon').removeClass('active');
            $current.addClass('active');
            var icon = $current.attr('data-icon');
            this.captureIcon(icon);
            $(window).trigger('thim_mega_menu_update_icon', icon);
            this.close();
        },

        onChooseIcon: function (e, icon) {
            this.captureIcon(icon);
            this.render();
            this.$('.search').focus();
        },

        close: function () {
            $(window).trigger('tc_modal_close', this.el);
        }
    });

    $(document).ready(function () {
        new Menu_Manager();
    });
})(jQuery);