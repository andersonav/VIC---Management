<?php

namespace App\DataTables;

use App\Atividade1;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class Atividade1DataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->setRowId('{{$ati1_id}}')
            ->addColumn('orcamento', function ($atividade) {

                return $atividade->ati1_id;
            })
            ->addColumn('faturado', function ($atividade) {
                return $atividade->ati1_id;
            })
            ->addColumn('percentagem', function ($atividade) {
                return $atividade->ati1_id;
            });
        // ->addColumn('detalhes', '<a class="aVer" style="cursor: pointer;" title="Ver" href="{{route("atividade2PorAtividade1", ["idProjeto" => $pro_id, "idLote" => $lot_id, ""])}}"><i class="fas fa-eye"></i></a>')
        // ->rawColumns(['detalhes', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Atividade1 $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Atividade1 $model)
    {

        return $model->newQuery()->select('projeto.pro_id', 'lote.lot_id', 'ati1_id', 'ati1_codigo', 'at1_nome')
            ->join('lote', 'lote.lot_id', 'atividade1.lot_id')
            ->join('projeto', 'projeto.pro_id', 'lote.pro_id')
            ->where('atividade1.lot_id', $this->idLote);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'dom' => 'Bfrtip',
                'order' => [1, 'asc'],
                'select' => [
                    'style' => 'os',
                    'selector' => 'td:not(:first-child)',
                ],
                'buttons' => [
                    ['extend' => 'create', 'editor' => 'editor'],
                    ['extend' => 'edit', 'editor' => 'editor'],
                    ['extend' => 'remove', 'editor' => 'editor'],
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'data' => null,
                'defaultContent' => '',
                'className' => 'details-control',
                'title' => '',
                'orderable' => false,
                'width' => '10%'
            ],
            'pro_id',
            'lot_id',
            'ati1_codigo',
            'at1_nome',
            'orcamento',
            'faturado',
            'percentagem'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Atividade1_' . date('YmdHis');
    }
}
