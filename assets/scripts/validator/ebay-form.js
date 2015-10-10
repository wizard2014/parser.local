(function() {
    // if category exists
    $('.ebay-form').on('submit', function(e) {
        if (!checkCategoryExists()) {
            e.preventDefault();
        }
    });

    // enable/disable button
    // when modal hidden
    $('#modal').on('hidden.bs.modal', function() {
        !checkCategoryExists() ? disableBtn() : enableBtn();
    });
    // when category remove
    $(document).on('click', '.category-remove', function() {
        setTimeout(function() {
            !checkCategoryExists() ? disableBtn() : enableBtn();
        }, 450);
    });

    function checkCategoryExists() {
        return !$('.category-list').is(':empty');
    }

    // enable/disable button
    function enableBtn() {
        $('.submit-btn').removeClass('disabled').prop('disabled', false);
    }
    function disableBtn() {
        $('.submit-btn').addClass('disabled').prop('disabled', true);
    }

    // numbers only
    $('.num-only').on('keypress', function(e) {
        return !(/\D/.test(String.fromCharCode(e.charCode)));
    });
})();
