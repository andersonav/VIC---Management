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
        url: "/getProjetos",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
        }, success: function (data, textStatus, jqXHR) {
            $("select#idProjeto").html("");
            $("select#idProjeto").append('<option value="">Selecione uma opção</option>');
            for (var i = 0; i < data.length; i++) {
                $("select#idProjeto").append('<option value="' + data[i].pro_id + '">' + data[i].pro_nome + '</option>');
            }

        }
    });
}