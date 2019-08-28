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
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/visualizarProjetos', 'UserController@visualizarProjetos')->name('visualizarProjetos');
    Route::group(['prefix' => 'editarProjetos'], function () {
        Route::get('/', 'AdminController@editarProjetos')->name('editarProjetos');
        Route::post('/editarProjeto', 'AdminController@editarProjeto')->name('editarProjeto');
        Route::post('/deletarProjeto', 'AdminController@deletarProjeto')->name('deletarProjeto');
    });
});

Route::group(['prefix' => 'superAdmin', 'middleware' => 'auth'], function () {
    Route::get('/visualizarProjetos', 'UserController@visualizarProjetos')->name('visualizarProjetos');
    Route::group(['prefix' => 'editarProjetos'], function () {
        Route::get('/', 'AdminController@editarProjetos')->name('editarProjetos');
        Route::post('/editarProjeto', 'AdminController@editarProjeto')->name('editarProjeto');
        Route::post('/deletarProjeto', 'AdminController@deletarProjeto')->name('deletarProjeto');
    });

    Route::group(['prefix' => 'cadastrarProjetos'], function () {
        Route::get('/', 'SuperAdminController@cadastrarProjetos')->name('cadastrarProjetos');
        Route::post('/cadastrarProjeto', 'SuperAdminController@cadastrarProjeto')->name('cadastrarProjeto');
    });
});
