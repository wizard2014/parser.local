/**
 * Send Ajax call
 */
(function() {
    var option = $('.cs-options').find('span');

    $(document).on('click', option, function() {
        var val      = $('.cs-selected').data('value'),
            selected = $('.selected-item');

        if (val !== undefined && val !== selected.val()) {
            selected.val(val);

            ajaxCall(val, 1, null);
        }
    });

    function ajaxCall(region, level, parentId) {
        $.ajax({
            type: 'POST',
            url: '/get-started/get-catalog-item',
            data: { region: region, level: level, parentId: parentId },

            beforeSend: function() {}
        })
            .done(function(data) {
                $(data.catalogList).each(function(index, value) {
                    $('.category').append('<option value="' + value.category_id + '">' + value.category_name + '</option>');
                });
            })
            .fail(function() {})
            .always(function() {});
    }
})();