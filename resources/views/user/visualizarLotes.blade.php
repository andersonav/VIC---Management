@extends('layouts.painel')

@section('content')
<!-- End of Topbar -->
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Prata (1)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">€140.000,00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hotel fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Prata (2)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">€140.000,00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hotel fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Prata (3)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">€140.000,00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hotel fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Prata (4)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">€140.000,00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hotel fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Visualização de Lotes</h6>
        </div>
        <div class="card-body">
            @if(auth()->user()->tip_usu_id == 1)
            <a href="javascript:void(0);" class="btn btn-success btn-icon-split" style="float: right;" id="btnAddLote" onclick="openModalAddLote('');">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Novo Lote</span>
            </a>
            @endif
            <div class="table-responsive">
                <div id="btnDatatable"></div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Projeto</th>
                            <th>ID Lote</th>
                            <th>Nome do Lote</th>
                            <th>Orçamento</th>
                            <th>Faturado</th>
                            <th>Percentagem </th>
                            <th>Ver</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID Projeto</th>
                            <th>ID Lote</th>
                            <th>Nome do Lote</th>
                            <th>Orçamento</th>
                            <th>Faturado</th>
                            <th>Percentagem</th>
                            <th>Ver</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse($getProjetos as $projeto)
                        <tr>
                            <td>{{$projeto->pro_id}}</td>
                            <td>{{$projeto->lot_id}}</td>
                            <td>{{$projeto->lot_nome}}</td>
                            <td>{{$projeto->orcamento or '-'}}</td>
                            <td>{{$projeto->faturado or '-'}}</td>
                            <td>{{$projeto->percentagem or '-'}}</td>
                            <td>
                                <a class="aVer" style="cursor: pointer;" title="Ver" href="{{ route('visualizarLoteProjetoUnico', ['idProjeto' => $projeto->pro_id, 'idLote' => $projeto->lot_id])}}"><i class="fas fa-eye fa-sm"></i></a>&nbsp;&nbsp;
                                @if(auth()->user()->tip_usu_id != 3)
                                <a class="aEdit" style="cursor: pointer;" title="Editar" onclick="editarLote({{$projeto->pro_id}}, {{$projeto->lot_id}}, '{{$projeto->lot_nome}}')"><i class="fas fa-edit fa-sm"></i></a>&nbsp;&nbsp;
                                @endif
                                @if(auth()->user()->tip_usu_id == 1)
                                <a class="aDel" style="cursor: pointer;" title="Deletar" onclick="deletarLote({{$projeto->lot_id}})"><i class="fas fa-trash fa-sm"></i></a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center;">Não há registros</td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>

@if(auth()->user()->tip_usu_id != 3)
<div class="modal fade" id="editarLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="logout-form" action="{{ route('editarLote') }}" method="POST" style="">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Lote</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errors">

                    </div>
                    <input type="hidden" class="form-control" value="" id="idLote" name="idLote">
                    <div class="form-group">
                        <input type="text" class="form-control" value="" id="nomeLote" placeholder="Nome Lote" name="nomeLote">
                    </div>
                    <div class="form-group">
                        <label for="idProjeto">Projeto</label>
                        <select class="form-control" id="idProjeto" name="idProjeto">
                            <option value="">Selecione uma opção</option>
                        </select>
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


<div class="modal fade" id="addLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="user" method="POST" action="{{ route('cadastrarLote') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Lote</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errors">

                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="" id="nomeLote" placeholder="Nome Lote" name="nomeLote">
                    </div>
                    <div class="form-group">
                        <label for="idProjeto">Projeto</label>
                        <select class="form-control" id="idProjeto" name="idProjeto">
                            <option value="">Selecione uma opção</option>

                        </select>
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
<script src="{{asset('js/operacao.js')}}"></script>
<script src="{{asset('js/lotes/editarLotes.js')}}"></script>

@endif

<script src="{{asset('js/lotes/visualizarLotes.js')}}"></script>

@endsection