$(document).ready(function () {
    $("li.nav-item").each(function () {
        $(this).removeClass('active');
    });

    $("a[data-to=atividades3]").trigger('click');
});

function editarAtividade(idAtividade, idLote, codigo, nomeAtividade) {
    getLotes(idLote);
    $("#nomeAtividade").val(nomeAtividade);
    $("#codigo").val(codigo);
    $("#idAtividade").val(idAtividade);
    $("#editarAtividade").modal('show');
}


function deletarAtividade(idAtividade) {
    var url_atual = window.location.href;
    swal({
        title: 'Você tem certeza que deseja excluir essa atividade?',
        text: "Essa ação não poderá ser desfeita!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, eu desejo!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: 'POST',
                url: url_atual + "/deletarAtividade",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: idAtividade
                }, success: function (data, textStatus, jqXHR) {
                    swal(
                        'Deletado!',
                        'A atividade foi deletada!.',
                        'success'
                    )
                    var refreshIntervalId = setInterval(function () {
                        window.location.href = url_atual;
                        clearInterval(refreshIntervalId);
                    }, 1500);
                }
            });

        }
    })

}


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