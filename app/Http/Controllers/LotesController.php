<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\DataTables\LotesDataTable;
use App\DataTables\LotesDataTablesEditor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Projeto;
use App\Lote;
class LotesController extends Controller
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

    public function getLotes()
    {
        $lotes = Lote::get();
        return response()->json($lotes);
    }

    public function index(LotesDataTable $dataTable, $idProjeto)
    {
        $itensMenu = $this->sidebar(Auth::user()->tip_usu_id);
        // return $dataTable->with('idProjeto', $idProjeto)->render('user.visualizarLotesPorProjeto', compact('itensMenu', 'idProjeto'));
        $singleProjeto = Projeto::where('pro_id', $idProjeto)->get();

        return view('user.visualizarLotesPorProjeto', compact('itensMenu', 'idProjeto'));
    }
    public function store(LotesDataTablesEditor $editor, Request $request)
    {
        return $editor->process(request());
    }
    public function returnJson(Request $request)
    {


        $getlotes = DB::select('SELECT projeto.pro_id, lot_id, lote.lot_nome,
        (SELECT SUM(ati2_quantidade * ati2_preco_unidade) from atividade2
        INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
        WHERE atividade1.lot_id = lote.lot_id) as valorOrcamento,
        (SELECT SUM(ati2_faturado) from atividade2
        INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
        WHERE atividade1.lot_id = lote.lot_id) as valorFaturado,
        (SELECT ((valorFaturado * 100) / valorOrcamento )) as symbolPercentagem,
        (SELECT CONCAT(FORMAT(valorOrcamento, 2), " €")) as orcamento,
        (SELECT CONCAT(FORMAT(valorFaturado, 2), " €")) as faturado,
        (SELECT CONCAT(FORMAT(symbolPercentagem, 2), " %")) as percentagem
        from lote
        INNER JOIN projeto ON projeto.pro_id = lote.pro_id
        WHERE projeto.pro_id = ?', [$request->idProjeto]);

        return DataTables::of($getlotes)->setRowId('{{$lot_id}}')
            ->addColumn('detalhes', '<a class="aVer" style="cursor: pointer;" title="Ver" href="{{route("atividade1PorLote", ["idProjeto" => $pro_id, "idLote" => $lot_id])}}"><i class="fas fa-eye"></i></a>')
            ->rawColumns(['detalhes', 'action'])
            ->make(true);
    }


    public function sidebar($idTipoUsuario)
    {
        $itensMenu = DB::select('SELECT 
        menu.men_id, menu.men_nome, menu.men_icone,
        menu.men_rota,
        tipo_usuario.tip_usu_attr,
        CONCAT(lower(menu.men_nome), menu.men_id) as attrId,
        (SELECT GROUP_CONCAT(sub_menu.sub_men_id SEPARATOR ", ") FROM sub_menu_tipo_usuario INNER JOIN sub_menu ON sub_menu.sub_men_id = sub_menu_tipo_usuario.sub_men_id WHERE menu.men_id = sub_menu_tipo_usuario.men_id AND sub_menu_tipo_usuario.tip_usu_id = ?) as idsSubMenus,
        (SELECT GROUP_CONCAT(sub_menu.sub_men_nome SEPARATOR ", ") FROM sub_menu_tipo_usuario INNER JOIN sub_menu ON sub_menu.sub_men_id = sub_menu_tipo_usuario.sub_men_id WHERE menu.men_id = sub_menu_tipo_usuario.men_id AND sub_menu_tipo_usuario.tip_usu_id = ?) as nomesSubMenus,
        (SELECT GROUP_CONCAT(sub_menu.sub_men_rota SEPARATOR ", ") FROM sub_menu_tipo_usuario INNER JOIN sub_menu ON sub_menu.sub_men_id = sub_menu_tipo_usuario.sub_men_id WHERE menu.men_id = sub_menu_tipo_usuario.men_id AND sub_menu_tipo_usuario.tip_usu_id = ?) as rotasSubMenus
        from menu_tipo_usuario
        INNER JOIN menu ON menu_tipo_usuario.men_id = menu.men_id
        INNER JOIN tipo_usuario ON menu_tipo_usuario.tip_usu_id = tipo_usuario.tip_usu_id
        WHERE menu_tipo_usuario.tip_usu_id = ?', [$idTipoUsuario, $idTipoUsuario, $idTipoUsuario, $idTipoUsuario]);

        return $itensMenu;
    }
}
