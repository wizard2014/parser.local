/**
 * Email notification
 */
(function() {
    // notification-check
    $('.notification-form').on('submit', function(e) {
        e.preventDefault();
    });

    var checkbox = $('.notification-checkbox');

    checkbox.on('click', function() {
        $.ajax({
            type: 'POST',
            url : '/user/settings/notification',

            beforeSend: function() {
                checkbox.attr('disabled', true);
            }
        })
            .done(function(data) {
            })
            .fail(function() {
                //ajaxFail();
            })
            .always(function() {
                checkbox.removeAttr('disabled');
            });
    });
})();