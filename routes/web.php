<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/* USER */

/* VISUALIZAÇÃO */


Route::get('/visualizarProjetos', 'UserController@visualizarProjetos')->name('visualizarProjetos');
Route::get('/visualizarLotes', 'UserController@visualizarLotes')->name('visualizarLotes');
Route::get('/visualizarLotes/{id}', 'UserController@visualizarLoteUnico')->name('visualizarLoteUnico');
Route::get('/visualizarProjetos/{id}', 'UserController@visualizarProjetoUnico')->name('visualizarProjetoUnico');
Route::get('/visualizarAtividades', 'UserController@visualizarAtividades')->name('visualizarAtividades');

Route::get('/atividade/{id}', 'UserController@atividadeUnica')->name('atividadeUnica');

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () { });

/* ADMIN */

Route::post('/getProjetos', 'AdminController@getProjetos')->name('getProjetos');
Route::post('/getLotes', 'AdminController@getLotes')->name('getLotes');
Route::post('/getAtividade1', 'AdminController@getAtividade1')->name('getAtividade1');
Route::post('/getUnidade', 'AdminController@getUnidade')->name('getUnidade');

/* EDITAR PROJETOS */

Route::group(['prefix' => 'editarProjetos'], function () {
    Route::get('/', 'AdminController@editarProjetos')->name('editarProjetos');
    Route::post('/editarProjeto', 'AdminController@editarProjeto')->name('editarProjeto');
    Route::post('/deletarProjeto', 'SuperAdminController@deletarProjeto')->name('deletarProjeto');
    Route::get('/visualizarProjetos/{id}', 'AdminController@visualizarProjetoUnico')->name('visualizarProjetoUnicoAdm');
});

/* EDITAR LOTES */

Route::group(['prefix' => 'editarLotes'], function () {
    Route::get('/', 'AdminController@editarLotes')->name('editarLotes');
    Route::post('/editarLote', 'AdminController@editarLote')->name('editarLote');
    Route::get('/visualizarLotes/{id}', 'AdminController@visualizarLoteUnico')->name('visualizarLoteUnicoAdm');
    Route::post('/deletarLote', 'SuperAdminController@deletarLote')->name('deletarLote');
});

/* EDITAR ATIVIDADES */

Route::group(['prefix' => 'editarAtividades'], function () {
    Route::get('/', 'AdminController@editarAtividades')->name('editarAtividades');
    Route::post('/editarAtividade', 'AdminController@editarAtividade')->name('editarAtividade');
    Route::post('/editarAtividade2', 'AdminController@editarAtividade2')->name('editarAtividade2');
    Route::post('/deletarAtividade', 'SuperAdminController@deletarAtividade')->name('deletarAtividade');
    Route::get('/{id}', 'AdminController@atividadeUnica')->name('atividadeUnicaAdmin');
    Route::post('/{id}/deletarAtividade2', 'SuperAdminController@deletarAtividade2')->name('deletarAtividade2');
    Route::post('/addAtividade2', 'AdminController@addAtividade2')->name('addAtividade2');
});

/* SUPER ADMIN */

/* CADASTRAR PROJETOS */

Route::group(['prefix' => 'cadastrarProjetos'], function () {
    Route::get('/', 'SuperAdminController@cadastrarProjetos')->name('cadastrarProjetos');
    Route::post('/cadastrarProjeto', 'SuperAdminController@cadastrarProjeto')->name('cadastrarProjeto');
});

/* CADASTRAR LOTES */

Route::group(['prefix' => 'cadastrarLotes'], function () {
    Route::get('/', 'SuperAdminController@cadastrarLotes')->name('cadastrarLote');
    Route::post('/cadastrarLote', 'SuperAdminController@cadastrarLote')->name('cadastrarLote');
});

/* CADASTRAR ATIVIDADES */

Route::group(['prefix' => 'cadastrarAtividades'], function () {
    Route::get('/', 'SuperAdminController@cadastrarAtividades')->name('cadastrarAtividades');
    Route::post('/cadastrarAtividade', 'SuperAdminController@cadastrarAtividade')->name('cadastrarAtividade');
});
