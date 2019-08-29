$(document).ready(function () {
    $("li.nav-item").each(function () {
        $(this).removeClass('active');
    });

    $("a[data-to=atividades3]").trigger('click');
});