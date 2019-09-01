@extends('layouts.painel')
@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Visualização de Projetos</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            {{$dataTable->table(['id' => 'projetos'])}}
        </div>
    </div>
</div>
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var editor = new $.fn.dataTable.Editor({
            ajax: "/projetos/store",
            table: "#projetos",
            fields: [{
                label: "Nome do Projeto:",
                name: "pro_nome"
            }]
        });
        $('#projetos').on('click', 'tbody td:not(:first-child)', function(e) {
            editor.inline(this);
        });

        {{$dataTable->generateScripts()}}
    })
</script>
@endsection