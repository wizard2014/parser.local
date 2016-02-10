(function() {
    var date = $('.countdown-holder').data('time');

    $('.countdown').countdown(date, {elapse: true})
        .on('update.countdown', function(e) {
            var $this = $(this);

            if (e.elapsed) {
                $this.text('Active');
            } else {
                $this.html(e.strftime('%H:%M:%S'));
            }
        });
})();
