(function() {
    $('#modal').on('show.bs.modal', function() {
        $.expr[':'].contains = function(a,i,m) {
            return (a.textContent || a.innerText || '').toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
        };

        function filterList(header, list) {
            var filterInput = $('.filter-input');

            if (filterInput.length == 0) {
                var input   = $('<input>').attr({'class': 'filter-input form-control', 'type': 'search', 'placeholder': 'Filter'});
                $(input).appendTo(header);
            }

            filterInput.val('');

            $(input).on('change', function() {
                var filter = $(this).val();

                if (filter) {
                    var matches = $(list).find('button:contains(' + filter + ')').parent();
                    $('.item', list).not(matches).addClass('hide');
                    matches.removeClass('hide');
                } else {
                    $(list).find('.item').removeClass('hide');
                }

                return false;
            }).keyup(function() {
                $(this).trigger('change');
            });
        }

        filterList($('#form-filter'), $('.destination'));
    });
})();