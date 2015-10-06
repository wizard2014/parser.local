/**
 * Region selector
 */
(function() {
    $('.get-region').on('click', function() {
        var destination = $('.destination'),
            modalTitle  = $('.modal-title');

        var title = $(this).data('title');

        $.ajax({
            type: 'POST',
            url : '/get-started/get-region',

            beforeSend: function() {
                destination.empty();
                modalTitle.empty();
            }
        })
            .done(function(data) {
                var region = data.ebaySourceRegional,
                    html   = '';

                $.each(region, function (key, value) {
                    html += '<button type="button" class="btn btn-flat btn-default set-region" data-region="' + key + '">' + value + '</button>';
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

    $(document).on('click', '.set-region', function() {
        // reset category
        var inputCategory = $('.input-category');
        inputCategory.val('');
        inputCategory.data('level', 1);

        var id    = $(this).data('region'),
            value = $(this).text();

        $('.input-region').val(id);
        $('.get-region').text(value);

        $('#modal').modal('hide');
    });
})();
