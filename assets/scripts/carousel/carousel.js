'use strict';

var carousel = $('#myCarousel');

carousel.carousel({
    interval: 4000
});

var clickEvent = false;

carousel.on('click', '.nav a', function() {
    clickEvent = true;

    $('.nav').find('li').removeClass('active');
    $(this).parent().addClass('active');

}).on('slid.bs.carousel', function() {

    if(!clickEvent) {
        var count   = carousel.find('.nav').children().length - 1;
        var current = carousel.find('.nav').find('li.active');

        current.removeClass('active').next().addClass('active');
        var id = parseInt(current.data('slide-to'));

        if(count == id) {
            $('#myCarousel').find('.nav').find('li').first().addClass('active');
        }
    }

    clickEvent = false;
});