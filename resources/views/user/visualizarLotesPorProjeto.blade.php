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
    var jsonTest = [];
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
                options: jsonTest,
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
            buttons: getButtons(editor)
        });


        $('#lotes').on('click', 'tbody td:not(:first-child)', function(e) {
            editor.inline(this);
        });

        editor.on('create', function(e, json, data) {
            location.reload();
        });

    })


    function getProjetos() {
        $.ajax({
            type: 'POST',
            url: "/getProjetos",
            async: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {},
            success: function(data, textStatus, jqXHR) {
                preencherArray(data);
            }
        });
    }

    function preencherArray(data) {
        for (var i = 0; i < data.length; i++) {
            jsonTest[i] = {
                label: data[i].pro_nome,
                value: data[i].pro_id
            }
        }
    }
</script>




@if(auth()->user()->tip_usu_id == 3)
<script>
    function getButtons(atividade2) {
        return [{

        }]
    }
</script>
@endif

@if(auth()->user()->tip_usu_id == 2)
<script>
    function getButtons(atividade2) {
        return [{
                extend: 'create',
                editor: atividade2
            },
            {
                extend: 'edit',
                editor: atividade2
            },
            {
                extend: 'remove',
                editor: atividade2
            }
        ]
    }
</script>
@endif

@if(auth()->user()->tip_usu_id == 1)
<script>
    function getButtons(atividade2) {
        return [{
                extend: 'create',
                editor: atividade2
            },
            {
                extend: 'edit',
                editor: atividade2
            },
            {
                extend: 'remove',
                editor: atividade2
            }
        ]
    }
</script>
@endif



@endsection