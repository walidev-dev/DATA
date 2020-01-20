$(document).ready(function () {
    var $addNewItem = $('<a href="#" class="btn btn-info">Add new item</a>');
    var $collectionHolder = $('#exp_list');
    $collectionHolder.append($addNewItem);
    $collectionHolder.data('index', $collectionHolder.find('.panel-warning').length);
    $addNewItem.click(function () {
        addNewForm();
    });
    $collectionHolder.find('.panel-warning').each(function () {
        addRemoveButton($(this));
    });


    function addRemoveButton($panel) {
        var $removeButton = $('<a href="#" class="btn btn-danger">Remove</a>');
        var $panelFooter = $('<div class="panel-footer"></div>').append($removeButton);

        $removeButton.click(function (e) {
            //$(this).closest('.panel-warning').fadeOut('2500');

            $(e.target).parents('.panel-warning').slideUp('1000', function () {
                $(this).remove();
            });

        });

        $panel.append($panelFooter);
    }

    function addNewForm() {
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        var newForm = prototype;
        newForm = newForm.replace(/__name__/g, index);
        $collectionHolder.data('index', index + 1);
        var $panel = $('<div class="panel panel-warning"><div class="panel-heading"></div></div>');
        var $panelBody = $('<div class="panel-body"></div>').append(newForm);
        $panel.append($panelBody);
        addRemoveButton($panel);
        $addNewItem.before($panel);
    }
});