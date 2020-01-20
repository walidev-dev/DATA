$('#region').change(function () {
    var $regionField = $(this);
    var $form = $regionField.closest('form');
    var data = {};
    data[$regionField.attr('name')] = $regionField.val();
    $.post($form.attr('action'), data)
        .then(function (data) {
            var $departementSelect = $(data).find('#departement');
            $('#departement').replaceWith($departementSelect);
        })
});
$('form').on('change', '#departement', function () {
    var $departementField = $(this);
    var $regionField = $('#region');
    var $form = $departementField.closest('form');
    var data = {};
    data[$departementField.attr('name')] = $departementField.val();
    data[$regionField.attr('name')] = $regionField.val();
    $.post($form.attr('action'), data)
        .then(function (data) {
            var $villeSelect = $(data).find('#ville');
            $('#ville').replaceWith($villeSelect);
        })
});