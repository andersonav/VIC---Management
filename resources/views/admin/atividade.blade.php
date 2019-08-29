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
            <input type="hidden" class="form-control" value="{{$idAtividade or ''}}" id="idAtividadeProv" name="idAtividadeProv">
            <h6 class="m-0 font-weight-bold text-primary">Edição da Atividade {{$nomeAtividade or ''}}</h6>
        </div>
        <div class="card-body">
            <a href="javascript:void(0);" class="btn btn-primary btn-icon-split" style="float: right;" id="btnAddAtividade">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Nova Atividade</span>
            </a>
            <div class="table-responsive">
                <div id="btnDatatable"></div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Projeto</th>
                            <th>ID Lote</th>
                            <th>Nome da Atividade</th>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Preço Unidade</th>
                            <th>Quantidade</th>
                            <th>Orçamento</th>
                            <th>Faturado</th>
                            <th>Percentagem </th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID Projeto</th>
                            <th>ID Lote</th>
                            <th>Nome da Atividade</th>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Preço Unidade</th>
                            <th>Quantidade</th>
                            <th>Orçamento</th>
                            <th>Faturado</th>
                            <th>Percentagem </th>
                            <th>Ações</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse($atividade as $atividadeUnica)
                        <tr>
                            <td>{{$atividadeUnica->pro_id}}</td>
                            <td>{{$atividadeUnica->lot_id}}</td>
                            <td>{{$atividadeUnica->at1_nome}}</td>
                            <td>{{$atividadeUnica->ati2_codigo}}</td>
                            <td>{{$atividadeUnica->ati2_descricao}}</td>
                            <td>{{$atividadeUnica->ati2_preco_unidade}}</td>
                            <td>{{$atividadeUnica->ati2_quantidade}}</td>
                            <td>{{$atividadeUnica->orcamento or '-'}}</td>
                            <td>{{$atividadeUnica->faturado or '-'}}</td>
                            <td>{{$atividadeUnica->percentagem or '-'}}</td>
                            <td><a class="aEdit" style="cursor: pointer;" title="Editar" onclick="editarAtividadeUnica({{$atividadeUnica->ati2_id}}, {{$atividadeUnica->uni_id}}, {{$atividadeUnica->ati1_id}}, '{{$atividadeUnica->ati2_codigo}}', '{{$atividadeUnica->ati2_descricao}}', '{{$atividadeUnica->ati2_preco_unidade}}', '{{$atividadeUnica->ati2_quantidade}}', '{{$atividadeUnica->valorFaturado}}')"><i class="fas fa-edit fa-sm"></i></a>&nbsp;&nbsp;&nbsp;<a class="aEdit" style="cursor: pointer;" title="Deletar" onclick="deletarAtividade({{$atividadeUnica->ati2_id}})"><i class="fas fa-trash fa-sm"></i></a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" style="text-align: center;">Não há registros</td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>

<div class="modal fade" id="editarAtividadeUnica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="logout-form" action="{{ route('editarAtividade2') }}" method="POST" style="">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Atividade 2</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errors">

                    </div>
                    <input type="hidden" class="form-control" value="" id="idAtividade" name="idAtividade">
                    <div class="form-group">
                        <label for="">Código</label>
                        <input type="text" class="form-control" value="" id="codigo" placeholder="Código" name="codigo">
                    </div>
                    <div class="form-group">
                        <label for="">Preço Unidade</label>
                        <input type="text" class="form-control" value="" id="precoUnidade" placeholder="Preço Unidade" name="precoUnidade">
                    </div>
                    <div class="form-group">
                        <label for="">Quantidade</label>
                        <input type="text" class="form-control" value="" id="quantidade" placeholder="Quantidade" name="quantidade">
                    </div>
                    <div class="form-group">
                        <label for="idAtividade1">Atividade 1</label>
                        <select class="form-control" id="idAtividade1" name="idAtividade1">
                            <option value="">Selecione uma opção</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idUnidade">Unidade</label>
                        <select class="form-control" id="idUnidade" name="idUnidade">
                            <option value="">Selecione uma opção</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Faturado</label>
                        <input type="text" class="form-control" value="" id="faturado" placeholder="Faturado" name="faturado">
                    </div>
                    <div class="form-group">
                        <label for="descricaoAtividade">Descrição</label>
                        <textarea class="form-control" id="descricaoAtividade" name="descricaoAtividade" rows="5"></textarea>
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

<div class="modal fade" id="addAtividadeUnica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="logout-form" action="{{ route('addAtividade2') }}" method="POST" style="">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Atividade</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errors">

                    </div>
                    <input type="hidden" class="form-control" value="" id="idAtividade" name="idAtividade">
                    <div class="form-group">
                        <label for="">Código</label>
                        <input type="text" class="form-control" value="" id="codigo" placeholder="Código" name="codigo">
                    </div>
                    <div class="form-group">
                        <label for="">Preço Unidade</label>
                        <input type="text" class="form-control" value="" id="precoUnidade" placeholder="Preço Unidade" name="precoUnidade">
                    </div>
                    <div class="form-group">
                        <label for="">Quantidade</label>
                        <input type="text" class="form-control" value="" id="quantidade" placeholder="Quantidade" name="quantidade">
                    </div>
                    <div class="form-group">
                        <label for="idAtividade1">Atividade 1</label>
                        <select class="form-control" id="idAtividade1" name="idAtividade1">
                            <option value="">Selecione uma opção</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idUnidade">Unidade</label>
                        <select class="form-control" id="idUnidade" name="idUnidade">
                            <option value="">Selecione uma opção</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Faturado</label>
                        <input type="text" class="form-control" value="" id="faturado" placeholder="Faturado" name="faturado">
                    </div>
                    <div class="form-group">
                        <label for="descricaoAtividade">Descrição</label>
                        <textarea class="form-control" id="descricaoAtividade" name="descricaoAtividade" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Adicionar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{asset('js/operacao.js')}}"></script>
<script src="{{asset('js/atividades/atividadeUnicaAdm.js')}}"></script>

@endsection