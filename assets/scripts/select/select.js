/**
 * Send Ajax call
 */
(function() {
    // select region
    var option = $('.cs-options').find('span');

    $(document).on('click', option, function() {
        var val      = $('.cs-selected').data('value'),
            selected = $('.selected-item');

        if (val !== undefined && val !== selected.val()) {
            selected.val(val);

            ajaxCall(val, 1, null);
        }
    });

    //select category
    // $('').clone().attr('class', 'newLevel').appendTo('.category');

    // ajax call
    function ajaxCall(region, level, parentId) {
        $.ajax({
            type: 'POST',
            url: '/get-started/get-catalog-item',
            data: { region: region, level: level, parentId: parentId },

            beforeSend: function() {
                                
            }
        })
            .done(function(data) {
                $('.category-level').last().text('[level ' + data.categoryLevel + ']');

                $(data.catalogList).each(function(index, value) {
                    $('.category').append('<option value="' + value.category_id + '">' + value.category_name + '</option>');
                });
            })
            .fail(function() {})
            .always(function() {});
    }
})();