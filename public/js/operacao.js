$("form").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var action = $(this).attr('action');
    var url_atual = window.location.href;
    $.ajax({
        url: action,
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {

        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $(".modal").modal('hide');
            swal(
                'Sucesso!',
                'Operação realizada com sucesso!.',
                'success'
            )
            var refreshIntervalId = setInterval(function () {
                window.location.href = url_atual;
                clearInterval(refreshIntervalId);
            }, 1500);
        }, error: function (errors, textStatus, errorThrown) {
            $('.errors').empty();
            var erros = $.parseJSON(errors.responseText);
            console.log(errors);
            $.each(erros.errors, function (key, value) {
                $(".errors").append('<div class="alert alert-danger" role="alert" id="mensagemErro">' + value + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            });
        },
        complete: function () {

        }
    });
});
