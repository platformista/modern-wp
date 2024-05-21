(function ($) {
    var Thim_Modal_Wrapper = Backbone.View.extend({
        el: '.tc-modals-wrapper',

        events: {
            'click .close': 'onClickClose'
        },

        initialize: function () {
            $(document).on('click', '.thim-core-open-modal', this.onClickOpen.bind(this));
            $(window).on('thim_core_trigger_open_modal', this.onTriggerClickOpen.bind(this));
        },

        onTriggerClickOpen: function (e, id) {
            if (!id) {
                return;
            }

            this.open(id);
        },

        onClickOpen: function (e) {
            e.preventDefault();
            var $current = $(e.currentTarget);

            var refModal = $current.attr('data-modal');
            if (!refModal) {
                return;
            }

            this.open(refModal);
        },

        onClickClose: function (e) {
            var $modal = this.$(e.currentTarget).closest('.tc-modal');
            var id = '#' + $modal.attr('id');
            this.close(id);
        },

        open: function (id) {
            var $modal = this.$('#' + id);
            if (!$modal.length) {
                return;
            }

            this.render(id);
            $modal.addClass('md-show');
            $(window).trigger('thim_core_open_modal', id);
        },

        close: function (selector) {
            $(selector).removeClass('md-show');
            $(window).trigger('thim_core_close_modal', selector);
        },

        template: function (id, data) {
            return wp.template(id)(data);
        },

        render: function (id) {
            this.$('#' + id).html(this.template(id, null));
        }
    });

    window.Thim_Core_Modal = (function () {

    })();

    $(document).ready(function () {
        new Thim_Modal_Wrapper();
    });
})(jQuery);