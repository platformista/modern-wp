(function ($) {
    var Child_Theme_Model = Backbone.Model.extend({
        initialize: function () {

        },

        defaults: {
            themes: []
        }
    });

    var Child_Theme_View = Backbone.View.extend({
        el: '.tc-child-themes-wrapper',

        model: null,

        events: {
            'click .tc-btn-install': 'onClickInstall',
            'click .tc-btn-activate': 'onClickActivate'
        },

        _get_slug: function (e) {
            var $button = $(e.currentTarget);
            var $theme = $button.closest('.child-theme');
            return $theme.attr('data-slug');
        },

        action: function (slug, action) {
            var url = this.model.get('url_ajax');
            var ajax_action = this.model.get('ajax_action');
            var self = this;

            self.$el.addClass('tc-loading');
            window.onbeforeunload = function () {
                return true;
            };

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: {
                    action: ajax_action,
                    slug: slug,
                    thim_action: action
                },
                success: function (response) {
                    if (response.success) {
                        var themes = response.data;

                        self.model.set('themes', themes);
                    } else {
                        alert(response.data);
                    }
                },
                complete: function () {
                    self.$el.removeClass('tc-loading');
                    window.onbeforeunload = null;
                }
            });
        },

        onClickInstall: function (e) {
            var slug = this._get_slug(e);

            this.action(slug, 'install');
        },

        onClickActivate: function (e) {
            var slug = this._get_slug(e);

            this.action(slug, 'activate');
        },

        template: function (data) {
            var id = this.$el.attr('data-template');

            return wp.template(id)(data);
        },

        initialize: function () {
            this.model = new Child_Theme_Model(tc_child_themes);
            this.render();
            var self = this;

            this.model.on('change', function () {
                self.render();
            });
        },

        render: function () {
            this.$el.html(this.template(this.model.toJSON()));

            return this;
        }
    });

    $(document).ready(function () {
        new Child_Theme_View();
    });
})(jQuery);