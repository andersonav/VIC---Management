<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Projeto;
use App\Lote;
use App\Atividade1;
use App\Atividade2;
use Illuminate\Support\Facades\Redirect;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->tip_usu_id != 1) {
                Redirect::to('home')->send();
            }
            return $next($request);
        });
    }

    public function cadastrarProjetos()
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


        return view('superAdmin.cadastrarProjetos', compact('itensMenu'));
    }

    public function cadastrarProjeto(Request $request)
    {
        $this->validateCadastro($request);
        $response = array(
            "data" => 'success'
        );
        $create = Projeto::create([
            'pro_nome' => $request->nomeProjeto
        ]);

        return response()->json($request);
    }

    public function deletarProjeto(Request $request)
    {
        $response = array(
            "data" => 'success'
        );
        $update = Projeto::where('pro_id', $request->id)->delete();

        return response()->json($response);
    }

    public function cadastrarLotes()
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

        return view('superAdmin.cadastrarLotes', compact('itensMenu'));
    }

    public function cadastrarLote(Request $request)
    {
        $this->validateCadastroLote($request);
        $response = array(
            "data" => 'success'
        );
        $create = Lote::create([
            'lot_nome' => $request->nomeLote,
            'pro_id' => $request->idProjeto
        ]);

        return response()->json($request);
    }

    public function deletarLote(Request $request)
    {
        $response = array(
            "data" => 'success'
        );
        $update = Lote::where('lot_id', $request->id)->delete();

        return response()->json($response);
    }


    public function cadastrarAtividades()
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

        return view('superAdmin.cadastrarAtividades', compact('itensMenu'));
    }

    public function cadastrarAtividade(Request $request)
    {
        $this->validateCadastroAtividade($request);
        $response = array(
            "data" => 'success'
        );
        $create = Atividade1::create([
            'lot_id' => $request->idLote,
            'ati1_codigo' => $request->codigo,
            'at1_nome' => $request->nomeAtividade
        ]);

        return response()->json($request);
    }


    public function deletarAtividade(Request $request)
    {
        $response = array(
            "data" => 'success'
        );
        $update = Atividade1::where('ati1_id', $request->id)->delete();

        return response()->json($response);
    }


    public function deletarAtividade2(Request $request)
    {
        $response = array(
            "data" => 'success'
        );
        $update = Atividade2::where('ati2_id', $request->id)->delete();

        return response()->json($response);
    }

    public function validateCadastro(Request $request)
    {
        return $this->validate($request, [
            'nomeProjeto' => 'required'
        ]);
    }

    public function validateCadastroLote(Request $request)
    {
        return $this->validate($request, [
            'nomeLote' => 'required',
            'idProjeto' => 'required'
        ]);
    }


    public function validateCadastroAtividade(Request $request)
    {
        return $this->validate($request, [
            'idLote' => 'required',
            'nomeAtividade' => 'required',
            'codigo' => 'required'
        ]);
    }
}
