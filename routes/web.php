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

Route::get('/projetos/{idProjeto}', 'LotesController@index')->name('lotesPorProjeto');
Route::post('/projetos/getLotes', 'LotesController@returnJson')->name('returnJsonLotesByProjeto');
Route::post('/projetos/lote/store', 'LotesController@store')->name('storeLotes');

Route::get('/projetos/{idProjeto}/lote/{idLote}', 'Atividade1Controller@index')->name('atividade1PorLote');
Route::post('/projetos/lote/atividade1', 'Atividade1Controller@returnJson')->name('returnJson');
Route::post('/projetos/lote/atividade1/store', 'Atividade1Controller@store')->name('storeAtividades1');

// Route::get('/projetos/{idProjeto}/lote/{idLote}/{idAtividade1}', 'Atividade2Controller@index')->name('atividade2PorAtividade1');
Route::post('/projetos/lote/atividade1/getAtividade2', 'Atividade2Controller@returnJson')->name('atividade2PorAtividade1');
Route::post('/projetos/lote/atividade1/atividade2/store', 'Atividade2Controller@store')->name('storeAtividades2');

Route::post('/getProjetos', 'AdminController@getProjetos')->name('getProjetos');
Route::post('/getLotes', 'AdminController@getLotes')->name('getLotes');
Route::post('/getAtividade1', 'AdminController@getAtividade1')->name('getAtividade1');
Route::post('/getUnidade', 'AdminController@getUnidade')->name('getUnidade');
