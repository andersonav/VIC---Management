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
            <h6 class="m-0 font-weight-bold text-primary">Visualização da Atividade {{$nomeAtividade or ''}}</h6>
        </div>
        <div class="card-body">
            <a href="{{ route($rota) }}" class="btn btn-primary btn-icon-split" style="float: right;" id="">
                <span class="icon text-white-50">
                    <i class="fas fa-chevron-circle-left"></i>
                </span>
                <span class="text">Voltar</span>
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
                            <!-- <th>Ações</th> -->
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
                            <!-- <th>Ações</th> -->
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
                            <!-- <td></td> -->
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" style="text-align: center;">Não há registros</td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>

<script src="{{asset('js/atividades/visualizarAtividades.js')}}"></script>

@endsection