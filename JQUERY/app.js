$(document).ready(function () {
    $(':radio[name="sexe"]').val(['homme']);
    $('#exec').on('click', function () {
        sexeValue = $(':radio[name="sexe"]:checked').val();
        $('.show').text(sexeValue);

    });
})