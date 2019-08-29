<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Projeto;
use App\Atividade1;
use App\Lote;

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
        (SELECT ((valorFaturado * 100) / valorOrcamento )) as symbolPercentagem,
        (SELECT CONCAT(FORMAT(valorOrcamento, 2), " €")) as orcamento,
        (SELECT CONCAT(FORMAT(valorFaturado, 2), " €")) as faturado,
        (SELECT CONCAT(FORMAT(symbolPercentagem, 2), " %")) as percentagem
        from projeto pro');

        return view('user.visualizarProjetos', compact('itensMenu', 'getProjetos'));
    }

    public function visualizarProjetoUnico($id)
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
        $singleProjeto = Projeto::where('pro_id', $id)->get();

        $getProjetos = DB::select('SELECT projeto.pro_id, lot_id, lote.lot_nome,
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
        WHERE projeto.pro_id = ?', [$id]);
        if (isset($singleProjeto[0]->pro_nome)) {
            $nomeProjeto = '- ' . $singleProjeto[0]->pro_nome;
        }
        $rota = "visualizarProjetos";
        return view('user.visualizarProjetoUnico', compact('itensMenu', 'getProjetos', 'nomeProjeto', 'rota'));
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
        (SELECT ((valorFaturado * 100) / valorOrcamento )) as symbolPercentagem,
        (SELECT CONCAT(FORMAT(valorOrcamento, 2), " €")) as orcamento,
        (SELECT CONCAT(FORMAT(valorFaturado, 2), " €")) as faturado,
        (SELECT CONCAT(FORMAT(symbolPercentagem, 2), " %")) as percentagem
        from lote
        INNER JOIN projeto ON projeto.pro_id = lote.pro_id');

        return view('user.visualizarLotes', compact('itensMenu', 'getProjetos'));
    }

    public function visualizarLoteUnico($id)
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

        $singleLote = Lote::where('lot_id', $id)->get();
        $getProjetos = DB::select('SELECT projeto.pro_id, lote.lot_id, atividade1.at1_nome, atividade1.ati1_id,
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
        WHERE lote.lot_id = ?', [$id]);

        if (isset($singleLote[0]->lot_nome)) {
            $nomeLote = '- ' . $singleLote[0]->lot_nome;
        }
        $rota = 'visualizarLotes';
        return view('user.visualizarLoteUnico', compact('itensMenu', 'getProjetos', 'nomeLote', 'rota'));
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
        (SELECT ((valorFaturado * 100) / valorOrcamento )) as symbolPercentagem,
        (SELECT CONCAT(FORMAT(valorOrcamento, 2), " €")) as orcamento,
        (SELECT CONCAT(FORMAT(valorFaturado, 2), " €")) as faturado,
        (SELECT CONCAT(FORMAT(symbolPercentagem, 2), " %")) as percentagem
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



        $singleAtividade = Atividade1::where('ati1_id', $id)->get();

        $atividade = DB::select('SELECT projeto.pro_id, lote.lot_id, atividade1.at1_nome,
        atividade2.ati2_codigo, atividade2.ati2_descricao, atividade2.ati2_preco_unidade,
        atividade2.ati2_quantidade,
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
        WHERE atividade1.ati1_id = ?', [$id]);

        if (isset($singleAtividade[0]->at1_nome)) {
            $nomeAtividade = $singleAtividade[0]->at1_nome;
        }
        $rota = 'visualizarAtividades';
        return view('user.atividade', compact('itensMenu', 'atividade', 'nomeAtividade', 'rota'));
    }
}
