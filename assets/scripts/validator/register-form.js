(function() {
    $('#register-form').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            passwordVerify: {
                required: true,
                minlength: 6,
                equalTo: '[name="password"]'
            }
        }
    });
})();
