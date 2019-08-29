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

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::get('/visualizarProjetos', 'UserController@visualizarProjetos')->name('visualizarProjetos');
    Route::get('/visualizarLotes', 'UserController@visualizarLotes')->name('visualizarLotes');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/visualizarProjetos', 'UserController@visualizarProjetos')->name('visualizarProjetos');
    Route::get('/visualizarLotes', 'UserController@visualizarLotes')->name('visualizarLotes');

    Route::get('/getProjetos', 'AdminController@getProjetos')->name('getProjetos');

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
});

Route::group(['prefix' => 'superAdmin', 'middleware' => 'auth'], function () {
    Route::get('/visualizarProjetos', 'UserController@visualizarProjetos')->name('visualizarProjetos');
    Route::get('/visualizarLotes', 'UserController@visualizarLotes')->name('visualizarLotes');

    Route::post('/getProjetos', 'AdminController@getProjetos')->name('getProjetos');
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
});
