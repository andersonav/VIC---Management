<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Projeto;
use App\Lote;
use App\Atividade1;
use App\Atividade2;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->tip_usu_id == 3) {
                Redirect::to('home')->send();
            }
            return $next($request);
        });
    }

    public function getProjetos()
    {
        $projetos = Projeto::get();
        return response()->json($projetos);
    }

    public function getLotes()
    {
        $lotes = Lote::get();
        return response()->json($lotes);
    }

    public function getAtividade1()
    {
        $atividades1 = Atividade1::get();
        return response()->json($atividades1);
    }

    public function getUnidade()
    {
        $unidades = DB::table('unidade')->get();
        return response()->json($unidades);
    }


    public function editarProjetos()
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

        return view('admin.editarProjetos', compact('itensMenu', 'getProjetos'));
    }

    public function editarProjeto(Request $request)
    {
        $this->validateProjeto($request);
        $response = array(
            "data" => 'success'
        );
        $update = Projeto::where('pro_id', $request->idProjeto)->update([
            'pro_nome' => $request->nomeProjeto
        ]);

        return response()->json($response);
    }


    public function deletarProjeto(Request $request)
    {
        $response = array(
            "data" => 'success'
        );
        $update = Projeto::where('pro_id', $request->id)->delete();

        return response()->json($response);
    }

    public function validateProjeto(Request $request)
    {
        return $this->validate($request, [
            'nomeProjeto' => 'required'
        ]);
    }


    public function editarLotes()
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

        return view('admin.editarLotes', compact('itensMenu', 'getProjetos'));
    }

    public function editarLote(Request $request)
    {
        $this->validateLote($request);
        $response = array(
            "data" => 'success'
        );
        $update = Lote::where('lot_id', $request->idLote)->update([
            'lot_nome' => $request->nomeLote,
            'pro_id' => $request->idProjeto
        ]);

        return response()->json($response);
    }


    public function deletarLote(Request $request)
    {
        $response = array(
            "data" => 'success'
        );
        $update = Lote::where('lot_id', $request->id)->delete();

        return response()->json($response);
    }

    public function validateLote(Request $request)
    {
        return $this->validate($request, [
            'nomeLote' => 'required',
            'idProjeto' => 'required',
        ]);
    }


    public function editarAtividades()
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

        $getProjetos = DB::select('SELECT projeto.pro_id, lote.lot_id, atividade1.at1_nome, atividade1.ati1_id, atividade1.ati1_codigo,
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

        return view('admin.editarAtividades', compact('itensMenu', 'getProjetos'));
    }

    public function editarAtividade(Request $request)
    {
        $this->validateAtividade($request);
        $response = array(
            "data" => 'success'
        );
        $update = Atividade1::where('ati1_id', $request->idAtividade)->update([
            'at1_nome' => $request->nomeAtividade,
            'ati1_codigo' => $request->codigo,
            'lot_id' => $request->idLote
        ]);

        return response()->json($response);
    }

    public function deletarAtividade(Request $request)
    {
        $response = array(
            "data" => 'success'
        );
        $update = Atividade1::where('ati1_id', $request->id)->delete();

        return response()->json($response);
    }


    public function editarAtividade2(Request $request)
    {
        $this->validateAtividade2($request);
        $response = array(
            "data" => 'success'
        );
        $update = Atividade2::where('ati2_id', $request->idAtividade)->update([
            'ati1_id' => $request->idAtividade1,
            'ati2_quantidade' => $request->quantidade,
            'ati2_preco_unidade' => $request->precoUnidade,
            'ati2_codigo' => $request->codigo,
            'ati2_descricao' => $request->descricaoAtividade,
            'ati2_faturado' => $request->faturado,
            'uni_id' => $request->idUnidade
        ]);

        return response()->json($response);
    }


    public function validateAtividade(Request $request)
    {
        return $this->validate($request, [
            'nomeAtividade' => 'required',
            'codigo' => 'required',
            'idLote' => 'required',
        ]);
    }

    public function validateAtividade2(Request $request)
    {
        return $this->validate($request, [
            'idAtividade1' => 'required',
            'precoUnidade' => 'required',
            'quantidade' => 'required',
            'codigo' => 'required',
            'descricaoAtividade' => 'required',
            'idUnidade' => 'required',
            'faturado' => 'required'
        ]);
    }

    public function addAtividade2(Request $request)
    {
        $this->validateAtividade2($request);
        $response = array(
            "data" => 'success'
        );
        $create = Atividade2::create([
            'ati1_id' => $request->idAtividade1,
            'ati2_quantidade' => $request->quantidade,
            'ati2_preco_unidade' => $request->precoUnidade,
            'ati2_codigo' => $request->codigo,
            'ati2_descricao' => $request->descricaoAtividade,
            'ati2_faturado' => $request->faturado,
            'uni_id' => $request->idUnidade
        ]);

        return response()->json($request);
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




        $atividade = DB::select('SELECT projeto.pro_id, lote.lot_id, atividade1.ati1_id, atividade1.at1_nome,
        atividade2.ati2_id, atividade2.ati2_codigo, atividade2.ati2_descricao, atividade2.ati2_preco_unidade,
        atividade2.ati2_quantidade,  atividade2.uni_id,
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

        if (isset($atividade[0]->at1_nome) && isset($atividade[0]->ati1_id)) {
            $nomeAtividade = $atividade[0]->at1_nome;
            $idAtividade = $atividade[0]->ati1_id;
        }
        return view('admin.atividade', compact('itensMenu', 'atividade', 'nomeAtividade', 'idAtividade'));
    }
}
