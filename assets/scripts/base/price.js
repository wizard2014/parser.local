/**
 * Price
 */
(function() {
    $('.price-header').matchHeight();

    $('.toggle-checkbox').on('click', function() {
        var withoutKey  = $('.price-block-without-key'),
            withKey     = $('.price-block-with-key');

        if ($(this).prop('checked')) {
            withoutKey.addClass('hide');
            withKey.removeClass('hide');
        } else {
            withKey.addClass('hide');
            withoutKey.removeClass('hide');
        }

        $('.price-header').matchHeight();
    });
})();
