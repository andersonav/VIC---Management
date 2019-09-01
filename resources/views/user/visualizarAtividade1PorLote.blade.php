@extends('layouts.painel')
@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Visualização de Atividade 1</h6>
    </div>
    <div class="card-body">
        <a href="JavaScript: window.history.back();" class="btn btn-primary btn-icon-split" style="float: right;" id="">
            <span class="icon text-white-50">
                <i class="fas fa-chevron-circle-left"></i>
            </span>
            <span class="text">Voltar</span>
        </a>

        <div class="table-responsive">
            <table id="atividade1" class="table dataTable no-footer" style="width:100%">

            </table>
        </div>
    </div>
</div>
<script>
    var atividades1 = getAtividades();
    var unidades = getUnidade();
    var lotes = getLotes();

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var editor = new $.fn.dataTable.Editor({
            "ajax": {
                "url": "/projetos/lote/atividade1/store",
                "type": "POST",
                "data": {
                    "lot_id": "{{$idLote}}"
                },
            },
            table: "#atividade1",
            fields: [{
                    label: "Lote:",
                    name: "lot_id",
                    type: "select",
                    placeholder: "Select a lote",
                    options: lotes,
                    def: "{{$idLote}}"
                },
                {
                    label: "Nome da Atividade 1:",
                    name: "at1_nome"
                },
                {
                    label: "Código da Atividade 1:",
                    name: "ati1_codigo"
                }
            ]

        });


        var tabela = $('#atividade1').DataTable({
            dom: 'Bfrtip',
            order: [1, 'asc'],
            "ajax": {
                "url": "/projetos/lote/atividade1",
                "type": "POST",
                "data": {
                    "idLote": "{{$idLote}}",
                    "idProjeto": "{{$idProjeto}}"
                },
            },
            columns: [{
                    className: 'details-control',
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
                    data: 'ati1_codigo',
                    title: 'Código Atividade 1',
                    defaultContent: '',
                }, {
                    data: 'at1_nome',
                    title: 'Nome Atividade 1',
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
                }
            ],
            select: {
                style: 'os',
                selector: 'td:not(:first-child)'
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

        var detailRows = [];

        $('#atividade1').on('click', 'tbody td:not(:first-child)', function(e) {
            editor.inline(this);
        });


        $('#atividade1').on('click', 'tbody td.details-control', function(e) {
            var tr = $(this).closest('tr');
            var row = tabela.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it

                destroyChild(row);
                tr.removeClass('shown');
                $(this).removeClass('shown');
            } else {
                // Open this row
                createChild(row, 'child-table'); // class is for background colour
                tr.addClass('shown');
                $(this).addClass('shown');

            }
        });

        editor.on('submitSuccess', function() {
            tabela.rows().every(function() {
                if (this.child.isShown()) {
                    updateChild(this);
                }
            });
        });

    });

    function createChild(row) {
        // This is the table we'll convert into a DataTable
        var table = $('<table class="table dataTable no-footer" width="100%"/>');

        // Display it the child row
        row.child(table).show();

        var rowData = row.data();
        var atividade2 = new $.fn.dataTable.Editor({
            ajax: {
                url: '/projetos/lote/atividade1/atividade2/store',
                data: function(d) {
                    d.idAtividade1 = rowData.ati1_id;
                }
            },
            table: table,
            fields: [{
                    label: "Atividade 1:",
                    name: "ati1_id",
                    type: "select",
                    placeholder: "Select a atividade 1",
                    options: atividades1,
                    def: rowData.ati1_id
                }, {
                    label: "Código Atividade 2:",
                    name: "ati2_codigo"
                }, {
                    label: "Descrição Atividade 2:",
                    name: "ati2_descricao"
                }, {
                    label: "Preço Unidade:",
                    name: "ati2_preco_unidade"
                }, {
                    label: "Quantidade:",
                    name: "ati2_quantidade"
                },
                {
                    label: "Faturado:",
                    name: "ati2_faturado"
                }, {
                    label: "Unidade:",
                    name: "uni_id",
                    type: "select",
                    placeholder: "Select a unidade",
                    options: unidades,
                }
            ]
        });
        var usersTable = table.DataTable({
            dom: 'Bfrtip',
            pageLength: 5,
            ajax: {
                url: '/projetos/lote/atividade1/getAtividade2',
                type: 'POST',
                data: function(d) {
                    d.idAtividade1 = rowData.ati1_id;
                    d.idLote = "{{$idLote}}";
                    d.idProjeto = "{{$idProjeto}}";
                }
            },
            columns: [{
                    title: 'ID Projeto',
                    data: 'pro_id',
                    defaultContent: '',
                },
                {
                    title: 'ID Lote',
                    data: 'lot_id',
                    defaultContent: '',
                },
                {
                    title: 'Código Atividade 2',
                    data: 'ati2_codigo',
                    defaultContent: '',
                },
                {
                    title: 'Nome Atividade 1',
                    data: 'at1_nome',
                    defaultContent: '',
                },
                {
                    title: 'Descrição Atividade 2',
                    data: 'ati2_descricao',
                    defaultContent: '',
                }, {
                    title: 'Preço Unidade',
                    data: 'ati2_preco_unidade',
                    defaultContent: '',
                }, {
                    title: 'Quantidade',
                    data: 'ati2_quantidade',
                    defaultContent: '',
                }, {
                    title: 'Faturado',
                    data: 'ati2_faturado',
                    defaultContent: '',
                }, {
                    title: 'Unidade',
                    data: 'uni_nome',
                    defaultContent: '',
                }
            ],
            select: true,
            buttons: [{
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
        });

        atividade2.on('submitSuccess', function(e, json, data, action) {
            row.ajax.reload(function() {
                $(row.cell(row.id(true), 0).node()).click();
            });
        });
    }

    function destroyChild(row) {
        var table = $("#atividade1", row.child());
        table.detach();
        table.DataTable().destroy();

        // And then hide the row
        row.child.hide();
    }

    function updateChild(row) {
        $('#atividade1', row.child()).DataTable().ajax.reload();
    }

    function getAtividades() {
        var json = [];
        $.ajax({
            type: 'POST',
            url: "/getAtividade1",
            async: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {},
            success: function(data, textStatus, jqXHR) {
                for (var i = 0; i < data.length; i++) {
                    json[i] = {
                        label: data[i].at1_nome,
                        value: data[i].ati1_id
                    }
                }
            }
        });
        return json;
    }

    function getLotes() {
        var json = [];
        $.ajax({
            type: 'POST',
            url: "/getLotes",
            async: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {},
            success: function(data, textStatus, jqXHR) {
                for (var i = 0; i < data.length; i++) {
                    json[i] = {
                        label: data[i].lot_nome,
                        value: data[i].lot_id
                    }
                }
            }
        });
        return json;
    }

    function getUnidade() {
        var json = [];
        $.ajax({
            type: 'POST',
            url: "/getUnidade",
            async: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {},
            success: function(data, textStatus, jqXHR) {
                for (var i = 0; i < data.length; i++) {
                    json[i] = {
                        label: data[i].uni_nome,
                        value: data[i].uni_id
                    }
                }
            }
        });
        return json;
    }
</script>
@endsection