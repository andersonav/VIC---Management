<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\DataTables\Atividade1DataTable;
use App\DataTables\Atividade1DataTablesEditor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Atividade1Controller extends Controller
{
    public function index($idProjeto, $idLote)
    {
        $itensMenu = $this->sidebar(Auth::user()->tip_usu_id);
        return view('user.visualizarAtividade1PorLote', compact('itensMenu', 'idLote', 'idProjeto'));
        // return $dataTable->with('idProjeto', $idProjeto)->with('idLote', $idLote)->render('user.visualizarAtividade1PorLote', compact('itensMenu', 'idLote'));
    }
    public function store(Atividade1DataTablesEditor $editor, Request $request)
    {
        return $editor->process(request());
    }

    public function returnJson(Request $request)
    {
        $getProjetos = DB::select('SELECT projeto.pro_id, lote.lot_id, atividade1.ati1_id, atividade1.ati1_codigo, atividade1.at1_nome,
        (SELECT SUM(ati2_quantidade * ati2_preco_unidade) from atividade2
        WHERE atividade1.ati1_id = atividade2.ati1_id) as valorOrcamento,
        (SELECT SUM(ati2_faturado) from atividade2
        WHERE atividade1.ati1_id = atividade2.ati1_id) as valorFaturado,
        (SELECT ((valorFaturado * 100) / valorOrcamento )) as symbolPercentagem,
        (SELECT CONCAT(FORMAT(valorOrcamento, 2), " €")) as orcamento,
        (SELECT CONCAT(FORMAT(valorFaturado, 2), " €")) as faturado,
        (SELECT CONCAT(FORMAT(symbolPercentagem, 2), " %")) as percentagem
        from atividade1
        INNER JOIN lote ON lote.lot_id = atividade1.lot_id
        INNER JOIN projeto ON projeto.pro_id = lote.pro_id
        WHERE lote.lot_id = ? AND projeto.pro_id = ?', [$request->idProjeto, $request->idLote]);
    
        return DataTables::of($getProjetos)->setRowId('{{$ati1_id}}')->make();
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
