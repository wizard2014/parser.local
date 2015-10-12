/**
 * Region selector
 */
(function() {
    $('.get-region').on('click', function() {
        var destination = $('.destination'),
            modalTitle  = $('.modal-title'),
            loader      = $('.loader');

        var title = $(this).data('title');

        $.ajax({
            type: 'POST',
            url : '/get-started/get-region',

            beforeSend: function() {
                loader.toggleClass('visible');

                destination.empty();
                modalTitle.empty();
            }
        })
            .done(function(data) {
                var region = data.ebaySourceRegional,
                    html   = '';

                $.each(region, function (key, value) {
                    html += '<span class="item"><button type="button" class="btn btn-link set-region" data-region="' + key + '">' + value + '</button></span>';
                });

                destination.append(html);
                modalTitle.text(title);

                $('#modal').modal('show');
            })
            .fail(function() {

            })
            .always(function() {
                loader.toggleClass('visible');
            });
    });

    $(document).on('click', '.set-region', function() {
        // reset category
        resetCategory();

        var id    = $(this).data('region'),
            value = $(this).text();

        $('.input-region').val(id);
        $('.get-region').text(value);

        $('#modal').modal('hide');
    });

    function resetCategory() {
        $('.input-category').val('');
        $('.input-category-level').val(1);

        $('.category-list').empty();
    }
})();
