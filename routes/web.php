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

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::get('/visualizarProjetos', 'UserController@visualizarProjetos')->name('visualizarProjetos');
    Route::get('/visualizarLotes', 'UserController@visualizarLotes')->name('visualizarLotes');
    Route::get('/visualizarAtividades', 'UserController@visualizarAtividades')->name('visualizarAtividades');

    Route::get('/atividade/{id}', 'UserController@atividadeUnica')->name('atividadeUnica');
});

/* ADMIN */

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/visualizarProjetos', 'UserController@visualizarProjetos')->name('visualizarProjetos');
    Route::get('/visualizarLotes', 'UserController@visualizarLotes')->name('visualizarLotes');
    Route::get('/visualizarAtividades', 'UserController@visualizarAtividades')->name('visualizarAtividades');
    Route::post('/getProjetos', 'AdminController@getProjetos')->name('getProjetos');
    Route::post('/getLotes', 'AdminController@getLotes')->name('getLotes');
    Route::post('/getAtividade1', 'AdminController@getAtividade1')->name('getAtividade1');
    Route::post('/getUnidade', 'AdminController@getUnidade')->name('getUnidade');
    Route::get('/atividade/{id}', 'UserController@atividadeUnica')->name('atividadeUnica');
    Route::group(['prefix' => 'editarProjetos'], function () {
        Route::get('/', 'AdminController@editarProjetos')->name('editarProjetos');
        Route::post('/editarProjeto', 'AdminController@editarProjeto')->name('editarProjeto');
        Route::post('/deletarProjeto', 'AdminController@deletarProjeto')->name('deletarProjeto');
    });

    Route::group(['prefix' => 'editarLotes'], function () {
        Route::get('/', 'AdminController@editarLotes')->name('editarLotes');
        Route::post('/editarLote', 'AdminController@editarLote')->name('editarLote');
        Route::post('/deletarLote', 'AdminController@deletarLote')->name('deletarLote');
    });

    Route::group(['prefix' => 'editarAtividades'], function () {
        Route::get('/', 'AdminController@editarAtividades')->name('editarAtividades');
        Route::post('/editarAtividade', 'AdminController@editarAtividade')->name('editarAtividade');
        Route::post('/editarAtividade2', 'AdminController@editarAtividade2')->name('editarAtividade2');
        Route::post('/deletarAtividade', 'AdminController@deletarAtividade')->name('deletarAtividade');

        Route::get('/{id}', 'AdminController@atividadeUnica')->name('atividadeUnicaAdmin');

        Route::post('/addAtividade2', 'AdminController@addAtividade2')->name('addAtividade2');
    });
});

/* SUPER ADMIN */

Route::group(['prefix' => 'superAdmin', 'middleware' => 'auth'], function () {
    Route::get('/visualizarProjetos', 'UserController@visualizarProjetos')->name('visualizarProjetos');
    Route::get('/visualizarLotes', 'UserController@visualizarLotes')->name('visualizarLotes');
    Route::get('/visualizarAtividades', 'UserController@visualizarAtividades')->name('visualizarAtividades');
    Route::post('/getProjetos', 'AdminController@getProjetos')->name('getProjetos');
    Route::post('/getLotes', 'AdminController@getLotes')->name('getLotes');
    Route::post('/getAtividade1', 'AdminController@getAtividade1')->name('getAtividade1');
    Route::post('/getUnidade', 'AdminController@getUnidade')->name('getUnidade');


    Route::group(['prefix' => 'editarProjetos'], function () {
        Route::get('/', 'AdminController@editarProjetos')->name('editarProjetos');
        Route::post('/editarProjeto', 'AdminController@editarProjeto')->name('editarProjeto');
        Route::post('/deletarProjeto', 'AdminController@deletarProjeto')->name('deletarProjeto');
    });

    Route::group(['prefix' => 'cadastrarProjetos'], function () {
        Route::get('/', 'SuperAdminController@cadastrarProjetos')->name('cadastrarProjetos');
        Route::post('/cadastrarProjeto', 'SuperAdminController@cadastrarProjeto')->name('cadastrarProjeto');
    });

    Route::group(['prefix' => 'editarLotes'], function () {
        Route::get('/', 'AdminController@editarLotes')->name('editarLotes');
        Route::post('/editarLote', 'AdminController@editarLote')->name('editarLote');
        Route::post('/deletarLote', 'AdminController@deletarLote')->name('deletarLote');
    });


    Route::group(['prefix' => 'cadastrarLotes'], function () {
        Route::get('/', 'SuperAdminController@cadastrarLotes')->name('cadastrarLote');
        Route::post('/cadastrarLote', 'SuperAdminController@cadastrarLote')->name('cadastrarLote');
    });


    Route::group(['prefix' => 'editarAtividades'], function () {
        Route::get('/', 'AdminController@editarAtividades')->name('editarAtividades');
        Route::post('/editarAtividade', 'AdminController@editarAtividade')->name('editarAtividade');
        Route::post('/editarAtividade2', 'AdminController@editarAtividade2')->name('editarAtividade2');
        Route::post('/deletarAtividade', 'AdminController@deletarAtividade')->name('deletarAtividade');

        Route::get('/{id}', 'AdminController@atividadeUnica')->name('atividadeUnicaAdmin');

        Route::post('/addAtividade2', 'AdminController@addAtividade2')->name('addAtividade2');
    });
});
