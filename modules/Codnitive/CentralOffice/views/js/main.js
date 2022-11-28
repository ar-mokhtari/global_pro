$('.user-menu').click(function () {
    $(this).find('#user-menu').slideToggle(150);
});
$('.dropdown.tasks-menu,.dropdown.notifications-menu,.dropdown.messages-menu').hover(function () {
    $(this).find('.dropdown-menu').slideToggle(150);
});

$(window).on('keyup', function (evt) {
    if (evt.keyCode === 27) {
        var close_box = $('.modal')
            , select_enable_modal = close_box.find("[id$='_modal_box']:not(:empty)")
            , len = select_enable_modal.length
            , select_target = $("button[class$='_closed']:eq(" + len + ")");
        select_target.trigger('click');
    }
});
