(function() {
    $('.key-form-toggle').on('click', function() {
        $('.api-key-form').toggleClass('hide');
    });

    var form  = $('.api-key-form-item'),
        btn   = $('.keys-btn');

    form.on('submit', function(e) {
        e.preventDefault();

        var token  = $(this).find('.token'),
            vendor = $(this).find('.vendor'),
            key    = $(this).find('.access-key');

        $.ajax({
            type: 'POST',
            url : '/user/settings/profile',
            data: { vendor: vendor.val(), key: key.val(), token: token.val() },

            beforeSend: function() {
                btn.attr('disabled', true).addClass('disabled');
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
                btn.removeAttr('disabled').removeClass('disabled');
            });
    });
})();