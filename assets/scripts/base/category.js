/**
 * Category selector
 */
(function() {
    // add new category
    $(document).on('click', '.add-category', function() {
        var destination = $('.destination'),
            modalTitle  = $('.modal-title'),
            loader      = $('.loader');

        var region   = $('.input-region').val(),
            level    = $('.input-category-level').val(),
            parentId = $('.input-category').val();

        var title = $(this).data('title');

        // ajax call
        var data = { region: region, level: level, parentId: parentId };
        ajaxCall(
            data,
            function () { // beforeSend
                loader.toggleClass('visible');

                destination.empty();
                modalTitle.empty();
            },
            function (ajaxData) {
                var categories = ajaxData.categoryList,
                    html       = '';

                if (categories.length > 0) {
                    $.each(categories, function (key, value) {
                        html += '<span class="item"><button type="button" class="btn btn-link set-category" data-category-id="' + value.id + '" data-category-level="' + value.level + '">' + value.name + '</button></span>';
                    });

                    destination.append(html);
                    modalTitle.text(title);

                    $('#modal').modal('show');
                }
        });
    });

    $(document).on('click', '.set-category', function() {
        var id     = $(this).data('category-id'),
            level  = $('.input-category-level'), // level from hidden input
            value  = $(this).text(),
            region = $('.input-region').val();

        var nextLevel = parseInt(level.val()) + 1;

        level.val(nextLevel);
        $('.input-category').val(id);

        $('.category-list').append(
            '<span>' +
                '<button type="button" class="btn btn-link edit-category" data-level="' + level.val() + '" data-category-id="' + id + '" data-target="#modal" data-title="Select category or subcategory">' + value + '</button>' +
                '<i class="fa fa-trash category-remove cursor-pointer" data-toggle="tooltip" data-placement="top" title="Remove"></i>' +
            '</span>'
        );

        // if next category not exists hide plus btn
        var data = { region: region, level: nextLevel, parentId: id };
        ajaxCall(
            data,
            function() {
                $('.loader').toggleClass('visible');
            },
            function (ajaxData) {
                var categories = ajaxData.categoryList;

                if (categories.length == 0) {
                    $('.add-category').addClass('hide');
                }

                $('#modal').modal('hide');
            });
    });

    // edit current category
    $(document).on('click', '.edit-category', function() {
        var destination = $('.destination'),
            modalTitle  = $('.modal-title'),
            loader      = $('.loader');

        var replaceId = $(this).data('category-id');

        var prev = $(this).parent('span').prev().find('button');

        var region   = $('.input-region').val(),
            level    = prev.data('level')       !== undefined ? prev.data('level')       : 1,
            parentId = prev.data('category-id') !== undefined ? prev.data('category-id') : '';

        var title = $(this).data('title');

        // ajax call
        var data = { region: region, level: level, parentId: parentId };
        ajaxCall(
            data,
            function () { // beforeSend
                loader.toggleClass('visible');

                destination.empty();
                modalTitle.empty();
            },
            function (ajaxData) {
                var categories = ajaxData.categoryList,
                    html       = '';

                if (categories.length > 0) {
                    $.each(categories, function (key, value) {
                        html += '<span class="item"><button type="button" class="btn btn-link replace-category" data-replace-with="' + replaceId + '" data-category-id="' + value.id + '" data-category-level="' + value.level + '">' + value.name + '</button></span>';
                    });

                    destination.append(html);
                    modalTitle.text(title);

                    $('#modal').modal('show');
                }
            });
    });

    $(document).on('click', '.replace-category', function() {
        var id      = $(this).data('category-id'),
            level   = $(this).data('category-level'),
            value   = $(this).text(),
            replace = $(this).data('replace-with'),
            region  = $('.input-region').val();

        var nextLevel = parseInt(level) + 1;

        $('.input-category-level').val(nextLevel);
        $('.input-category').val(id);

        $.each($('.category-list').find('span'), function() {
            if ($(this).find('button').data('category-id') == replace) {
                $(this).next('span').find('.category-remove').trigger('click');

                $(this).replaceWith(
                    '<span>' +
                        '<button type="button" class="btn btn-link edit-category" data-level="' + nextLevel + '" data-category-id="' + id + '" data-target="#modal" data-title="Select category or subcategory">' + value + '</button>' +
                        '<i class="fa fa-trash category-remove cursor-pointer" data-toggle="tooltip" data-placement="top" title="Remove"></i>' +
                    '</span>'
                );
            }
        });

        // if next category not exists hide plus btn
        var data = { region: region, level: nextLevel, parentId: id };
        ajaxCall(
            data,
            function() {
                $('.loader').toggleClass('visible');
            },
            function (ajaxData) {
                var categories = ajaxData.categoryList;

                if (categories.length == 0) {
                    $('.add-category').addClass('hide');
                } else {
                    $('.add-category').removeClass('hide');
                }

                $('#modal').modal('hide');
        });
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

            $('.add-category').removeClass('hide');
        });
    });

    // ajax call
    function ajaxCall(data, beforeSend, callback) {
        $.ajax({
            type: 'POST',
            url  : '/get-started/get-category',
            data : data,

            beforeSend: beforeSend
        })
            .done(function(data) {
                callback(data);
            })
            .fail(function() {
                ajaxFail();
            })
            .always(function() {
                $('.loader').toggleClass('visible');
            });
    }

    // ajax call failed
    function ajaxFail() {
        $('.alert').removeClass('hide').find('.error-list').append('<li>Something went wrong! Please try again later.</li>');
    }
})();