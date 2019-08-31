<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Projeto;
use App\Atividade1;
use App\Atividade2;
use App\Lote;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function visualizarProjetos()
    {
        $itensMenu = $this->sidebar(Auth::user()->tip_usu_id);

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
        $itensMenu = $this->sidebar(Auth::user()->tip_usu_id);

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
            $idProjeto = $singleProjeto[0]->pro_id;
        }
        $rota = "visualizarProjetos";
        return view('user.visualizarProjetoUnico', compact('itensMenu', 'getProjetos', 'nomeProjeto', 'idProjeto', 'rota'));
    }

    public function visualizarProjetoLoteUnico($idProjeto, $idLote)
    {
        $itensMenu = $this->sidebar(Auth::user()->tip_usu_id);
        $singleProjeto = Lote::where('lot_id', $idLote)->where('projeto.pro_id', $idProjeto)
            ->join('projeto', 'projeto.pro_id', 'lote.pro_id')
            ->get();

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
        WHERE lote.lot_id = ? AND projeto.pro_id = ?', [$idProjeto, $idLote]);

        if (isset($singleProjeto[0]->pro_nome)) {
            $nomeProjeto = '- ' . $singleProjeto[0]->pro_nome;
            $nomeLote = '- ' . $singleProjeto[0]->lot_nome;
            $idLote = $singleProjeto[0]->lot_id;
        }
        return view('user.visualizarProjetoLoteUnico', compact('itensMenu', 'getProjetos', 'nomeProjeto', 'nomeLote', 'idLote', 'rota'));
    }

    public function visualizarProjetoLoteAtividadeUnico($idProjeto, $idLote, $idAtividade)
    {
        $itensMenu = $this->sidebar(Auth::user()->tip_usu_id);


        $single = Atividade1::where('atividade1.ati1_id', $idAtividade)->where('projeto.pro_id', $idProjeto)
            ->where('lote.lot_id', $idLote)
            ->join('lote', 'lote.lot_id', 'atividade1.lot_id')
            ->join('projeto', 'projeto.pro_id', 'lote.pro_id')
            ->get();


        $atividade = DB::select('SELECT projeto.pro_id, lote.lot_id, atividade1.ati1_id, atividade1.at1_nome,
        atividade2.ati2_id, atividade2.ati2_codigo, atividade2.ati2_descricao, atividade2.ati2_preco_unidade,
        atividade2.ati2_quantidade,  atividade2.uni_id,
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
        WHERE atividade1.ati1_id = ? AND lote.lot_id = ? AND projeto.pro_id = ?', [$idAtividade, $idLote, $idProjeto]);

        if (isset($single[0]->at1_nome)) {
            $nomeAtividade = '- ' . $single[0]->at1_nome;
            $nomeProjeto = '- ' . $single[0]->pro_nome;
            $nomeLote = '- ' . $single[0]->lot_nome;
            $idAtividade = $single[0]->ati1_id;
        }
        return view('user.visualizarProjetoLoteAtividade', compact('itensMenu', 'atividade', 'nomeAtividade', 'nomeProjeto', 'nomeLote', 'idAtividade'));
    }

    public function visualizarLotes()
    {
        $itensMenu = $this->sidebar(Auth::user()->tip_usu_id);

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

    public function visualizarLoteUnico($idLote, $idProjeto)
    {
        $itensMenu = $this->sidebar(Auth::user()->tip_usu_id);
        $singleProjeto = Lote::where('lot_id', $idLote)->where('projeto.pro_id', $idProjeto)
            ->join('projeto', 'projeto.pro_id', 'lote.pro_id')
            ->get();
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
        WHERE lote.lot_id = ? AND projeto.pro_id = ?', [$idProjeto, $idLote]);

        if (isset($singleProjeto[0]->pro_nome)) {
            $nomeProjeto = '- ' . $singleProjeto[0]->pro_nome;
            $nomeLote = '- ' . $singleProjeto[0]->lot_nome;
            $idLote = $singleProjeto[0]->lot_id;
        }
        return view('user.visualizarLoteUnico', compact('itensMenu', 'getProjetos', 'nomeProjeto', 'nomeLote', 'idLote', 'rota'));
    }

    public function visualizarLoteProjetoAtividadeUnico($idLote, $idProjeto, $idAtividade)
    {
        $itensMenu = $this->sidebar(Auth::user()->tip_usu_id);

        $single = Atividade1::where('atividade1.ati1_id', $idAtividade)
            ->join('lote', 'lote.lot_id', 'atividade1.lot_id')
            ->join('projeto', 'projeto.pro_id', 'lote.pro_id')
            ->where('lote.lot_id', $idLote)
            ->where('projeto.pro_id', $idProjeto)
            ->get();

        $atividade = DB::select('SELECT projeto.pro_id, lote.lot_id, atividade1.ati1_id, atividade1.at1_nome,
        atividade2.ati2_id, atividade2.ati2_codigo, atividade2.ati2_descricao, atividade2.ati2_preco_unidade,
        atividade2.ati2_quantidade,  atividade2.uni_id,
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
        WHERE atividade1.ati1_id = ? AND lote.lot_id = ? AND projeto.pro_id = ?', [$idAtividade, $idLote, $idProjeto]);
        if (isset($single[0]->lot_id)) {
            $nomeAtividade = '- ' . $single[0]->at1_nome;
            $nomeProjeto = '- ' . $single[0]->pro_nome;
            $nomeLote = '- ' . $single[0]->lot_nome;
            $idAtividade = $single[0]->ati1_id;
        }

        return view('user.visualizarLoteProjetoAtividadeUnico', compact('itensMenu', 'atividade', 'nomeAtividade', 'nomeProjeto', 'nomeLote', 'idAtividade'));
    }


    public function visualizarAtividades()
    {
        $itensMenu = $this->sidebar(Auth::user()->tip_usu_id);

        $getProjetos = DB::select('SELECT projeto.pro_id, lote.lot_id, atividade1.at1_nome, atividade1.ati1_codigo , atividade1.ati1_id,
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

    public function visualizarAtividadeUnica($idAtividade, $idLote, $idProjeto)
    {
        $itensMenu = $this->sidebar(Auth::user()->tip_usu_id);

        $single = Atividade1::where('atividade1.ati1_id', $idAtividade)
            ->join('lote', 'lote.lot_id', 'atividade1.lot_id')
            ->join('projeto', 'projeto.pro_id', 'lote.pro_id')
            ->where('lote.lot_id', $idLote)
            ->where('projeto.pro_id', $idProjeto)
            ->get();

        $atividade = DB::select('SELECT projeto.pro_id, lote.lot_id, atividade1.ati1_id, atividade1.at1_nome,
        atividade2.ati2_id, atividade2.ati2_codigo, atividade2.ati2_descricao, atividade2.ati2_preco_unidade,
        atividade2.ati2_quantidade,  atividade2.uni_id,
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
        WHERE atividade1.ati1_id = ? AND lote.lot_id = ? AND projeto.pro_id = ?', [$idAtividade, $idLote, $idProjeto]);

        if (isset($single[0]->at1_nome)) {
            $nomeAtividade = '- ' . $single[0]->at1_nome;
            $nomeProjeto = '- ' . $single[0]->pro_nome;
            $nomeLote = '- ' . $single[0]->lot_nome;
            $idAtividade = $single[0]->ati1_id;
        }
        return view('user.atividade', compact('itensMenu', 'atividade', 'nomeAtividade', 'nomeProjeto', 'nomeLote', 'idAtividade'));
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
