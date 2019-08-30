function editarProjeto(idProjeto, nomeProjeto) {
    $("#nomeProjeto").val(nomeProjeto);
    $("#idProjeto").val(idProjeto);
    $("#editarProjeto").modal('show');
}


function deletarProjeto(idProjeto) {
    var url_atual = window.location.href;
    swal({
        title: 'Você tem certeza que deseja excluir esse projeto?',
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
                url: "/deletarProjeto",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: idProjeto
                }, success: function (data, textStatus, jqXHR) {
                    swal(
                        'Deletado!',
                        'O projeto foi deletado!.',
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

function openModalAddProjeto() {
    $("#addProjeto").modal('show');
}