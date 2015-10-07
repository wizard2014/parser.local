/**
 * Category selector
 */
(function() {
    $(document).on('click', '.get-category', function() {
        var destination = $('.destination'),
            modalTitle  = $('.modal-title');

        var inputCategory = $('.input-category');

        var region   = $('.input-region').val(),
            level    = $('.input-category-level').val(),
            parentId = inputCategory.data('parentId');

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

                $.each(categories, function (key, value) {
                    html += '<button type="button" class="btn btn-flat btn-default set-category" data-category-id="' + value.id + '" data-category-level="' + value.level + '">' + value.name + '</button>';
                });

                destination.append(html);
                modalTitle.text(title);

                $('#modal').modal('show');
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

        var inputCategory = $('.input-category');
        var nextLevel     = parseInt(level.val()) + 1;

        level.val(nextLevel);
        inputCategory.val(id);
        inputCategory.data('parentId', id);

        $('.category-list').prepend('<button type="button" class="btn btn-flat btn-default get-category" data-target="#modal" data-title="Select category or subcategory">' + value + '</button>');

        $('#modal').modal('hide');
    });
})();