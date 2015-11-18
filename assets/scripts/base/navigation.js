(function() {
    $('.dropdown').on('click', function() {
        var caret = $(this).find('i').last();

        if (caret.hasClass('fa-caret-down')) {
            caret.removeClass('fa-caret-down').addClass('fa-caret-up');
        } else {
            caret.removeClass('fa-caret-up').addClass('fa-caret-down');
        }
    });

    $('html').on('click', function() {
        var dropdown = $('.dropdown');

        if (dropdown.hasClass('open')) {
            dropdown.find('i').last().removeClass('fa-caret-up').addClass('fa-caret-down');
        }
    });
})();