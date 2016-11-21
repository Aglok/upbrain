$(function () {

    function removeSelected(elBtn) {
        $(elBtn).each(function () {
            $(this).attr('title', 'Ничего не выбрано').html('Ничего не выбрано <b class="caret"></b>');
        });

        var elUl = $(elBtn).next();
        var radioBtn = elUl.find('li.active input');
        radioBtn.each(function () {
            $(this).attr('checked', false).closest('li').removeClass('active');
        });
    }

    function displayOn() {
        $('#import-select').change(function () {
            $('.import-file').css('display', 'block');
        });

    }

    displayOn();
    removeSelected('button.multiselect');
});
