$(document).ready(function () {
   

});

function openModalAddAtividade() {
    var idAtividade = $("#idAtividadeProv").val();
    getAtividades(idAtividade);
    getUnidade("");
    $("#addAtividadeUnica").modal('show');
}

function editarAtividadeUnica(idAtividade, idUnidade, idAtividade1, codigo, descricao, precoUnidade, quantidade, faturado) {
    getAtividades(idAtividade1);
    getUnidade(idUnidade);
    $("#codigo").val(codigo);
    $("#descricaoAtividade").val(descricao);
    $("#precoUnidade").val(precoUnidade);
    $("#quantidade").val(quantidade);
    $("#idAtividade").val(idAtividade);
    $("#faturado").val(faturado);
    $("#editarAtividadeUnica").modal('show');
}


function deletarAtividadeUnica(idAtividade) {
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
                url: "/deletarAtividade2",
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


function getAtividades(idAtividade1) {
    $.ajax({
        type: 'POST',
        url: "/getAtividade1",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
        }, success: function (data, textStatus, jqXHR) {
            $("select#idAtividade1").html("");
            $("select#idAtividade1").append('<option value="">Selecione uma opção</option>');
            for (var i = 0; i < data.length; i++) {
                $("select#idAtividade1").append('<option value="' + data[i].ati1_id + '">' + data[i].at1_nome + '</option>');
            }
            $("select#idAtividade1").val(idAtividade1);
        }
    });
}

function getUnidade(idUnidade) {
    $.ajax({
        type: 'POST',
        url: "/getUnidade",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
        }, success: function (data, textStatus, jqXHR) {
            $("select#idUnidade").html("");
            $("select#idUnidade").append('<option value="">Selecione uma opção</option>');
            for (var i = 0; i < data.length; i++) {
                $("select#idUnidade").append('<option value="' + data[i].uni_id + '">' + data[i].uni_nome + '</option>');
            }
            $("select#idUnidade").val(idUnidade);
        }
    });
}