$(document).ready(function () {
    var $category = $('#category');
    $category.on('change', function () {
        var $form = $(this).closest('form');
        var data = {};
        data[$category.attr('name')] = $category.val();
        $.post($form.attr('action'), data)
            .then(function (response) {
                $('#sub_category').replaceWith(
                    $(response).find('#sub_category')
                );
            })
    })
});