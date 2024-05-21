;'use strict';

var Thim_Plugins = (function ($) {
    var ajax_url = thim_plugins_manager.admin_ajax_action;

    return {
        request: request
    };

    function request(action, slug) {
        window.onbeforeunload = function () {
            return true;
        };

        return $
            .ajax({
                url: ajax_url,
                method: 'POST',
                data: {
                    action: 'thim_plugins_manager',
                    plugin_action: action,
                    slug: slug
                },
                dataType: 'json'
            })
            .error(function (error) {
                console.error(error);
            });
    }
})(jQuery);

var Thim_Plugins_Queue = (function ($) {
    var actions = [];
    var is_running = false;
    var callback_success = false;
    var callback_error = false;
    var callback_complete = false;

    return {
        push: push,
        success: success,
        error: error,
        complete: complete,
        count: count
    };

    function count() {
        return actions.length;
    }

    function complete(cb) {
        callback_complete = cb;
    }

    function error(cb) {
        callback_error = cb;
    }

    /**
     * Add callback function when action success.
     * @param cb
     */
    function success(cb) {
        callback_success = cb;
    }

    /**
     * Push to queue actions
     * @param object ; {action: '', slug: ''}
     */
    function push(object) {
        actions.push(object);

        if (!is_running) {
            _run();
        }
    }

    /**
     * Run action
     * @private
     */
    function _run() {
        is_running = true;

        if (!actions.length) {
            is_running = false;
            return;
        }
        var first = actions[0];

        Thim_Plugins.request(first.action, first.slug)
            .success(function (response) {
                if (callback_success) {
                    callback_success(response, first);
                }
            })
            .complete(function () {
                if (callback_complete) {
                    callback_complete(first);
                }

                window.onbeforeunload = null;
                _next();
            })
            .error(function (error) {
                if (callback_error) {
                    callback_error(first, error);
                }
            });
    }

    /**
     * Next action
     * @private
     */
    function _next() {
        is_running = false;
        actions.shift();

        _run();
    }
})(jQuery);