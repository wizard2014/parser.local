// AJAX call
(function() {
    if (!'onhashchange' in window) {
        alert('The browser doesn\'t supports the hashchange event!');
    }

    var pathName = window.location.pathname,
        hash     = window.location.hash.split('#')[1];

    function urlCheck(hash, pathName) {
        var hashes = ['/ebay'],
            route  = '/get-started';

        pathName = pathName || window.location.pathname;

        return !!(pathName == route && hashes.indexOf(hash) != -1);
    }

    function makeCall(hash) {
        $.ajax({
            type: 'POST',
            url: hash,

            beforeSend: function() {

            }
        })
            .done(function(data) {
                var region    = data.region;

                console.log(region);
            })
            .fail(function() {

            })
            .always(function() {

            });
    }

    // on hashchange
    $(window).on('hashchange', function() {
        var hash = window.location.hash.split('#')[1];
        
        if (urlCheck(hash)) { makeCall(hash) }
    });

    // on page load
    if (urlCheck(hash, pathName)) { makeCall(hash) }
})();
