<?php

namespace App\DataTables;

use App\Lote;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class LotesDataTable extends DataTable
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
            ->setRowId('lot_id')
            ->addColumn('orcamento', function ($projeto) {

                return $projeto->lot_id;
            })
            ->addColumn('faturado', function ($projeto) {


                return $projeto->lot_id;
            })
            ->addColumn('percentagem', function ($projeto) {


                return $projeto->lot_id;
            })
            ->addColumn('detalhes', '<a class="aVer" style="cursor: pointer;" title="Ver" href="{{route("atividade1PorLote", ["idProjeto" => $pro_id, "idLote" => $lot_id])}}"><i class="fas fa-eye"></i></a>')
            ->rawColumns(['detalhes', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Lote $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Lote $model)
    {

        return $model->newQuery()->select('pro_id', 'lote.lot_id', 'lot_nome')->where('lote.pro_id', $this->idProjeto);
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
                    'selector' => 'td:first-child',
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
                'className' => 'select-checkbox',
                'title' => '',
                'orderable' => false,
                'searchable' => false
            ],
            'pro_id',
            'lot_id',
            'lot_nome',
            'orcamento',
            'faturado',
            'percentagem',
            'detalhes'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Lotes_' . date('YmdHis');
    }
}
