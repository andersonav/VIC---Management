<?php

namespace App\DataTables;

use App\Projeto;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class ProjetosDataTable extends DataTable
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
            ->setRowId('pro_id')
            ->addColumn('orcamento', function ($projeto) {
                $newQuery = DB::select('SELECT (SELECT SUM(ati2_quantidade * ati2_preco_unidade) from atividade2
                INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
                INNER JOIN lote ON atividade1.lot_id = lote.lot_id
                WHERE pro.pro_id = lote.pro_id) as valorOrcamento,
                (SELECT SUM(ati2_faturado) from atividade2
                INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
                INNER JOIN lote ON atividade1.lot_id = lote.lot_id
                WHERE pro.pro_id = lote.pro_id) as valorFaturado,
                (SELECT ((valorFaturado * 100) / valorOrcamento )) as symbolPercentagem,
                (SELECT CONCAT(FORMAT(valorOrcamento, 2), " €")) as orcamento,
                (SELECT CONCAT(FORMAT(valorFaturado, 2), " €")) as faturado,
                (SELECT CONCAT(FORMAT(symbolPercentagem, 2), " %")) as percentagem
                from projeto pro WHERE pro.pro_id = ?', [$projeto->pro_id]);

                return $newQuery[0]->orcamento;
            })
            ->addColumn('faturado', function ($projeto) {
                $newQuery = DB::select('SELECT (SELECT SUM(ati2_quantidade * ati2_preco_unidade) from atividade2
                INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
                INNER JOIN lote ON atividade1.lot_id = lote.lot_id
                WHERE pro.pro_id = lote.pro_id) as valorOrcamento,
                (SELECT SUM(ati2_faturado) from atividade2
                INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
                INNER JOIN lote ON atividade1.lot_id = lote.lot_id
                WHERE pro.pro_id = lote.pro_id) as valorFaturado,
                (SELECT ((valorFaturado * 100) / valorOrcamento )) as symbolPercentagem,
                (SELECT CONCAT(FORMAT(valorOrcamento, 2), " €")) as orcamento,
                (SELECT CONCAT(FORMAT(valorFaturado, 2), " €")) as faturado,
                (SELECT CONCAT(FORMAT(symbolPercentagem, 2), " %")) as percentagem
                from projeto pro WHERE pro.pro_id = ?', [$projeto->pro_id]);

                return $newQuery[0]->faturado;
            })
            ->addColumn('percentagem', function ($projeto) {

                $newQuery = DB::select('SELECT (SELECT SUM(ati2_quantidade * ati2_preco_unidade) from atividade2
                INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
                INNER JOIN lote ON atividade1.lot_id = lote.lot_id
                WHERE pro.pro_id = lote.pro_id) as valorOrcamento,
                (SELECT SUM(ati2_faturado) from atividade2
                INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
                INNER JOIN lote ON atividade1.lot_id = lote.lot_id
                WHERE pro.pro_id = lote.pro_id) as valorFaturado,
                (SELECT ((valorFaturado * 100) / valorOrcamento )) as symbolPercentagem,
                (SELECT CONCAT(FORMAT(valorOrcamento, 2), " €")) as orcamento,
                (SELECT CONCAT(FORMAT(valorFaturado, 2), " €")) as faturado,
                (SELECT CONCAT(FORMAT(symbolPercentagem, 2), " %")) as percentagem
                from projeto pro WHERE pro.pro_id = ?', [$projeto->pro_id]);

                return $newQuery[0]->percentagem;
            })
            ->addColumn('detalhes', '<a class="aVer" style="cursor: pointer;" title="Ver" href="{{route("visualizarProjetoUnico", ["id" => $pro_id])}}">Ver</a>')
            ->rawColumns(['detalhes', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Projeto $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Projeto $model)
    {

        $getProjetos = DB::select('SELECT pro.pro_id, pro.pro_nome,
        (SELECT SUM(ati2_quantidade * ati2_preco_unidade) from atividade2
        INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
        INNER JOIN lote ON atividade1.lot_id = lote.lot_id
        WHERE pro.pro_id = lote.pro_id) as valorOrcamento,
        (SELECT SUM(ati2_faturado) from atividade2
        INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
        INNER JOIN lote ON atividade1.lot_id = lote.lot_id
        WHERE pro.pro_id = lote.pro_id) as valorFaturado,
        (SELECT ((valorFaturado * 100) / valorOrcamento )) as symbolPercentagem,
        (SELECT CONCAT(FORMAT(valorOrcamento, 2), " €")) as orcamento,
        (SELECT CONCAT(FORMAT(valorFaturado, 2), " €")) as faturado,
        (SELECT CONCAT(FORMAT(symbolPercentagem, 2), " %")) as percentagem
        from projeto pro');

        return $model->newQuery()->select('projeto.pro_id', 'pro_nome', 'lote.lot_id')->leftJoin('lote', 'lote.pro_id', 'projeto.pro_id');
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
            'pro_nome',
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
        return 'Projetos_' . date('YmdHis');
    }
}
