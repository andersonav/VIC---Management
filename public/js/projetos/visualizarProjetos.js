$(document).ready(function () {
    $("li.nav-item").each(function () {
        $(this).removeClass('active');
    });

    $("a[data-to=projetos1]").trigger('click');
});