$(document).ready(function () {
    $('form').on('submit', function (e) {
        var $form = $(this);
        if ($form.data('submitted') === true) {
            e.preventDefault();
        } else {
            $form.data('submitted', true);
        }
    });
});
