// Password progress
(function() {
    var options = {};
    options.ui = {
        showVerdictsInsideProgressBar: true
    };

    $('.register-form').find(':password').first().pwstrength(options);
})();