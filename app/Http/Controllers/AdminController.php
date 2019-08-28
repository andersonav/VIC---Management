<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
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

    public function editarProjeto()
    {
        return view('admin.editarProjeto');
    }
}
