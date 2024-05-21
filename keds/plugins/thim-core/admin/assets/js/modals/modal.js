;'use strict';

(function ($) {
    var Thim_Modal_Iframe = Backbone.View.extend({
        el: '#tc-modal-iframe',

        data: {},

        initialize: function () {
            $(document).on('click', '.tc-open-modal', this.onClickOpen.bind(this));
        },

        onClickOpen: function (e) {
            e.preventDefault();
            var $current = $(e.currentTarget);

            var href = $current.attr('href');
            if (!href) {
                return;
            }

            var title = $current.attr('title');
            this.openIframeModal(href, title);
        },

        openIframeModal: function (href, title) {
            this.data.title = title;
            this.data.src = href;

            this.render();
            this.$el.addClass('md-show');
        },

        template: function (data) {
            var id = this.$el.attr('data-template');

            return wp.template(id)(data);
        },

        render: function () {
            this.$el.html(this.template(this.data));
        }
    });

    var Thim_Modal = Backbone.View.extend({
        el: '.tc-modal',

        events: {
            'click .close': 'onClickClose'
        },

        initialize: function () {
            $(document).on('click', '.tc-open-modal', this.onClickOpen.bind(this));
            $(window).on('tc_modal_close', this.listenerClose.bind(this));
        },

        onClickOpen: function (e) {
            e.preventDefault();
            var $current = $(e.currentTarget);

            var refModal = $current.attr('data-modal');
            if (!refModal) {
                return;
            }

            var $modal = $(refModal);
            if ($modal.length > 0) {
                $modal.addClass('md-show');
            }

            var render = $current.attr('data-render');
            if (render === 'render') {
                this.render();
            }

            $(window).trigger('thim_modal_open', refModal);
        },

        onClickClose: function (e) {
            var $modal = this.$(e.currentTarget).closest('.tc-modal');
            var id = '#' + $modal.attr('id');
            this.close(id);
        },

        listenerClose: function (e, selector) {
            this.close(selector);
        },

        close: function (selector) {
            $(selector).removeClass('md-show');
        },

        template: function (data) {
            var id = this.$el.attr('data-template');

            return wp.template(id)(data);
        },

        render: function () {
            this.$el.html(this.template(this.data));
        }
    });

    $(document).ready(function () {
        new Thim_Modal();
        new Thim_Modal_Iframe();
    });
})(jQuery);