$(document).ready(function () {
    $("li.nav-item").each(function () {
        $(this).removeClass('active');
    });

    $("a[data-to=lotes2]").trigger('click');
    getProjetos();
});


function getProjetos() {
    $.ajax({
        type: 'POST',
        url: "/superAdmin/getProjetos",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
        }, success: function (data, textStatus, jqXHR) {
            for (var i = 0; i < data.length; i++) {
                $("select#idProjeto").append('<option value="' + data[i].pro_id + '">' + data[i].pro_nome + '</option>');
            }

        }
    });
}