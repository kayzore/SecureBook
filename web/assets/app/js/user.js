var user = function () {
    var client_listener = new Faye.Client('http://localhost:3000/'),
        new_notification,
        show_notification,
        init_user;

    /**
     * Init user functionality
     */
    init_user = function () {
        client_listener.subscribe('/' + $('#username').text(), function (message) {
            new_notification(message);
        });
    };

    /**
     * When a user receive new notification, traitement and display
     * @param message
     */
    new_notification = function (message) {
        var type;
        if (message.type = 'like') {
            type = '<i class="fa fa-thumbs-up" aria-hidden="true"></i> ';
        } else if (message.type = 'comment') {
            type = '<i class="fa fa-commenting-o" aria-hidden="true"></i> ';
        } else {
            type = '';
        }
        show_notification(type, message)
    };

    /**
     * Show a notification
     * @param type
     * @param message
     */
    show_notification = function (type, message) {
        $.notify({
            message: type + message.text
        }, {
            type: "info",
            allow_dismiss: true,
            delay: 3000,
            animate: {
                enter: 'animated fadeInLeft',
                exit: 'animated fadeOutLeft'
            },
            placement: {
                from: "bottom",
                align: "left"
            }
        });
    };

    return {
        init_user: init_user,
        new_notification: new_notification,
        client_listener: client_listener
    };
}();