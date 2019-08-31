<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ProjetosDataTable;
use App\DataTables\ProjetosDataTablesEditor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjetosController extends Controller
{
    public function index(ProjetosDataTable $dataTable)
    {
        $itensMenu = $this->sidebar(Auth::user()->tip_usu_id);
        return $dataTable->render('user.visualizarProjetos', compact('itensMenu'));
    }
    public function store(ProjetosDataTablesEditor $editor)
    {
        return $editor->process(request());
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
