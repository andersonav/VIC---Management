<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function visualizarProjetos()
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
        WHERE menu_tipo_usuario.tip_usu_id = ?', [Auth::user()->tip_usu_id, Auth::user()->tip_usu_id, Auth::user()->tip_usu_id, Auth::user()->tip_usu_id]);

        $getProjetos = DB::select('SELECT pro.pro_id, pro.pro_nome,
        (SELECT SUM(ati2_quantidade * ati2_preco_unidade) from atividade2
        INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
        INNER JOIN lote ON atividade1.lot_id = lote.lot_id
        WHERE pro.pro_id = lote.pro_id) as valorOrcamento,
        (SELECT SUM(ati2_faturado) from atividade2
        INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
        INNER JOIN lote ON atividade1.lot_id = lote.lot_id
        WHERE pro.pro_id = lote.pro_id) as valorFaturado,
        (SELECT (valorOrcamento - valorFaturado) as sub ) as symbolPercentagem,
        (SELECT CONCAT(valorOrcamento, " €")) as orcamento,
        (SELECT CONCAT(valorFaturado, " €")) as faturado,
        (SELECT CONCAT(symbolPercentagem, " %")) as percentagem
        from projeto pro');

        return view('user.visualizarProjetos', compact('itensMenu', 'getProjetos'));
    }

    public function visualizarLotes()
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
        WHERE menu_tipo_usuario.tip_usu_id = ?', [Auth::user()->tip_usu_id, Auth::user()->tip_usu_id, Auth::user()->tip_usu_id, Auth::user()->tip_usu_id]);

        $getProjetos = DB::select('SELECT projeto.pro_id, lot_id, lote.lot_nome,
        (SELECT SUM(ati2_quantidade * ati2_preco_unidade) from atividade2
        INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
        WHERE atividade1.lot_id = lote.lot_id) as valorOrcamento,
        (SELECT SUM(ati2_faturado) from atividade2
        INNER JOIN atividade1 ON atividade2.ati1_id = atividade1.ati1_id
        WHERE atividade1.lot_id = lote.lot_id) as valorFaturado,
        (SELECT (valorOrcamento - valorFaturado) as sub ) as symbolPercentagem,
        (SELECT CONCAT(valorOrcamento, " €")) as orcamento,
        (SELECT CONCAT(valorFaturado, " €")) as faturado,
        (SELECT CONCAT(symbolPercentagem, " %")) as percentagem
        from lote
        INNER JOIN projeto ON projeto.pro_id = lote.pro_id');

        return view('user.visualizarLotes', compact('itensMenu', 'getProjetos'));
    }

    public function visualizarAtividades()
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
        WHERE menu_tipo_usuario.tip_usu_id = ?', [Auth::user()->tip_usu_id, Auth::user()->tip_usu_id, Auth::user()->tip_usu_id, Auth::user()->tip_usu_id]);


        $getProjetos = DB::select('SELECT projeto.pro_id, lote.lot_id, atividade1.at1_nome, atividade1.ati1_id,
        (SELECT SUM(ati2_quantidade * ati2_preco_unidade) from atividade2
        WHERE atividade1.ati1_id = atividade2.ati1_id) as valorOrcamento,
        (SELECT SUM(ati2_faturado) from atividade2
        WHERE atividade1.ati1_id = atividade2.ati1_id) as valorFaturado,
        (SELECT (valorOrcamento - valorFaturado) as sub ) as symbolPercentagem,
        (SELECT CONCAT(valorOrcamento, " €")) as orcamento,
        (SELECT CONCAT(valorFaturado, " €")) as faturado,
        (SELECT CONCAT(symbolPercentagem, " %")) as percentagem
        from atividade1
        INNER JOIN lote ON lote.lot_id = atividade1.lot_id
        INNER JOIN projeto ON projeto.pro_id = lote.pro_id');

        return view('user.visualizarAtividades', compact('itensMenu', 'getProjetos'));
    }

    public function atividadeUnica($id)
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
        WHERE menu_tipo_usuario.tip_usu_id = ?', [Auth::user()->tip_usu_id, Auth::user()->tip_usu_id, Auth::user()->tip_usu_id, Auth::user()->tip_usu_id]);




        $atividade = DB::select('SELECT projeto.pro_id, lote.lot_id, atividade1.at1_nome,
        atividade2.ati2_codigo, atividade2.ati2_descricao, atividade2.ati2_preco_unidade,
        atividade2.ati2_quantidade,
        (ati2_quantidade * ati2_preco_unidade)  as valorOrcamento,
        atividade2.ati2_faturado as valorFaturado,
        (SELECT (valorOrcamento - valorFaturado) as sub ) as symbolPercentagem,
        (SELECT CONCAT(valorOrcamento, " €")) as orcamento,
        (SELECT CONCAT(valorFaturado, " €")) as faturado,
        (SELECT CONCAT(symbolPercentagem, " %")) as percentagem
        from atividade2
        INNER JOIN atividade1 ON atividade1.ati1_id = atividade2.ati1_id
        INNER JOIN lote ON lote.lot_id = atividade1.lot_id
        INNER JOIN projeto ON projeto.pro_id = lote.pro_id
        WHERE atividade1.ati1_id = ?', [$id]);

        if (isset($atividade[0]->at1_nome)) {
            $nomeAtividade = $atividade[0]->at1_nome;
        }
        return view('user.atividade', compact('itensMenu', 'atividade', 'nomeAtividade'));
    }
}
