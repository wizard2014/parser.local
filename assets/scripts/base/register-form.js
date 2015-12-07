// register form
(function() {
    // local storage
    var LS = {
        set: function(key, val) {
            return localStorage.setItem(key, JSON.stringify(val));
        },
        get: function(key) {
            return JSON.parse(localStorage.getItem(key));
        },
        remove: function(key) {
            return localStorage.removeItem(key);
        }
    };

    var checkbox = $('.agree-checkbox');

    checkbox.on('click', function() {
        var form = $('.register-form');

        if ($(this).is(':checked')) {
            btnToggle(true);

            LS.set('terms-agree', true);
        } else {
            btnToggle(false);

            LS.set('terms-agree', false);
        }
    });

    var terms = LS.get('terms-agree');

    if (terms) {
        btnToggle(true);
        checkbox.trigger('click');
    }

    function btnToggle(state) {
        var btn = $('.register-form').find('.submit-btn');

        if (state) {
            btn.removeClass('disabled').prop('disabled', false);
        } else {
            btn.addClass('disabled').prop('disabled', true);
        }
    }
})();