$(function () {
    $('.datetime-input').datetime({
        userLang: 'fr',
    });

    $('.datetime-input-clear').button();

    $('.datetime-input-clear').click(function () {
        $(this).parent().find('.datetime-input').val("");
        return false;
    });

});