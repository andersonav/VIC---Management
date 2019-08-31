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
    return redirect('home');
});

Route::resource('users', 'UsersController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/projetos', 'ProjetosController@index')->name('visualizarProjetos');
Route::post('/projetos/store', 'ProjetosController@store')->name('storeProjetos');






Route::get('/projetos/{id}', 'UserController@visualizarProjetoUnico')->name('visualizarProjetoUnico');
Route::get('/projetos/{idProjeto}/lote/{idLote}', 'UserController@visualizarProjetoLoteUnico')->name('visualizarProjetoLoteUnico');
Route::get('/projetos/{idProjeto}/lote/{idLote}/atividade/{idAtividade}', 'UserController@visualizarProjetoLoteAtividadeUnico')->name('visualizarProjetoLoteAtividadeUnico');
Route::get('/visualizarAtividades', 'UserController@visualizarAtividades')->name('visualizarAtividades');

Route::get('/atividade/{id}', 'UserController@atividadeUnica')->name('atividadeUnica');

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () { });

/* ADMIN */

Route::post('/getProjetos', 'AdminController@getProjetos')->name('getProjetos');
Route::post('/getLotes', 'AdminController@getLotes')->name('getLotes');
Route::post('/getAtividade1', 'AdminController@getAtividade1')->name('getAtividade1');
Route::post('/getUnidade', 'AdminController@getUnidade')->name('getUnidade');

/* PROJETOS */
Route::post('deletarProjeto', 'SuperAdminController@deletarProjeto')->name('deletarProjeto');
Route::post('editarProjeto', 'AdminController@editarProjeto')->name('editarProjeto');

/* LOTES */

Route::get('/lotes', 'UserController@visualizarLotes')->name('visualizarLotes');
Route::get('/lotes/{idLote}/projetos/{idProjeto}', 'UserController@visualizarLoteUnico')->name('visualizarLoteProjetoUnico');
Route::get('/lotes/{idLote}/projetos/{idProjeto}/atividade/{idAtividade}', 'UserController@visualizarLoteProjetoAtividadeUnico')->name('visualizarLoteProjetoAtividadeUnico');

Route::post('/editarLote', 'AdminController@editarLote')->name('editarLote');
Route::post('/deletarLote', 'SuperAdminController@deletarLote')->name('deletarLote');

/* ATIVIDADES */
Route::get('/atividades', 'UserController@visualizarAtividades')->name('visualizarAtividades');
Route::get('/atividades/{idAtividade}/lote/{idLote}/projeto/{idProjeto}', 'UserController@visualizarAtividadeUnica')->name('visualizarAtividadeUnica');
Route::post('/editarAtividade', 'AdminController@editarAtividade')->name('editarAtividade');
Route::post('/editarAtividade2', 'AdminController@editarAtividade2')->name('editarAtividade2');
Route::post('/deletarAtividade', 'SuperAdminController@deletarAtividade')->name('deletarAtividade');
Route::post('/deletarAtividade2', 'SuperAdminController@deletarAtividade2')->name('deletarAtividade2');
Route::post('/addAtividade2', 'AdminController@addAtividade2')->name('addAtividade2');

/* SUPER ADMIN */

/* CADASTRAR PROJETOS */
Route::post('/cadastrarProjeto', 'SuperAdminController@cadastrarProjeto')->name('cadastrarProjeto');

/* CADASTRAR LOTES */
Route::post('/cadastrarLote', 'SuperAdminController@cadastrarLote')->name('cadastrarLote');

/* CADASTRAR ATIVIDADES */
Route::post('/cadastrarAtividade', 'SuperAdminController@cadastrarAtividade')->name('cadastrarAtividade');
