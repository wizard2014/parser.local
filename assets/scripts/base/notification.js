/**
 * Email notification
 */
(function() {
    // notification-check
    var notificationForm = $('.notification-form');

    notificationForm.on('submit', function(e) {
        e.preventDefault();
    });

    var checkbox = $('.notification-checkbox'),
        token    = notificationForm.find('.token');

    checkbox.on('click', function() {
        $.ajax({
            type: 'POST',
            url : '/user/settings/notification',
            data: { token: token.val() },

            beforeSend: function() {
                checkbox.attr('disabled', true);
            }
        })
            .done(function(data) {
                if (data.token) {
                    token.val(data.token);
                }
            })
            .fail(function() {
                //ajaxFail();
            })
            .always(function() {
                checkbox.removeAttr('disabled');
            });
    });
})();