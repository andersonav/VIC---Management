<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.4/css/select.bootstrap.min.css">
<link rel="stylesheet" href="css/dataTables.editor.css">
<link rel="stylesheet" href="css/editor.bootstrap.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- End of Topbar -->
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{$dataTable->table(['id' => 'projetos'])}}
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>

@if(auth()->user()->tip_usu_id != 3)
<div class="modal fade" id="editarProjeto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="logout-form" action="{{ route('editarProjeto') }}" method="POST" style="">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Projeto</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errors">

                    </div>
                    <input type="hidden" class="form-control" value="" id="idProjeto" name="idProjeto">
                    <div class="form-group">
                        <input type="text" class="form-control" value="" id="nomeProjeto" placeholder="Nome Projeto" name="nomeProjeto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Editar</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="addProjeto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="user" method="POST" action="{{ route('cadastrarProjeto') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Projeto</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errors">

                    </div>
                    <div class="form-group">
                        <label for="">Nome do projeto</label>
                        <input type="text" class="form-control" value="" id="nomeProjeto" aria-describedby="nomeProjeto" placeholder="Nome Projeto" name="nomeProjeto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Cadastrar</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.4/js/dataTables.select.min.js"></script>
<script src="{{asset('js/dataTables.editor.js')}}"></script>

<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.bootstrap.min.js"></script>

<script src="{{asset('js/editor.bootstrap.min.js')}}"></script>
<script src="{{asset('js/operacao.js')}}"></script>
<script src="{{asset('js/projetos/editarProjetos.js')}}"></script>
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
@endif