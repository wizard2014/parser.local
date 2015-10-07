/**
 * Category selector
 */
(function() {
    $(document).on('click', '.get-category', function() {
        var destination = $('.destination'),
            modalTitle  = $('.modal-title');

        var region   = $('.input-region').val(),
            level    = $('.input-category-level').val(),
            parentId = $('.input-category').val();

        var title = $(this).data('title');

        $.ajax({
            type: 'POST',
            url : '/get-started/get-category',
            data : { region: region, level: level, parentId: parentId },

            beforeSend: function() {
                destination.empty();
                modalTitle.empty();
            }
        })
            .done(function(data) {
                var categories = data.categoryList,
                    html       = '';

                if (categories.length > 0) {
                    $.each(categories, function (key, value) {
                        html += '<button type="button" class="btn btn-link set-category" data-category-id="' + value.id + '" data-category-level="' + value.level + '">' + value.name + '</button>';
                    });

                    destination.append(html);
                    modalTitle.text(title);

                    $('#modal').modal('show');
                }
            })
            .fail(function() {

            })
            .always(function() {

            });
    });

    $(document).on('click', '.set-category', function() {
        var id    = $(this).data('category-id'),
            level = $('.input-category-level'),
            value = $(this).text();

        var nextLevel = parseInt(level.val()) + 1;

        level.val(nextLevel);
        $('.input-category').val(id);

        $('.category-list').append(
            '<span>' +
                '<button type="button" class="btn btn-link get-category" data-level="' + level.val() + '" data-category-id="' + id + '" data-target="#modal" data-title="Select category or subcategory">' + value + '</button>' +
                '<i class="fa fa-trash category-remove cursor-pointer" data-toggle="tooltip" data-placement="top" title="Remove"></i>' +
            '</span>');

        $('#modal').modal('hide');
    });

    // remove category elements
    $(document).on('click', '.category-remove', function() {
        $(this).parent('span').nextAll('span').addBack().fadeOut(400, function() {
            $(this).remove();

            var lastElem = $('.category-list').children('span').last().find('button');

            if (lastElem.data('category-id') === undefined || lastElem.data('level') === undefined) {
                $('.input-category').val('');
                $('.input-category-level').val(1);
            } else {
                $('.input-category').val(lastElem.data('category-id'));
                $('.input-category-level').val(lastElem.data('level'));
            }
        });
    });
})();