$(document).ready(function () {
    $("li.nav-item").each(function () {
        $(this).removeClass('active');
    });

    $("a[data-to=lotes2]").trigger('click');
});


function editarLote(idProjeto, idLote, nomeLote) {
    $("#nomeLote").val(nomeLote);
    $("#idLote").val(idLote);
    $("#idProjeto").val(idProjeto);
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
                url: url_atual + "/deletarLote",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: idProjeto
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
