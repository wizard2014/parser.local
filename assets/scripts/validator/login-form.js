(function() {
    $('#login-form').validate({ // initialize the plugin
        rules: {
            identity: {
                required: true,
                email: true
            },
            credential: {
                required: true,
                minlength: 6
            }
        }
    });
})();