<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\DataTables\Atividade2DataTablesEditor;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
class Atividade2Controller extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                Redirect::to('home')->send();
            }
            return $next($request);
        });
    }

    public function store(Atividade2DataTablesEditor $editor, Request $request)
    {
        return $editor->process(request());
    }

    public function returnJson(Request $request)
    {
        $getProjetos = DB::select('SELECT projeto.pro_id, lote.lot_id, atividade1.ati1_id, atividade1.at1_nome,
        atividade2.ati2_id, atividade2.ati2_codigo, atividade2.ati2_descricao, atividade2.ati2_preco_unidade,
        atividade2.ati2_quantidade, atividade2.ati2_faturado,  atividade2.uni_id, unidade.uni_nome,
        (ati2_quantidade * ati2_preco_unidade)  as valorOrcamento,
        atividade2.ati2_faturado as valorFaturado,
        (SELECT ((valorFaturado * 100) / valorOrcamento )) as symbolPercentagem,
        (SELECT CONCAT(FORMAT(valorOrcamento, 2), " €")) as orcamento,
        (SELECT CONCAT(FORMAT(valorFaturado, 2), " €")) as faturado,
        (SELECT CONCAT(FORMAT(symbolPercentagem, 2), " %")) as percentagem
        from atividade2
        INNER JOIN atividade1 ON atividade1.ati1_id = atividade2.ati1_id
        INNER JOIN lote ON lote.lot_id = atividade1.lot_id
        INNER JOIN projeto ON projeto.pro_id = lote.pro_id
        INNER JOIN unidade ON unidade.uni_id = atividade2.uni_id
        WHERE atividade1.ati1_id = ? AND lote.lot_id = ? AND projeto.pro_id = ?', [$request->idAtividade1, $request->idLote, $request->idProjeto]);

        return DataTables::of($getProjetos)->setRowId('{{$ati2_id}}')->make();
    }
}
