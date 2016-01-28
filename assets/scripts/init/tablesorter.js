/**
 * Table sorter
 */
$('.tablesorter').tablesorter({
    headers: {
        1: {
            sorter: false
        }
    }
});

$('.tablesorter .header').on('click', function() {
    var self = $(this);
    var headerSort = self.hasClass('headerSortDown');

    if (headerSort) {
        self.find('.fa-caret-up').removeClass('fa-caret-up').addClass('fa-caret-down');
    } else {
        self.find('.fa-caret-down').removeClass('fa-caret-down').addClass('fa-caret-up');
    }
});
