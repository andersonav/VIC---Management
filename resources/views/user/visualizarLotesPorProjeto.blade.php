@extends('layouts.painel')
@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Visualização de Lotes</h6>
    </div>
    <div class="card-body">
        <a href="JavaScript: window.history.back();" class="btn btn-primary btn-icon-split" style="float: right;" id="">
            <span class="icon text-white-50">
                <i class="fas fa-chevron-circle-left"></i>
            </span>
            <span class="text">Voltar</span>
        </a>
        <div class="table-responsive">
            <table id="lotes" class="table dataTable no-footer" style="width:100%">

            </table>
        </div>
    </div>
</div>
<script>
    $(function() {

        var dataProjeto = getProjetos();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var editor = new $.fn.dataTable.Editor({
            "ajax": {
                "url": "/projetos/lote/store",
                "type": "POST",
                "data": {
                    "pro_id": "{{$idProjeto}}"
                },
            },
            table: "#lotes",
            fields: [{
                label: "Projeto:",
                name: "pro_id",
                type: "select",
                placeholder: "Select a projeto",
                options: dataProjeto,
                def: "{{$idProjeto}}"
            }, {
                label: "Nome do Lote:",
                name: "lot_nome"
            }]
        });

        var tabela = $('#lotes').DataTable({
            dom: 'Bfrtip',
            order: [1, 'asc'],
            "ajax": {
                "url": "/projetos/getLotes",
                "type": "POST",
                "data": {
                    "idProjeto": "{{$idProjeto}}"
                },
            },
            columns: [{
                    className: 'select-checkbox',
                    orderable: false,
                    defaultContent: '',
                    width: '10%'
                },
                {
                    data: 'pro_id',
                    title: 'Projeto ID',
                    defaultContent: '',
                },
                {
                    data: 'lot_id',
                    title: 'Lote ID',
                    defaultContent: '',
                },
                {
                    data: 'lot_nome',
                    title: 'Nome Lote',
                    defaultContent: '',
                }, {
                    data: 'orcamento',
                    title: 'Orçamento',
                    defaultContent: '',
                }, {
                    data: 'faturado',
                    title: 'Faturado',
                    defaultContent: '',
                }, {
                    data: 'percentagem',
                    title: 'Percentagem',
                    defaultContent: '',
                },
                {
                    data: 'detalhes',
                    title: 'Detalhes',
                    defaultContent: '',
                }
            ],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            buttons: [{
                    extend: 'create',
                    editor: editor
                },
                {
                    extend: 'edit',
                    editor: editor
                },
                {
                    extend: 'remove',
                    editor: editor
                }
            ]
        });


        $('#lotes').on('click', 'tbody td:not(:first-child)', function(e) {
            editor.inline(this);
        });

    })


    function getProjetos() {
        var json = [];
        $.ajax({
            type: 'POST',
            url: "/getProjetos",
            async: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {},
            success: function(data, textStatus, jqXHR) {
                for (var i = 0; i < data.length; i++) {
                    json[i] = {
                        label: data[i].pro_nome,
                        value: data[i].pro_id
                    }
                }
            }
        });
        return json;
    }
</script>
@endsection