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

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
  Route::get('/', function () {
    return view('welcome');
  })->name('default');
  Route::get('/home', 'HomeController@index')->name('home');

  Route::resource('usuarios', 'UsuarioController');
  Route::match(['get','post'],'usuarios/jsonlista','UsuarioController@jsonLista')->name('usuarios.jsonlista');
  Route::resource('perfis', 'PerfilController');
  Route::resource('permissoes', 'PermissaoController');
});
