function editarLote(idProjeto, idLote, nomeLote) {
    getProjetos(idProjeto);
    $("#nomeLote").val(nomeLote);
    $("#idLote").val(idLote);

    $("#editarLote").modal('show');
}


function deletarLote(idLote) {
    var url_atual = window.location.href;
    swal({
        title: 'Você tem certeza que deseja excluir esse lote?',
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
                url: "/deletarLote",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: idLote
                }, success: function (data, textStatus, jqXHR) {
                    swal(
                        'Deletado!',
                        'O lote foi deletado!.',
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

function openModalAddLote(idProjeto) {
    getProjetos(idProjeto);

    $("#addLote").modal('show');
}



function getProjetos(idProjeto) {
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
            $("select#idProjeto").val(idProjeto);
        }
    });
}