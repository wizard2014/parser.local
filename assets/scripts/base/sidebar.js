(function() {
    var url   = location.href.split('/').pop(),
        links = $('.sidebar').find('a');

    $.each(links, function() {
        if ($(this).prop('href').indexOf(url) != -1) {
            $(this).addClass('active');
        }
    });
})();
