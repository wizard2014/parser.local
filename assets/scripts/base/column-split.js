(function() {
    $('#modal').on('show.bs.modal', function() {
        var destination = $('.destination').children('.item'),
            length      = destination.length;

        if (length > 25) {
            console.log(Math.ceil(length / 3));
            destination.slice(0, Math.ceil(length / 3)).wrapAll('<div class="col col-md-4" />');
            destination.slice(Math.ceil(length / 3), Math.ceil(length / 3) * 2).wrapAll('<div class="col col-md-4" />');
            destination.slice(Math.ceil(length / 3) * 2, length).wrapAll('<div class="col col-md-4" />');
        } else if (length > 10) {
            destination.slice(0, Math.ceil(length / 2)).wrapAll('<div class="col col-md-6" />');
            destination.slice(Math.ceil(length / 2), length).wrapAll('<div class="col col-md-6" />');
        }
    });
})();
