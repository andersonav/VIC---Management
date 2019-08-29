$(document).ready(function () {
    $("li.nav-item").each(function () {
        $(this).removeClass('active');
    });

    $("a[data-to=atividades3]").trigger('click');
    getLotes("");
});


function getLotes(idLote) {
    $.ajax({
        type: 'POST',
        url: "/getLotes",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
        }, success: function (data, textStatus, jqXHR) {
            $("select#idLote").html("");
            $("select#idLote").append('<option value="">Selecione uma opção</option>');
            for (var i = 0; i < data.length; i++) {
                $("select#idLote").append('<option value="' + data[i].lot_id + '">' + data[i].lot_nome + '</option>');
            }
            $("#idLote").val(idLote);
        }
    });
}